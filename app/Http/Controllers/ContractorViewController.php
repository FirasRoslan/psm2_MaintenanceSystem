<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use App\Models\Task;
use App\Models\ContractorLandlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('contractor.dashboard', compact('approvedLandlords', 'pendingRequests', 'recentlyApprovedLandlords'));
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
            'specialization' => 'required|string',
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
        $contractorLandlord->specialization = $validated['specialization'];
        $contractorLandlord->approval_status = null; // Pending approval
        $contractorLandlord->save();
        
        return redirect()->route('contractor.dashboard')
            ->with('success', 'Your request has been submitted and is pending approval from the landlord.');
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
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);
        
        // Check if the task belongs to this contractor
        $user = Auth::user();
        if ($task->userID != $user->userID) {
            return back()->with('error', 'You do not have permission to update this task.');
        }
        
        // Update the task status
        $task->task_status = $request->status;
        
        // If task is completed, set the completed_at timestamp
        if ($request->status == 'Completed') {
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
    public function viewLandlordProfile(User $landlord)
    {
        // Check if the landlord exists and is a landlord
        if (!$landlord || $landlord->role !== 'landlord') {
            return redirect()->route('contractor.dashboard')
                ->with('error', 'Invalid landlord selected.');
        }
        
        // Check if the contractor is approved by this landlord
        $user = Auth::user();
        $relationship = ContractorLandlord::where('contractorID', $user->userID)
            ->where('landlordID', $landlord->userID)
            ->where('approval_status', true)
            ->first();
            
        if (!$relationship) {
            return redirect()->route('contractor.dashboard')
                ->with('error', 'You are not approved to view this landlord\'s profile.');
        }
        
        // Get all properties owned by this landlord
        $properties = House::where('userID', $landlord->userID)->get();
        
        // Get tasks assigned by this landlord
        $tasks = Task::whereHas('report.room.house', function($query) use ($landlord) {
            $query->where('userID', $landlord->userID);
        })
        ->where('userID', $user->userID)
        ->with(['report.room.house', 'report.item'])
        ->latest()
        ->take(5)
        ->get();
        
        return view('contractor.landlord-profile', compact('landlord', 'properties', 'relationship', 'tasks'));
    }
}