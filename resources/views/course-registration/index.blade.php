<x-app-layout title="Course Registration">
    {{-- 1. ALPINE.JS STATE MANAGEMENT --}}
    <div class="py-12" x-data="{ 
        futureModalOpen: false, 
        confirmModalOpen: false, 
        targetForm: null,
        targetSem: '' 
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Page Header --}}
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Course Registration
                </h1>
                <p class="text-brand-light mt-2 text-lg font-medium">
                    Faculty of <span class="font-bold text-brand-white">{{ Auth::user()->facCode }}</span>
                </p>
                
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mt-4 p-4 bg-green-500/20 border border-green-500/50 text-green-200 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 p-4 bg-red-500/20 border border-red-500/50 text-red-200 rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- Sidebar Navigation --}}
                <div class="lg:col-span-1 animate-fade-in-up delay-100">
                    <nav class="bg-brand-white/15 backdrop-blur-xl rounded-3xl p-6 shadow-xl border border-brand-white/20 sticky top-24 space-y-3">
                        <a href="{{ route('course.registration') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-medium text-brand-dark font-bold shadow-md transform scale-105 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Register</span>
                        </a>
                        <a href="{{ route('course.roadmap') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-white/10 border border-brand-white/10 text-brand-white hover:bg-brand-white/20 hover:scale-105 transition-all duration-300 group shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-medium">View Courses</span>
                        </a>
                        <a href="{{ route('course.submissions') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-white/10 border border-brand-white/10 text-brand-white hover:bg-brand-white/20 hover:scale-105 transition-all duration-300 group shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span class="font-medium">My Submissions</span>
                        </a>
                    </nav>
                </div>

                {{-- Main Content Area --}}
                <div class="lg:col-span-3 space-y-6 animate-fade-in-up delay-200">
                    
                    @if($hasActiveSubmission)
                        {{-- BLOCKED UI FOR SUBMITTED USERS --}}
                        <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-12 border border-brand-white/20 text-center flex flex-col items-center justify-center min-h-[400px]">
                            <div class="bg-green-500/20 p-6 rounded-full border border-green-500/30 mb-6 shadow-[0_0_30px_rgba(34,197,94,0.3)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-brand-white mb-4">Registration Submitted</h2>
                            <p class="text-brand-light text-lg max-w-lg mx-auto mb-8">
                                You have successfully submitted your course registration. You can track the approval status of your courses in the submissions page.
                            </p>
                            <a href="{{ route('course.submissions') }}" class="px-8 py-4 bg-brand-medium text-brand-dark font-extrabold rounded-xl shadow-lg hover:bg-brand-white hover:scale-105 transition-all duration-300 flex items-center gap-3">
                                <span>View My Submissions</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @else
                        {{-- 1. AVAILABLE COURSES SECTION (Normal View) --}}
                        <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-8 border border-brand-white/20">
                            
                            {{-- Header --}}
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                                <h2 class="text-2xl font-bold text-brand-white">Available Courses</h2>
                                <div class="flex items-center gap-3 bg-brand-white/5 border border-brand-white/10 px-4 py-2 rounded-xl backdrop-blur-sm shadow-sm">
                                    <div class="text-right">
                                        <span class="block text-[10px] font-bold text-brand-light/60 uppercase tracking-widest">
                                            Current Session
                                        </span>
                                        <span class="block text-brand-white font-bold text-sm">
                                            {{ Auth::user()->progCode }} 
                                            <span class="text-brand-medium/50 mx-1">•</span> 
                                            Sem {{ Auth::user()->semester }}
                                        </span>
                                    </div>
                                    <div class="bg-brand-medium/20 p-2 rounded-lg text-brand-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Search Form --}}
                            <form method="GET" action="{{ route('course.registration') }}" class="mb-8">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                    <div class="md:col-span-6 relative group">
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               placeholder="Search course name or code..."
                                               class="w-full bg-brand-white/20 border border-brand-white/20 text-brand-white font-bold placeholder-brand-light rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-brand-medium focus:border-transparent focus:bg-brand-white/30 transition-all outline-none shadow-inner">
                                        <div class="absolute left-4 top-3.5 text-brand-light group-focus-within:text-brand-white transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="md:col-span-3 relative">
                                        <select name="programme" onchange="this.form.submit()" 
                                                class="w-full bg-brand-white/20 border border-brand-white/20 text-brand-white font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-medium focus:border-transparent outline-none cursor-pointer appearance-none shadow-sm">
                                            <option value="all" class="text-brand-dark bg-brand-medium">All Programmes</option>
                                            @foreach($programmes as $prog)
                                                <option value="{{ $prog->progCode }}" class="text-brand-dark bg-brand-white" {{ request('programme') == $prog->progCode ? 'selected' : '' }}>
                                                    {{ $prog->progCode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3 relative">
                                        <select name="semester" onchange="this.form.submit()" 
                                                class="w-full bg-brand-white/20 border border-brand-white/20 text-brand-white font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-medium focus:border-transparent outline-none cursor-pointer appearance-none shadow-sm">
                                            <option value="all" class="text-brand-dark bg-brand-medium">All Semesters</option>
                                            @foreach($semesters as $sem)
                                                <option value="{{ $sem }}" class="text-brand-dark bg-brand-white" {{ request('semester') == $sem ? 'selected' : '' }}>
                                                    Semester {{ $sem }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>

                            {{-- Course List --}}
                            @if($courses->isEmpty())
                                <div class="text-center py-16 flex flex-col items-center justify-center">
                                    <p class="text-brand-light text-lg font-medium">No courses found matching your criteria.</p>
                                </div>
                            @else
                                <div class="flex flex-col gap-4">
                                    @foreach($courses as $course)
                                        @php
                                            $studentSem = Auth::user()->semester;
                                            $courseSem = $course->courseSem;
                                            
                                            // LOGIC UPDATE:
                                            // 1. Restricted Future: More than 1 semester ahead (e.g. Student Sem 1, Course Sem 3+)
                                            $isRestrictedFuture = $courseSem > ($studentSem + 1);
                                            
                                            // 2. Current or Previous: Needs warning
                                            $isCurrentOrPast = $courseSem <= $studentSem;
                                            
                                            // 3. Next Semester ($courseSem == $studentSem + 1): Allowed freely (no flag needed)
                                            
                                            $isRegistered = in_array($course->courseCode, $registeredCourseCodes);
                                        @endphp

                                        <div class="group relative bg-brand-white/20 backdrop-blur-md border border-brand-white/20 rounded-2xl p-6 hover:bg-brand-light hover:border-brand-light transition-all duration-300 shadow-xl">
                                            <div class="flex flex-col md:flex-row items-center gap-6">
                                                
                                                {{-- Code & Credits --}}
                                                <div class="flex flex-row md:flex-col items-center md:items-start justify-center gap-3 md:gap-2 w-full md:w-32 flex-shrink-0">
                                                    <div class="bg-brand-medium text-brand-dark font-extrabold px-3 py-1 rounded-lg text-sm text-center w-full md:w-auto shadow-md transition-all duration-300 group-hover:bg-brand-dark group-hover:text-brand-medium">
                                                        {{ $course->courseCode }}
                                                    </div>
                                                    <span class="text-brand-white text-xs font-bold border border-brand-medium/50 px-2 py-1 rounded whitespace-nowrap shadow-sm transition-all duration-300 group-hover:bg-brand-medium group-hover:text-brand-dark group-hover:border-transparent">
                                                        {{ $course->courseCreds }} Credits
                                                    </span>
                                                </div>

                                                {{-- Course Info & AVAILABILITY --}}
                                                <div class="flex-1 text-center md:text-left w-full border-t md:border-t-0 md:border-l border-brand-white/10 pt-4 md:pt-0 md:pl-6">
                                                    <h3 class="text-xl md:text-2xl font-bold text-brand-white mb-2 leading-tight group-hover:text-brand-dark transition-colors">
                                                        {{ $course->courseName }}
                                                    </h3>
                                                    
                                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mb-2">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-brand-light/80 uppercase tracking-wider group-hover:text-brand-dark/70 transition-colors">Sem {{ $course->courseSem }}</span>
                                                            <span class="text-brand-light/40">•</span>
                                                            <span class="text-xs font-bold text-brand-light/80 uppercase tracking-wider group-hover:text-brand-dark/70 transition-colors">{{ $course->progCode }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Availability Section --}}
                                                    <div class="mt-4 w-full max-w-xs">
                                                        <div class="flex justify-between items-end mb-2">
                                                            <span class="text-xs font-bold uppercase tracking-widest text-brand-white/70 group-hover:text-brand-dark/70">
                                                                Registered Students
                                                            </span>
                                                            <span class="text-lg font-black text-brand-white drop-shadow-md group-hover:text-brand-dark">
                                                                {{ $course->students_count }} / {{ $course->courseCapacity }}
                                                            </span>
                                                        </div>
                                                        <div class="h-3 w-full bg-brand-dark/50 rounded-full overflow-hidden border border-brand-white/10 group-hover:border-brand-dark/20">
                                                            <div class="h-full bg-brand-medium shadow-[0_0_10px_rgba(166,177,225,0.8)]" 
                                                                 style="width: {{ min(100, ($course->students_count / max(1, $course->courseCapacity)) * 100) }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Actions --}}
                                                <div class="w-full md:w-48 flex-shrink-0 mt-2 md:mt-0 flex gap-2">
                                                    <button x-data x-on:click="$dispatch('open-modal', 'course-info-{{ $course->courseCode }}')" 
                                                            class="p-3 rounded-xl bg-brand-white/10 text-brand-light hover:bg-brand-white hover:text-brand-dark border border-brand-white/10 transition-all duration-300 shadow-lg group/info group-hover:bg-brand-dark group-hover:text-brand-white group-hover:border-brand-dark">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>

                                                    @if($isRegistered)
                                                        <button disabled class="flex-1 py-3 rounded-xl bg-green-500/20 text-green-300 font-bold border border-green-500/30 cursor-not-allowed opacity-80 flex items-center justify-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            Added
                                                        </button>
                                                    @else
                                                        <form action="{{ route('course.add') }}" method="POST" class="flex-1">
                                                            @csrf
                                                            <input type="hidden" name="course_code" value="{{ $course->courseCode }}">
                                                            
                                                            <button type="submit" 
                                                                    @if($isRestrictedFuture)
                                                                        @click.prevent="futureModalOpen = true"
                                                                    @elseif($isCurrentOrPast)
                                                                        @click.prevent="confirmModalOpen = true; targetForm = $el.closest('form'); targetSem = '{{ $courseSem }}'"
                                                                    @endif
                                                                    class="w-full py-3 rounded-xl bg-brand-medium text-brand-dark font-bold hover:bg-brand-dark hover:text-brand-white group-hover:bg-brand-dark group-hover:text-brand-white transition-all duration-300 shadow-lg flex items-center justify-center gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                                </svg>
                                                                Add
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-8">
                                    {{ $courses->links('pagination.sms') }}
                                </div>                            
                            @endif
                        </div>

                        {{-- 2. SELECTED COURSES CONTAINER (Hide if submitted, but logic above handles it via if-else block) --}}
                        @if(!$hasActiveSubmission && $registeredCourses->isNotEmpty())
                        <div class="bg-brand-medium/20 backdrop-blur-xl rounded-3xl p-8 border border-brand-medium shadow-[0_0_30px_rgba(166,177,225,0.3)] mt-8 animate-fade-in-up delay-300">
                            <div class="flex items-center gap-3 mb-6">
                                <h2 class="text-2xl font-bold text-brand-white drop-shadow-sm">Selected Courses</h2>
                                <span class="bg-brand-medium text-brand-dark font-extrabold px-3 py-1 rounded-full text-xs shadow-sm">
                                    {{ $registeredCourses->count() }} Items
                                </span>
                            </div>

                            <div class="flex flex-col gap-3">
                                @foreach($registeredCourses as $regCourse)
                                    <div class="bg-brand-white/10 border border-brand-white/20 rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 hover:bg-brand-white/20 transition-colors">
                                        <div class="flex items-center gap-4 w-full md:w-auto">
                                            <div class="bg-brand-white text-brand-dark font-extrabold px-4 py-2 rounded-lg text-sm shadow-sm">
                                                {{ $regCourse->courseCode }}
                                            </div>
                                            <div>
                                                <h4 class="text-brand-white font-bold text-lg">{{ $regCourse->courseName }}</h4>
                                                <p class="text-brand-light text-xs font-semibold">{{ $regCourse->courseCreds }} Credits</p>
                                            </div>
                                        </div>
                                        
                                        <form action="{{ route('course.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="course_code" value="{{ $regCourse->courseCode }}">
                                            <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-200 border border-red-500/30 rounded-lg text-sm font-bold hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                                
                                <div class="mt-6 pt-6 border-t border-brand-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
                                    <p class="text-brand-light font-bold text-lg">
                                        Total Credits: <span class="text-brand-white text-2xl ml-2 drop-shadow-sm">{{ $registeredCourses->sum('courseCreds') }}</span>
                                    </p>
                                    
                                    <form action="{{ route('course.confirm') }}" method="POST" class="w-full md:w-auto">
                                        @csrf
                                        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-brand-white text-brand-dark font-extrabold rounded-xl shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:scale-105 hover:bg-brand-light transition-all duration-300 flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Confirm Registration
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

        {{-- ALERTS MODALS --}}
        
        {{-- FUTURE SEMESTER MODAL --}}
        <div x-show="futureModalOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="futureModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="futureModalOpen"
                     @click.away="futureModalOpen = false"
                     class="inline-block align-bottom bg-brand-dark rounded-2xl border border-brand-white/10 text-left overflow-hidden shadow-[0_0_50px_rgba(239,68,68,0.2)] transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                    <div class="px-6 pt-8 pb-8 sm:p-10">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-red-500/20 sm:mx-0 sm:h-16 sm:w-16 border border-red-500/30">
                                <svg class="h-8 w-8 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-5 text-center sm:mt-0 sm:ml-8 sm:text-left">
                                <h3 class="text-3xl leading-8 font-extrabold text-brand-white" id="modal-title">
                                    Restricted Action
                                </h3>
                                <div class="mt-4">
                                    <p class="text-lg text-brand-light/90 leading-relaxed">
                                        You cannot register for this course because it is <strong class="text-brand-white text-xl">too far in the future</strong>. 
                                        <br>
                                        You may only register for courses up to <strong>one semester ahead</strong> of your current level.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-brand-white/5 px-6 py-5 sm:px-10 sm:flex sm:flex-row-reverse border-t border-brand-white/10">
                        <button type="button" 
                                @click="futureModalOpen = false"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-8 py-3 bg-brand-white text-lg font-bold text-brand-dark hover:bg-brand-light focus:outline-none sm:ml-3 sm:w-auto transition-colors">
                            Understood
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONFIRMATION MODAL --}}
        <div x-show="confirmModalOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="confirmModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="confirmModalOpen"
                     @click.away="confirmModalOpen = false"
                     class="inline-block align-bottom bg-brand-dark rounded-2xl border border-brand-white/10 text-left overflow-hidden shadow-[0_0_50px_rgba(166,177,225,0.2)] transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                    <div class="px-6 pt-8 pb-8 sm:p-10">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-brand-medium/20 sm:mx-0 sm:h-16 sm:w-16 border border-brand-medium/30">
                                <svg class="h-8 w-8 text-brand-medium" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-5 text-center sm:mt-0 sm:ml-8 sm:text-left">
                                <h3 class="text-3xl leading-8 font-extrabold text-brand-white" id="modal-title">
                                    Confirm Registration
                                </h3>
                                <div class="mt-4">
                                    <p class="text-lg text-brand-light/90 leading-relaxed">
                                        You are about to register for a course from the <strong class="text-brand-white text-xl">Current or Previous Semester</strong> (Semester <span x-text="targetSem"></span>).
                                        <br><br>
                                        Are you sure you want to proceed?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-brand-white/5 px-6 py-5 sm:px-10 sm:flex sm:flex-row-reverse border-t border-brand-white/10">
                        <button type="button" 
                                @click="targetForm.submit(); confirmModalOpen = false"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-8 py-3 bg-brand-medium text-lg font-bold text-brand-dark hover:bg-brand-white focus:outline-none sm:ml-3 sm:w-auto transition-colors">
                            Yes, Continue
                        </button>
                        <button type="button" 
                                @click="confirmModalOpen = false"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-brand-white/10 shadow-sm px-8 py-3 bg-transparent text-lg font-bold text-brand-light hover:text-brand-white hover:bg-brand-white/10 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Info Modals --}}
    @if(!$courses->isEmpty())
        @foreach($courses as $course)
             <x-modal name="course-info-{{ $course->courseCode }}" focusable>
                 <div class="bg-brand-dark/95 backdrop-blur-xl border border-brand-white/10 rounded-2xl shadow-2xl p-8 text-left relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-brand-medium/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="flex justify-between items-start mb-8 border-b border-brand-white/10 pb-6 relative z-10">
                        <div>
                             <h2 class="text-4xl font-extrabold text-brand-white leading-tight">
                                {{ $course->courseName }}
                            </h2>
                        </div>
                        <button x-on:click="$dispatch('close')" class="text-brand-light/50 hover:text-brand-white bg-brand-white/5 hover:bg-brand-white/10 p-2 rounded-full transition-all duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                     <div class="space-y-8 relative z-10">
                        <p class="text-brand-white leading-relaxed text-lg bg-brand-white/10 p-5 rounded-xl border border-brand-white/5">
                            {{ $course->courseDesc }}
                        </p>
                     </div>
                 </div>
             </x-modal>
        @endforeach
    @endif
</x-app-layout>