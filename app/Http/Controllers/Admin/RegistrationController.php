<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Student;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the registrations.
     */
    public function index(Request $request)
    {
        $query = DB::table('registration')
            ->join('student', 'registration.matricNum', '=', 'student.matricNum')
            ->join('course', 'registration.courseCode', '=', 'course.courseCode')
            ->select(
                'registration.*',
                'student.fName',
                'student.lName',
                'student.progCode',
                'course.courseName',
                'course.courseCreds',
                'course.courseSem'
            );

        // 1. FILTER: Hide 'Cancelled' by default to keep the list clean
        // Only show them if the admin specifically filters for 'Cancelled' or 'All'
        if ($request->input('status') !== 'Cancelled' && $request->input('status') !== 'all') {
            $query->where('registration.status', '!=', 'Cancelled');
        }

        // Optional Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student.fName', 'like', "%$search%")
                  ->orWhere('student.lName', 'like', "%$search%")
                  ->orWhere('registration.matricNum', 'like', "%$search%")
                  ->orWhere('registration.courseCode', 'like', "%$search%");
            });
        }

        // Filter by Status (Specific)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('registration.status', $request->status);
        }

        $registrations = $query->orderBy('registration.registrationDate', 'desc')
                               ->orderBy('registration.registrationTime', 'desc')
                               ->paginate(10)
                               ->appends($request->query());

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Update the status of a registration.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'matricNum' => 'required',
            'courseCode' => 'required',
            'action' => 'required|in:approve,disapprove,cancel,amend',
            'new_status' => 'nullable|string' // For amendment
        ]);

        $matricNum = $request->matricNum;
        $courseCode = $request->courseCode;
        $action = $request->action;

        // Fetch current record
        $registration = DB::table('registration')
            ->where('matricNum', $matricNum)
            ->where('courseCode', $courseCode)
            ->first();

        if (!$registration) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        $status = $registration->status;

        // Logic based on Action
        switch ($action) {
            case 'approve':
                // Check if already approved
                if ($status === 'Approved') {
                    return redirect()->back()->with('error', 'Registration is already approved.');
                }
                $newStatus = 'Approved';
                $message = 'Registration approved successfully.';
                break;

            case 'disapprove':
                // Only allow if currently Approved
                if ($status !== 'Approved') {
                    return redirect()->back()->with('error', 'Only approved registrations can be disapproved.');
                }
                $newStatus = 'Disapproved';
                $message = 'Registration disapproved.';
                break;

            case 'cancel':
                // UPDATE: Allow admins to cancel Approved courses too (Manual Override)
                if (!in_array($status, ['Waiting for Approval', 'Approved', 'Pending'])) {
                    return redirect()->back()->with('error', 'Cannot cancel a registration with this status.');
                }
                $newStatus = 'Cancelled';
                $message = 'Registration cancelled (Withdrawn).';
                break;
            
            case 'amend':
                // General override
                $newStatus = $request->new_status;
                $message = 'Registration amended successfully.';
                break;

            default:
                return redirect()->back()->with('error', 'Invalid action.');
        }

        // Execute Update
        DB::table('registration')
            ->where('matricNum', $matricNum)
            ->where('courseCode', $courseCode)
            ->update([
                'status' => $newStatus,
                // Optional: You might want to update the timestamp to reflect the admin action
                // 'updated_at' => now(), 
            ]);

        return redirect()->back()->with('success', $message);
    }
}