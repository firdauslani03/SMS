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

        // Filter by Status
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
                // Only allow if Waiting for Approval
                if ($status !== 'Waiting for Approval') {
                    return redirect()->back()->with('error', 'Only pending registrations can be cancelled.');
                }
                $newStatus = 'Cancelled';
                $message = 'Registration cancelled.';
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
                // Optional: Update modification timestamp?
                // 'registrationDate' => now()->toDateString(), 
            ]);

        return redirect()->back()->with('success', $message);
    }
}