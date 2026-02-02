<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Programme;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::with(['lecturer', 'programme'])
                    ->orderBy('courseSem')
                    ->orderBy('courseCode')
                    ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $lecturers = Lecturer::all();
        $programmes = Programme::all();
        
        return view('admin.courses.create', compact('lecturers', 'programmes'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'courseCode' => 'required|string|unique:course,courseCode|max:20', // Unique check
            'courseName' => 'required|string|max:255',
            'courseCreds' => 'required|integer|min:1',
            'courseCapacity' => 'required|integer|min:1',
            'courseSem' => 'required|integer',
            'courseLocBuilding' => 'required|string',
            'courseLocRoom' => 'required|string',
            'courseDate' => 'required|string',
            // Time Inputs
            'courseTimeStart' => 'required|date_format:H:i',
            'courseTimeEnd' => 'required|date_format:H:i|after:courseTimeStart',
            // Foreign Keys
            'staffNum' => 'required|exists:lecturer,staffNum',
            'progCode' => 'required|exists:programme,progCode',
        ]);

        // Merge Time
        $validated['courseTime'] = $validated['courseTimeStart'] . ' - ' . $validated['courseTimeEnd'];
        
        // Remove helper fields
        unset($validated['courseTimeStart']);
        unset($validated['courseTimeEnd']);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course {$validated['courseCode']} created successfully.");
    }

    /**
     * Display the specified course details.
     */
    public function show($courseCode)
    {
        $course = Course::with(['lecturer', 'programme', 'students'])->findOrFail($courseCode);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($courseCode)
    {
        $course = Course::findOrFail($courseCode);
        $lecturers = Lecturer::all();
        $programmes = Programme::all();

        // SPLIT LOGIC
        $times = explode('-', $course->courseTime); 
        $startTime = trim($times[0] ?? '');
        $endTime = trim($times[1] ?? '');
        
        return view('admin.courses.edit', compact('course', 'lecturers', 'programmes', 'startTime', 'endTime'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $courseCode)
    {
        $course = Course::findOrFail($courseCode);
        
        $validated = $request->validate([
            'courseName' => 'required|string|max:255',
            'courseCreds' => 'required|integer|min:1',
            'courseCapacity' => 'required|integer|min:1',
            'courseSem' => 'required|integer',
            'courseLocBuilding' => 'required|string',
            'courseLocRoom' => 'required|string',
            'courseDate' => 'required|string',
            'courseTimeStart' => 'required|date_format:H:i',
            'courseTimeEnd' => 'required|date_format:H:i|after:courseTimeStart',
            'staffNum' => 'required|exists:lecturer,staffNum',
            // Note: usually we don't update progCode or courseCode after creation to maintain integrity, 
            // but if you need to, add them here.
        ]);

        $validated['courseTime'] = $validated['courseTimeStart'] . ' - ' . $validated['courseTimeEnd'];
        
        unset($validated['courseTimeStart']);
        unset($validated['courseTimeEnd']);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course {$courseCode} updated successfully.");
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy($courseCode)
    {
        $course = Course::findOrFail($courseCode);
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "Course {$courseCode} deleted successfully.");
    }
}