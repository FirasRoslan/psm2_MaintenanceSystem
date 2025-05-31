<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use App\Models\Task;
use App\Models\ContractorLandlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    
    public function updateTaskStatus(Request $request, Task $task)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);
        
        // Check if the task belongs to this contractor
        $user = Auth::user();
        if ($task->userID != $user->userID) {
            return back()->with('error', 'You do not have permission to update this task.');
        }
        
        // Update the task status
        $task->task_status = $request->status;
        
        // If task is completed, set the completed_at timestamp
        if ($request->status == 'completed') {
            $task->completed_at = now();
            
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
}