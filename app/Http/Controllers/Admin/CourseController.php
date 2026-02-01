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
        // Eager load relationships for performance
        $courses = Course::with(['lecturer', 'programme'])
                    ->orderBy('courseSem')
                    ->orderBy('courseCode')
                    ->paginate(10);

        return view('admin.courses.index', compact('courses'));
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

        // SPLIT LOGIC: Assumes format "HH:mm - HH:mm"
        // If courseTime is "08:00 - 10:00", we separate it so the view can pre-fill the inputs.
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
            // Validate the TWO separate time inputs
            'courseTimeStart' => 'required|date_format:H:i',
            'courseTimeEnd' => 'required|date_format:H:i|after:courseTimeStart',
            'staffNum' => 'required|exists:lecturer,staffNum',
        ]);

        // MERGE LOGIC: Combine start and end time back into "HH:mm - HH:mm" string
        $validated['courseTime'] = $validated['courseTimeStart'] . ' - ' . $validated['courseTimeEnd'];
        
        // Remove the temporary fields so they don't break the Model update
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