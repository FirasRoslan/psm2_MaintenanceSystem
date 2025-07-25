<?php

namespace App\Http\Controllers;

use App\Models\HouseTenant;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use App\Models\House;
use App\Models\ContractorLandlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LandlordViewController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get count of pending tenant requests
        $pendingRequestsCount = HouseTenant::whereHas('house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->whereNull('approval_status')
        ->count();
        
        // Get count of pending contractor requests
        $pendingContractorCount = ContractorLandlord::where('landlordID', $user->userID)
            ->whereNull('approval_status')
            ->count();
        
        // Get property statistics
        $propertiesCount = House::where('userID', $user->userID)->count();
        $totalRooms = House::where('userID', $user->userID)->sum('house_number_room');
        $totalToilets = House::where('userID', $user->userID)->sum('house_number_toilet');
        
        // Get tenant statistics
        $approvedTenantsCount = HouseTenant::whereHas('house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('approval_status', true)
        ->count();
        
        // Get maintenance statistics
        $pendingMaintenanceCount = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('report_status', 'Pending')
        ->count();
        
        $inProgressMaintenanceCount = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('report_status', 'In Progress')
        ->count();
        
        $completedMaintenanceCount = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('report_status', 'Completed')
        ->count();
        
        // Get recent maintenance reports
        $recentReports = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->with(['room.house', 'item', 'user'])
        ->latest()
        ->take(5)
        ->get();
        
        // Get recently viewed properties
        $recentProperties = House::where('userID', $user->userID)
            ->with(['approvedTenants', 'pendingTenants'])
            ->latest()
            ->take(3)
            ->get();
        
        // Get approved contractors
        $approvedContractors = $user->approvedContractors()
            ->take(3)
            ->get();
        
        return view('landlord.dashboard', compact(
            'pendingRequestsCount', 
            'pendingContractorCount',
            'propertiesCount',
            'totalRooms',
            'totalToilets',
            'approvedTenantsCount',
            'pendingMaintenanceCount',
            'inProgressMaintenanceCount',
            'completedMaintenanceCount',
            'recentReports',
            'recentProperties',
            'approvedContractors'
        ));
    }
    
    public function maintenanceRequests()
    {
        // Get all reports for properties owned by this landlord
        $user = Auth::user();
        
        // Get reports from houses owned by this landlord
        $reports = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })->with(['room.house', 'item', 'user'])->latest()->paginate(10);
        
        return view('landlord.requests.index', compact('reports'));
    }
    
    // Add the missing methods
    public function updateRequestStatus(Request $request, Report $report)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,Rejected',
        ]);
        
        // Check if the landlord owns the property
        $user = Auth::user();
        $isOwner = $report->room->house->userID == $user->userID;
        
        if (!$isOwner) {
            return back()->with('error', 'You do not have permission to update this report.');
        }
        
        // Update the report status
        $report->report_status = $request->status;
        $report->save();
        
        return back()->with('success', 'Report status updated successfully.');
    }
    
    public function showAssignTaskForm(Report $report)
    {
        // Check if the landlord owns the property
        $user = Auth::user();
        $isOwner = $report->room->house->userID == $user->userID;
        
        if (!$isOwner) {
            return back()->with('error', 'You do not have permission to assign tasks for this report.');
        }
        
        // Get all contractors
        $contractors = User::where('role', 'contractor')->get();
        
        return view('landlord.requests.assign', compact('report', 'contractors'));
    }
    
    public function assignTask(Request $request, Report $report)
    {
        // Validate the request
        $request->validate([
            'userID' => 'required|exists:users,userID',
            'task_type' => 'required|string',
        ]);
        
        // Check if the landlord owns the property
        $user = Auth::user();
        $isOwner = $report->room->house->userID == $user->userID;
        
        if (!$isOwner) {
            return back()->with('error', 'You do not have permission to assign tasks for this report.');
        }
        
        // Create a new task
        $task = new Task();
        $task->reportID = $report->reportID;
        $task->userID = $request->userID;
        $task->task_type = $request->task_type;
        $task->task_status = 'pending'; // Changed from 'Pending' to 'pending'
        $task->save();
        
        // Update the report status to "In Progress"
        $report->report_status = 'In Progress';
        $report->save();
        
        return redirect()->route('landlord.requests.index')
            ->with('success', 'Task assigned successfully to contractor.');
    }
    
    /**
     * Display a listing of contractor requests and approved contractors.
     */
    public function viewContractors()
    {
        $user = Auth::user();
        $approvedContractors = $user->approvedContractors()->get();
        $pendingRequests = $user->pendingContractorRequests()->get();
        
        return view('landlord.contractors.index', compact('approvedContractors', 'pendingRequests'));
    }
    
    /**
     * Display details of a specific contractor.
     */
    public function showContractor($contractorID)
    {
        $user = Auth::user();
        $contractor = User::where('userID', $contractorID)
            ->where('role', 'contractor')
            ->firstOrFail();
        
        // Check if this contractor is approved by the landlord
        $relationship = ContractorLandlord::where('landlordID', $user->userID)
            ->where('contractorID', $contractor->userID)
            ->where('approval_status', true)
            ->firstOrFail();
        
        // Get tasks assigned to this contractor
        $tasks = Task::whereHas('report.room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('userID', $contractor->userID)
        ->with(['report.room.house', 'report.item'])
        ->latest()
        ->get();
        
        return view('landlord.contractors.show', compact('contractor', 'relationship', 'tasks'));
    }
    
    /**
     * Approve a contractor request.
     */
    public function approveContractor(Request $request, $contractorID)
    {
        $user = Auth::user();
        
        // Find the relationship
        $relationship = ContractorLandlord::where('landlordID', $user->userID)
            ->where('contractorID', $contractorID)
            ->first();
        
        if (!$relationship) {
            return back()->with('error', 'Contractor request not found.');
        }
        
        // Update the approval status
        $relationship->approval_status = true;
        $relationship->save();
        
        return back()->with('success', 'Contractor has been approved successfully.');
    }

    /**
     * Reject a contractor request.
     */
    public function rejectContractor(Request $request, $contractorID)
    {
        $user = Auth::user();
        
        // Find the relationship
        $relationship = ContractorLandlord::where('landlordID', $user->userID)
            ->where('contractorID', $contractorID)
            ->first();
        
        if (!$relationship) {
            return back()->with('error', 'Contractor request not found.');
        }
        
        // Update the approval status
        $relationship->approval_status = false;
        $relationship->save();
        
        return back()->with('success', 'Contractor request has been rejected.');
    }
    
    /**
     * Display the history page.
     */
    public function history()
    {
        $user = Auth::user();
        
        // Get completed maintenance reports
        $completedReports = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->where('report_status', 'Completed')
        ->with(['room.house', 'item', 'user', 'tasks'])
        ->latest()
        ->paginate(10);
        
        return view('landlord.history.index', compact('completedReports'));
    }
    
    /**
     * Display all tasks assigned by this landlord with phase progress.
     */
    public function tasks()
    {
        $user = Auth::user();
        
        // Get all tasks for properties owned by this landlord
        $tasks = Task::whereHas('report.room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })
        ->with([
            'report.room.house', 
            'report.item', 
            'contractor',
            'phases' => function($query) {
                $query->orderBy('arrangement_number');
            }
        ])
        ->latest()
        ->get();
        
        // Group tasks by status for better organization
        $tasksByStatus = $tasks->groupBy('task_status');
        
        return view('landlord.tasks.index', compact('tasks', 'tasksByStatus'));
    }
    
    /**
     * Show a specific maintenance request.
     */
    public function showRequest(Report $report)
    {
        $user = Auth::user();
        
        // Ensure the report belongs to a property owned by this landlord
        $report->load(['room.house', 'item', 'user', 'tasks.contractor']);
        
        if ($report->room->house->userID !== $user->userID) {
            abort(403, 'Unauthorized access to this report.');
        }
        
        return view('landlord.requests.show', compact('report'));
    }

    /**
     * Approve a completed task
     */
    public function approveTask(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Ensure the task belongs to a property owned by this landlord
        if ($task->report->room->house->userID !== $user->userID) {
            return back()->with('error', 'Unauthorized access to this task.');
        }
        
        // Ensure the task is in awaiting_approval status
        if ($task->task_status !== 'awaiting_approval') {
            return back()->with('error', 'Task is not awaiting approval.');
        }
        
        try {
            // Update task status to completed
            $task->task_status = 'completed';
            $task->save();
            
            // Update report status
            $task->report->report_status = 'Completed';
            $task->report->save();
            
            return back()->with('success', 'Task approved and marked as completed successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while approving the task: ' . $e->getMessage());
        }
    }

    /**
     * Reject a completed task
     */
    public function rejectTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);
        
        $user = Auth::user();
        
        // Ensure the task belongs to a property owned by this landlord
        if ($task->report->room->house->userID !== $user->userID) {
            abort(403, 'Unauthorized access to this task.');
        }
        
        // Ensure the task is in awaiting_approval status
        if ($task->task_status !== 'awaiting_approval') {
            return back()->with('error', 'Task is not awaiting approval.');
        }
        
        DB::beginTransaction();
        
        try {
            // Update task status back to in_progress
            $task->task_status = 'in_progress';
            $task->task_notes = ($task->task_notes ? $task->task_notes . '\n\n' : '') . 'Rejection Reason: ' . $validated['rejection_reason'];
            $task->completion_image = null; // Clear the completion image
            $task->completion_notes = null; // Clear the completion notes
            $task->submitted_at = null; // Clear the submission timestamp
            $task->save();
            
            // Update report status
            $task->report->report_status = 'In Progress';
            $task->report->save();
            
            DB::commit();
            return back()->with('success', 'Task rejected and sent back to contractor for revision.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'An error occurred while rejecting the task.');
        }
    }
}