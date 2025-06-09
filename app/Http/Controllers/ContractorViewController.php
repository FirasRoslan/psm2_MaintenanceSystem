<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use App\Models\Task;
use App\Models\Phase;
use App\Models\ContractorLandlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContractorViewController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get approved landlords
        $approvedLandlords = $user->approvedLandlords()->get();
        
        // Get pending requests
        $pendingRequests = $user->pendingLandlordRequests()->get();
        
        // Get recently approved landlords (within the last 7 days)
        $recentlyApprovedLandlords = $user->approvedLandlords()
            ->wherePivot('updated_at', '>=', now()->subDays(7))
            ->get();
        
        // Get new tasks assigned to this contractor (within the last 7 days)
        $newTasks = $user->tasks()
            ->with(['report.item', 'report.room.house', 'report.user'])
            ->where('created_at', '>=', now()->subDays(7))
            ->where('task_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get all pending tasks for quick overview
        $pendingTasks = $user->tasks()
            ->with(['report.item', 'report.room.house', 'report.user'])
            ->where('task_status', 'pending')
            ->count();
        
        // Get in-progress tasks
        $inProgressTasks = $user->tasks()
            ->where('task_status', 'in_progress')
            ->count();
        
        return view('contractor.dashboard', compact(
            'approvedLandlords', 
            'pendingRequests', 
            'recentlyApprovedLandlords',
            'newTasks',
            'pendingTasks',
            'inProgressTasks'
        ));
    }
    
    public function findLandlords()
    {
        // Get all landlords
        $landlords = User::where('role', 'landlord')->get();
        
        return view('contractor.find-landlords', compact('landlords'));
    }
    
    public function showLandlordProperties(User $landlord)
    {
        // Check if the landlord exists and is a landlord
        if (!$landlord || $landlord->role !== 'landlord') {
            return redirect()->route('contractor.find-landlords')
                ->with('error', 'Invalid landlord selected.');
        }
        
        // Get all properties owned by this landlord
        $properties = House::where('userID', $landlord->userID)->get();
        
        return view('contractor.landlord-properties', compact('landlord', 'properties'));
    }
    
    public function requestApproval(Request $request)
    {
        $validated = $request->validate([
            'landlordID' => 'required|exists:users,userID',
            'maintenance_scope' => 'required|string',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'required|string|in:Plumbing,Electrical,Carpentry,HVAC,General Maintenance,Painting,Roofing,Landscaping',
        ]);
        
        $user = Auth::user();
        
        // Check if a request already exists
        $existingRequest = ContractorLandlord::where('contractorID', $user->userID)
            ->where('landlordID', $validated['landlordID'])
            ->first();
            
        if ($existingRequest) {
            return back()->with('error', 'You have already sent a request to this landlord.');
        }
        
        // Create a new contractor-landlord relationship
        $contractorLandlord = new ContractorLandlord();
        $contractorLandlord->contractorID = $user->userID;
        $contractorLandlord->landlordID = $validated['landlordID'];
        $contractorLandlord->maintenance_scope = $validated['maintenance_scope'];
        // Convert array to comma-separated string
        $contractorLandlord->specialization = implode(', ', $validated['specializations']);
        $contractorLandlord->approval_status = null; // Pending approval
        $contractorLandlord->save();
        
        return redirect()->route('contractor.find-landlords')
            ->with('success', 'Your request has been submitted successfully and is pending approval from the landlord.');
    }
    
    public function viewApprovedLandlords()
    {
        $user = Auth::user();
        $approvedLandlords = $user->approvedLandlords()->get();
        
        return view('contractor.approved-landlords', compact('approvedLandlords'));
    }
    
    public function viewTasks()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->with(['report.room.house', 'report.item'])->latest()->get();
        
        return view('contractor.tasks', compact('tasks'));
    }
    
    /**
     * Update phase status for a task
     */
    public function updatePhaseStatus(Request $request, $phaseId)
    {
        $validated = $request->validate([
            'phase_status' => 'required|in:pending,in_progress,completed',
            'phase_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $phase = Phase::findOrFail($phaseId);
        $task = $phase->task;
        
        // Ensure the contractor owns this task
        if ($task->userID !== Auth::id()) {
            abort(403, 'Unauthorized access to this phase.');
        }
        
        // Handle image upload if provided
        if ($request->hasFile('phase_image')) {
            // Delete old image if exists
            if ($phase->phase_image) {
                Storage::disk('public')->delete($phase->phase_image);
            }
            
            $imagePath = $request->file('phase_image')->store('phases', 'public');
            $phase->phase_image = $imagePath;
        }
        
        // Update phase status and timestamps
        $phase->phase_status = $validated['phase_status'];
        
        if ($validated['phase_status'] === 'in_progress' && !$phase->start_timestamp) {
            $phase->start_timestamp = now();
        } elseif ($validated['phase_status'] === 'completed') {
            $phase->end_timestamp = now();
        }
        
        $phase->save();
        
        // Update task status based on phase progress
        $this->updateTaskStatusBasedOnPhases($task);
        
        return back()->with('success', 'Phase status updated successfully.');
    }
    
    /**
     * Create phases for a task when contractor accepts it
     */
    public function createTaskPhases(Request $request, Task $task)
    {
        // Ensure the contractor owns this task
        if ($task->userID !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }
        
        // Create default phases if none exist
        if ($task->phases()->count() === 0) {
            $phaseCount = $request->input('phase_count', 3); // Default to 3 phases
            
            for ($i = 1; $i <= $phaseCount; $i++) {
                Phase::create([
                    'taskID' => $task->taskID,
                    'arrangement_number' => $i,
                    'phase_status' => 'pending'
                ]);
            }
            
            return back()->with('success', 'Task phases created successfully.');
        }
        
        return back()->with('info', 'Phases already exist for this task.');
    }
    
    /**
     * Update task status based on phase completion
     */
    private function updateTaskStatusBasedOnPhases(Task $task)
    {
        $phases = $task->phases;
        $totalPhases = $phases->count();
        $completedPhases = $phases->where('phase_status', 'completed')->count();
        $inProgressPhases = $phases->where('phase_status', 'in_progress')->count();
        
        if ($completedPhases === $totalPhases && $totalPhases > 0) {
            $task->task_status = 'completed';
            $task->completed_at = now();
            $task->report->report_status = 'Completed';
            $task->report->save();
        } elseif ($inProgressPhases > 0 || $completedPhases > 0) {
            $task->task_status = 'in_progress';
        }
        
        $task->save();
    }
    
    /**
     * Enhanced updateTaskStatus method
     */
    public function updateTaskStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_status' => 'required|in:pending,in_progress,completed',
            'task_notes' => 'nullable|string|max:1000'
        ]);
        
        // Ensure the contractor owns this task
        if ($task->userID !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }
        
        // Create phases when task is started
        if ($validated['task_status'] === 'in_progress' && $task->task_status === 'pending') {
            $this->createTaskPhases($task);
        }
        
        $task->task_status = $validated['task_status'];
        $task->task_notes = $validated['task_notes'];
        
        if ($validated['task_status'] === 'completed') {
            $task->completed_at = now();
            // Mark all phases as completed
            $task->phases()->update(['phase_status' => 'completed', 'end_timestamp' => now()]);
            // Also update the report status
            $task->report->report_status = 'Completed';
            $task->report->save();
        }
        
        $task->save();
        
        return back()->with('success', 'Task status updated successfully.');
    }
    
    /**
     * View landlord profile and properties
     */
    public function showLandlordProfile($id)
    {
        $contractor = auth()->user();
        $landlord = User::findOrFail($id);
        
        // Check if the contractor is approved by this landlord
        $relationship = ContractorLandlord::where('contractorID', $contractor->userID)
            ->where('landlordID', $landlord->userID)
            ->first();
            
        // Get all properties owned by this landlord
        $properties = House::where('userID', $landlord->userID)->get();
        
        // Get tasks assigned by this landlord
        $tasks = Task::whereHas('report.room.house', function($query) use ($landlord) {
            $query->where('userID', $landlord->userID);
        })
        ->where('userID', $contractor->userID)
        ->with(['report.room.house', 'report.item'])
        ->latest()
        ->take(5)
        ->get();
        
        return view('contractor.landlord-profile', compact('landlord', 'properties', 'relationship', 'tasks'));
    }
    
    /**
     * Alias for showLandlordProfile - used by routes
     */
    public function viewLandlordProfile($id)
    {
        return $this->showLandlordProfile($id);
    }
    
    /**
     * View all requests sent by the contractor
     */
    public function viewRequests()
    {
        $user = Auth::user();
        
        // Get all requests (pending, approved, and rejected)
        $allRequests = ContractorLandlord::where('contractorID', $user->userID)
            ->with('landlord')
            ->latest()
            ->get();
        
        // Separate requests by status
        $pendingRequests = $allRequests->whereNull('approval_status');
        $approvedRequests = $allRequests->where('approval_status', 1);
        $rejectedRequests = $allRequests->where('approval_status', 0);
        
        return view('contractor.requests', compact('allRequests', 'pendingRequests', 'approvedRequests', 'rejectedRequests'));
    }
    
    /**
     * Update maintenance progress - enforces proper workflow
     */
    public function updateMaintenanceProgress(Request $request, Task $task)
    {
        // Ensure the contractor owns this task
        if ($task->userID !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }
        
        // Different validation rules based on action
        if ($request->action === 'submit_completion') {
            $validated = $request->validate([
                'action' => 'required|in:start_work,submit_completion',
                'completion_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'completion_notes' => 'nullable|string|max:1000'
            ]);
        } else {
            $validated = $request->validate([
                'action' => 'required|in:start_work,submit_completion',
                'completion_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'completion_notes' => 'nullable|string|max:1000'
            ]);
        }
        
        DB::beginTransaction();
        
        try {
            if ($validated['action'] === 'start_work') {
                // Move from Pending to In Progress
                if ($task->task_status !== 'pending') {
                    return back()->with('error', 'Task cannot be started from current status.');
                }
                
                $task->task_status = 'in_progress';
                $task->save();
                
                // Update report status
                $task->report->report_status = 'In Progress';
                $task->report->save();
                
                $message = 'Task started successfully. You can now work on the maintenance.';
                
            } elseif ($validated['action'] === 'submit_completion') {
                // Move from In Progress to Awaiting Approval
                if ($task->task_status !== 'in_progress') {
                    return back()->with('error', 'Task must be in progress to submit completion.');
                }
                
                // Handle completion proof image upload
                $completionImagePath = null;
                if ($request->hasFile('completion_image')) {
                    $completionImagePath = $request->file('completion_image')->store('task_completions', 'public');
                }
                
                $task->task_status = 'awaiting_approval';
                $task->completion_image = $completionImagePath;
                $task->completion_notes = $validated['completion_notes'];
                $task->submitted_at = now();
                $task->save();
                
                // Update report status
                $task->report->report_status = 'Awaiting Approval';
                $task->report->save();
                
                $message = 'Completion submitted successfully. Waiting for landlord approval.';
            }
            
            DB::commit();
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'An error occurred while updating the task.');
        }
    }
    
    /**
     * Get maintenance progress status for display
     */
    public function getMaintenanceProgress(Task $task)
    {
        $progress = [
            'pending' => ['status' => 'pending', 'label' => 'Task Assigned', 'icon' => 'fas fa-clock', 'color' => 'secondary'],
            'in_progress' => ['status' => 'in_progress', 'label' => 'Work in Progress', 'icon' => 'fas fa-tools', 'color' => 'info'],
            'awaiting_approval' => ['status' => 'awaiting_approval', 'label' => 'Awaiting Approval', 'icon' => 'fas fa-hourglass-half', 'color' => 'warning'],
            'completed' => ['status' => 'completed', 'label' => 'Completed', 'icon' => 'fas fa-check-circle', 'color' => 'success']
        ];
        
        return $progress;
    }
}