<x-lecturer-layout>
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/10 pb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Student Lists</h2>
                <p class="text-gray-400 text-sm mt-1">View all students enrolled in your courses.</p>
            </div>

            <form method="GET" action="{{ route('lecturer.students') }}" class="flex items-center gap-3">
                <label for="course_code" class="text-gray-300 font-semibold text-sm">Filter by Course:</label>
                <div class="relative">
                    <select name="course_code" onchange="this.form.submit()" 
                            class="bg-[#2a2e4b] border border-gray-600 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-64 p-2.5">
                        <option value="">All Courses</option>
                        @foreach($allCourses as $course)
                            <option value="{{ $course->courseCode }}" {{ request('course_code') == $course->courseCode ? 'selected' : '' }}>
                                {{ $course->courseCode }} - {{ Str::limit($course->courseName, 20) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="bg-[#2a2e4b] rounded-xl shadow-xl border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="p-4 text-cyan-300 font-bold uppercase text-xs tracking-wider">Matric Num</th>
                            <th class="p-4 text-cyan-300 font-bold uppercase text-xs tracking-wider">Student Name</th>
                            <th class="p-4 text-cyan-300 font-bold uppercase text-xs tracking-wider">Course Code</th>
                            <th class="p-4 text-cyan-300 font-bold uppercase text-xs tracking-wider">Course Name</th>
                            <th class="p-4 text-cyan-300 font-bold uppercase text-xs tracking-wider">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($enrollments as $student)
                            <tr class="hover:bg-white/5 transition-colors duration-150">
                                <td class="p-4 text-white font-mono text-sm">{{ $student->matric }}</td>
                                <td class="p-4 text-white font-semibold">{{ $student->name }}</td>
                                <td class="p-4 text-yellow-300 font-mono text-sm">{{ $student->course_code }}</td>
                                <td class="p-4 text-gray-300 text-sm">{{ $student->course_name }}</td>
                                <td class="p-4 text-gray-400 text-sm">{{ $student->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 italic">
                                    No students found for the selected criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-white/10 bg-black/20 text-right">
                <span class="text-sm text-gray-400">Total Records: <span class="text-white font-bold">{{ $enrollments->count() }}</span></span>
            </div>
        </div>
    </div>
</x-lecturer-layout>