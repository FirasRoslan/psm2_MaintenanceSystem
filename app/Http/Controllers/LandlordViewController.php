<?php

namespace App\Http\Controllers;

use App\Models\HouseTenant;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use App\Models\ContractorLandlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandlordViewController extends Controller
{
    public function dashboard()
    {
        // Get count of pending tenant requests
        $pendingRequestsCount = HouseTenant::whereHas('house', function($query) {
            $query->where('userID', Auth::id());
        })
        ->whereNull('approval_status')
        ->count();
        
        // Get count of pending contractor requests
        $pendingContractorCount = ContractorLandlord::where('landlordID', Auth::id())
            ->whereNull('approval_status')
            ->count();
        
        return view('landlord.dashboard', compact('pendingRequestsCount', 'pendingContractorCount'));
    }
    
    public function maintenanceRequests()
    {
        // Get all reports for properties owned by this landlord
        $user = Auth::user();
        
        // Get reports from houses owned by this landlord
        $reports = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })->with(['room.house', 'item', 'user'])->latest()->get();
        
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
        $task->task_status = 'Pending';
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
}