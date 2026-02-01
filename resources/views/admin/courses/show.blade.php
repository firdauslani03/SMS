<x-admin-layout title="Course Details">
    <div class="animate-fade-in-up">
        <div class="mb-8">
            <a href="{{ route('admin.courses.index') }}" class="text-brand-medium hover:text-white flex items-center gap-2 mb-4 font-bold text-sm">
                &larr; Back to Courses
            </a>
            <h1 class="text-4xl font-extrabold text-brand-white">{{ $course->courseCode }} <span class="text-brand-light font-normal text-2xl mx-2">|</span> {{ $course->courseName }}</h1>
        </div>

        <div class="bg-[#2a2e4b] border border-brand-white/10 rounded-[2rem] p-8 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-brand-medium font-bold uppercase tracking-wider text-sm mb-4">Course Information</h3>
                    <div class="space-y-4 text-brand-light">
                        <p><strong class="text-white block">Description:</strong> {{ $course->courseDesc }}</p>
                        <p><strong class="text-white block">Credits:</strong> {{ $course->courseCreds }}</p>
                        <p><strong class="text-white block">Semester:</strong> {{ $course->courseSem }}</p>
                        <p><strong class="text-white block">Capacity:</strong> {{ $course->students->count() }} / {{ $course->courseCapacity }} Students</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-brand-medium font-bold uppercase tracking-wider text-sm mb-4">Logistics</h3>
                    <div class="space-y-4 text-brand-light">
                        <p><strong class="text-white block">Location:</strong> {{ $course->courseLocBuilding }}, {{ $course->courseLocRoom }}</p>
                        <p><strong class="text-white block">Schedule:</strong> {{ $course->courseDate }} at {{ $course->courseTime }}</p>
                        <p><strong class="text-white block">Lecturer:</strong> {{ $course->lecturer->fName ?? 'TBA' }} {{ $course->lecturer->lName ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>