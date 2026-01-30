<x-app-layout title="Course Registration">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Page Header --}}
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Course Registration
                </h1>
                <p class="text-brand-light mt-2 text-lg font-medium">
                    Faculty of <span class="font-bold text-brand-white">{{ Auth::user()->facCode }}</span>
                </p>
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

                        <a href="#" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-white/10 border border-brand-white/10 text-brand-white hover:bg-brand-white/20 hover:scale-105 transition-all duration-300 group shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-medium">View Courses</span>
                        </a>

                        <a href="#" 
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
                    
                    <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-8 border border-brand-white/20">
                        
                        {{-- Container Header: Title + Student Info Badge --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                            <h2 class="text-2xl font-bold text-brand-white">Available Courses</h2>
                            
                            {{-- Student Info Badge --}}
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

                        {{-- Search & Filter Form --}}
                        <form method="GET" action="{{ route('course.registration') }}" class="mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                
                                {{-- Search Input --}}
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

                                {{-- Programme Filter --}}
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
                                    <div class="absolute right-4 top-4 pointer-events-none text-brand-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Semester Filter --}}
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
                                    <div class="absolute right-4 top-4 pointer-events-none text-brand-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Course List & Pagination --}}
                        @if($courses->isEmpty())
                            <div class="text-center py-16 flex flex-col items-center justify-center">
                                <div class="bg-brand-white/5 p-4 rounded-full mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-light/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-brand-light text-lg font-medium">No courses found matching your criteria.</p>
                                <a href="{{ route('course.registration') }}" class="mt-4 text-sm text-brand-medium hover:text-brand-white underline transition-colors">
                                    Clear all filters
                                </a>
                            </div>
                        @else
                            {{-- List View Container --}}
                            <div class="flex flex-col gap-4">
                                @foreach($courses as $course)
                                    <div class="group relative bg-brand-white/20 backdrop-blur-md border border-brand-white/20 rounded-2xl p-6 hover:bg-brand-light hover:border-brand-light transition-all duration-300 shadow-xl hover:shadow-[0_0_25px_rgba(166,177,225,0.5)] hover:-translate-y-1">
                                        
                                        <div class="flex flex-col md:flex-row items-center gap-6">
                                            
                                            {{-- Section 1: Code & Credits --}}
                                            <div class="flex flex-row md:flex-col items-center md:items-start justify-center gap-3 md:gap-2 w-full md:w-32 flex-shrink-0">
                                                <div class="bg-brand-medium text-brand-dark font-extrabold px-3 py-1 rounded-lg text-sm shadow-md group-hover:bg-brand-dark group-hover:text-brand-light transition-colors text-center w-full md:w-auto">
                                                    {{ $course->courseCode }}
                                                </div>
                                                <span class="text-brand-white text-xs font-bold border border-brand-medium/50 px-2 py-1 rounded shadow-sm group-hover:text-brand-dark group-hover:border-brand-dark/30 transition-colors whitespace-nowrap">
                                                    {{ $course->courseCreds }} Credits
                                                </span>
                                            </div>

                                            {{-- Section 2: Course Info --}}
                                            <div class="flex-1 text-center md:text-left w-full border-t md:border-t-0 md:border-l border-brand-white/10 pt-4 md:pt-0 md:pl-6">
                                                <h3 class="text-xl md:text-2xl font-bold text-brand-white mb-2 leading-tight group-hover:text-brand-dark transition-colors">
                                                    {{ $course->courseName }}
                                                </h3>
                                                
                                                <div class="flex items-center justify-center md:justify-start gap-2">
                                                    <span class="text-xs font-bold text-brand-light/80 uppercase tracking-wider group-hover:text-brand-dark/70 transition-colors">
                                                        Sem {{ $course->courseSem }}
                                                    </span>
                                                    <span class="text-brand-light/40 group-hover:text-brand-dark/40 transition-colors">•</span>
                                                    <span class="text-xs font-bold text-brand-light/80 uppercase tracking-wider group-hover:text-brand-dark/70 transition-colors">
                                                        {{ $course->progCode }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Section 3: Action Buttons (Info + Add) --}}
                                            <div class="w-full md:w-48 flex-shrink-0 mt-2 md:mt-0 flex gap-2">
                                                
                                                {{-- INFO BUTTON: UPDATED with group-hover classes --}}
                                                <button x-data x-on:click="$dispatch('open-modal', 'course-info-{{ $course->courseCode }}')" 
                                                        class="p-3 rounded-xl bg-brand-white/10 text-brand-light hover:bg-brand-white hover:text-brand-dark border border-brand-white/10 transition-all duration-300 shadow-lg group/info group-hover:bg-brand-dark group-hover:text-brand-white group-hover:border-brand-dark">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover/info:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>

                                                {{-- ADD BUTTON --}}
                                                <button class="flex-1 py-3 rounded-xl bg-brand-medium text-brand-dark font-bold hover:bg-brand-dark hover:text-brand-white group-hover:bg-brand-dark group-hover:text-brand-white transition-all duration-300 shadow-lg flex items-center justify-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                    Add
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Pagination Links --}}
                            <div class="mt-8">
                                {{ $courses->links('pagination.sms') }}
                            </div>                            
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODALS CONTAINER --}}
    @if(!$courses->isEmpty())
        @foreach($courses as $course)
            <x-modal name="course-info-{{ $course->courseCode }}" focusable>
                {{-- SMS Style Modal Card --}}
                <div class="bg-brand-dark/95 backdrop-blur-xl border border-brand-white/10 rounded-2xl shadow-2xl p-8 text-left relative overflow-hidden">
                    
                    {{-- Decorative Glow --}}
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-brand-medium/20 rounded-full blur-3xl pointer-events-none"></div>

                    {{-- Modal Header --}}
                    <div class="flex justify-between items-start mb-8 border-b border-brand-white/10 pb-6 relative z-10">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                {{-- Increased font size for badges --}}
                                <span class="bg-brand-medium text-brand-dark text-sm font-extrabold px-3 py-1 rounded-lg shadow-lg">
                                    {{ $course->courseCode }}
                                </span>
                                <span class="text-brand-light/80 text-sm font-bold uppercase tracking-widest">
                                    {{ $course->progCode }}
                                </span>
                            </div>
                            {{-- Title enlarged to text-4xl --}}
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

                    {{-- Modal Body --}}
                    <div class="space-y-8 relative z-10">
                        
                        {{-- Description --}}
                        <div>
                            <h3 class="text-sm font-bold text-brand-medium uppercase tracking-widest mb-3">Course Description</h3>
                            {{-- Increased text size to text-lg and brightened background slightly --}}
                            <p class="text-brand-white leading-relaxed text-lg bg-brand-white/10 p-5 rounded-xl border border-brand-white/5">
                                {{ $course->courseDesc }}
                            </p>
                        </div>

                        {{-- Details Grid --}}
                        <div class="grid grid-cols-2 gap-5">
                            
                            {{-- INFO CARDS: Background changed to bg-brand-white/15 (Lighter) --}}
                            
                            {{-- Credits --}}
                            <div class="bg-brand-white/15 p-5 rounded-xl border border-brand-white/10 hover:border-brand-white/20 transition-colors">
                                <h4 class="text-xs font-bold text-brand-light/70 uppercase tracking-widest mb-2">Credits</h4>
                                <p class="text-3xl font-extrabold text-brand-white">{{ $course->courseCreds }}</p>
                            </div>

                            {{-- Semester --}}
                            <div class="bg-brand-white/15 p-5 rounded-xl border border-brand-white/10 hover:border-brand-white/20 transition-colors">
                                <h4 class="text-xs font-bold text-brand-light/70 uppercase tracking-widest mb-2">Semester</h4>
                                <p class="text-3xl font-extrabold text-brand-white">{{ $course->courseSem }}</p>
                            </div>

                            {{-- Location --}}
                            <div class="bg-brand-white/15 p-5 rounded-xl border border-brand-white/10 hover:border-brand-white/20 transition-colors">
                                <h4 class="text-xs font-bold text-brand-light/70 uppercase tracking-widest mb-2">Location</h4>
                                <p class="text-lg font-bold text-brand-white break-words">{{ $course->courseLocBuilding }}</p>
                                <p class="text-base text-brand-medium mt-1 font-semibold">{{ $course->courseLocRoom }}</p>
                            </div>

                            {{-- Schedule --}}
                            <div class="bg-brand-white/15 p-5 rounded-xl border border-brand-white/10 hover:border-brand-white/20 transition-colors">
                                <h4 class="text-xs font-bold text-brand-light/70 uppercase tracking-widest mb-2">Schedule</h4>
                                <p class="text-lg font-bold text-brand-white">{{ $course->courseDate }}</p>
                                <p class="text-base text-brand-medium mt-1 font-semibold">{{ $course->courseTime }}</p>
                            </div>

                            {{-- Prerequisite (Full Width) --}}
                            <div class="col-span-2 bg-brand-white/15 p-5 rounded-xl border border-brand-white/10 hover:border-brand-white/20 transition-colors flex items-center justify-between">
                                <h4 class="text-xs font-bold text-brand-light/70 uppercase tracking-widest">Prerequisite</h4>
                                @if($course->coursePreReq)
                                    <span class="text-red-300 font-bold text-lg bg-red-500/20 px-4 py-1.5 rounded-lg border border-red-500/30">
                                        {{ $course->coursePreReq }}
                                    </span>
                                @else
                                    <span class="text-green-300 font-bold text-lg bg-green-500/20 px-4 py-1.5 rounded-lg border border-green-500/30">
                                        None
                                    </span>
                                @endif
                            </div>

                        </div>

                        {{-- LECTURER INFORMATION (NEW SECTION) --}}
                        @if($course->lecturer)
                            <div class="mt-8 border-t border-brand-white/10 pt-6">
                                <h3 class="text-sm font-bold text-brand-medium uppercase tracking-widest mb-4">Lecturer Information</h3>
                                
                                <div class="bg-brand-white/10 p-6 rounded-2xl border border-brand-white/5 flex flex-col md:flex-row items-center md:items-start gap-6 hover:bg-brand-white/15 transition-colors">
                                    {{-- Avatar Placeholder with Initials --}}
                                    <div class="h-16 w-16 flex-shrink-0 rounded-full bg-gradient-to-br from-brand-medium to-brand-dark flex items-center justify-center shadow-lg border-2 border-brand-white/20">
                                        <span class="text-xl font-bold text-brand-white">
                                            {{ substr($course->lecturer->fName, 0, 1) }}{{ substr($course->lecturer->lName, 0, 1) }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-center md:text-left space-y-1 w-full">
                                        <h4 class="text-2xl font-bold text-brand-white">
                                            {{ $course->lecturer->fName }} {{ $course->lecturer->lName }}
                                        </h4>
                                        <p class="text-brand-medium font-bold text-sm tracking-wide">{{ $course->lecturer->qualification }}</p>
                                        
                                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-6 gap-y-2 pt-3 text-sm text-brand-light/90">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-medium" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $course->lecturer->email }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-medium" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <span>{{ $course->lecturer->officeBuilding }}-{{ $course->lecturer->officeFloor }}-{{ $course->lecturer->officeRoom }}</span>
                                            </div>
                                             <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-medium" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                                <span>{{ $course->lecturer->department }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </x-modal>
        @endforeach
    @endif
</x-app-layout>