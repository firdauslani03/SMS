<x-app-layout title="My Submissions">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Page Header --}}
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Course Submissions
                </h1>
                <p class="text-brand-light mt-2 text-lg font-medium">
                    Review your registered courses for <span class="font-bold text-brand-white">Semester {{ Auth::user()->semester }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- Sidebar Navigation --}}
                <div class="lg:col-span-1 animate-fade-in-up delay-100">
                    <nav class="bg-brand-white/15 backdrop-blur-xl rounded-3xl p-6 shadow-xl border border-brand-white/20 sticky top-24 space-y-3">
                        
                        <a href="{{ route('course.registration') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-white/10 border border-brand-white/10 text-brand-white hover:bg-brand-white/20 hover:scale-105 transition-all duration-300 group shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="font-medium">Register</span>
                        </a>

                        <a href="{{ route('course.roadmap') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-white/10 border border-brand-white/10 text-brand-white hover:bg-brand-white/20 hover:scale-105 transition-all duration-300 group shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-medium">View Courses</span>
                        </a>

                        {{-- ACTIVE STATE --}}
                        <a href="{{ route('course.submissions') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-medium text-brand-dark font-bold shadow-md transform scale-105 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>My Submissions</span>
                        </a>
                    </nav>
                </div>

                {{-- Main Content Area --}}
                <div class="lg:col-span-3 space-y-6 animate-fade-in-up delay-200">
                    
                    @if($registeredCourses->isEmpty())
                        {{-- No Submissions State --}}
                        <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-16 text-center border border-brand-white/20 flex flex-col items-center justify-center min-h-[400px]">
                            <div class="bg-brand-white/5 p-6 rounded-full mb-6 animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-brand-light/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-brand-white mb-3">No Submissions</h2>
                            <p class="text-brand-light text-lg mb-8 max-w-md">You haven't submitted any course registrations for this session yet.</p>
                            <a href="{{ route('course.registration') }}" class="px-8 py-3 rounded-xl bg-brand-medium text-brand-dark font-bold hover:bg-brand-white hover:scale-105 transition-all duration-300 shadow-lg">
                                Start Registration
                            </a>
                        </div>
                    @else
                        {{-- Submission Summary Card --}}
                        <div class="bg-gradient-to-br from-brand-medium to-[#2a2e4b] rounded-3xl p-8 shadow-2xl border border-brand-white/20 relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center relative z-10">
                                <div>
                                    <span class="inline-block py-1 px-3 rounded-lg bg-black/20 text-brand-white text-xs font-bold uppercase tracking-widest mb-3 border border-white/10">
                                        Status: {{ $submissionStatus }}
                                    </span>
                                    <h2 class="text-3xl font-bold text-brand-dark mb-1">Registration Summary</h2>
                                    <p class="text-brand-dark/70 font-medium">
                                        Submitted on {{ $submissionDate ? \Carbon\Carbon::parse($submissionDate)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-right bg-white/10 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                                    <p class="text-xs text-brand-dark/70 uppercase font-bold tracking-widest mb-1">Total Credits</p>
                                    <p class="text-4xl font-extrabold text-brand-dark">{{ $totalCredits }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Registered Courses List --}}
                        <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-8 border border-brand-white/20">
                            <h3 class="text-xl font-bold text-brand-white mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-medium" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Registered Courses
                            </h3>

                            <div class="space-y-4">
                                @foreach($registeredCourses as $course)
                                    <div class="group bg-brand-white/5 border border-brand-white/10 rounded-2xl p-5 hover:bg-brand-white/10 transition-all duration-300 flex flex-col md:flex-row items-center gap-6">
                                        
                                        {{-- Course Code Badge --}}
                                        <div class="flex-shrink-0">
                                            <div class="h-16 w-16 rounded-xl bg-brand-dark flex flex-col items-center justify-center border border-brand-white/10 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <span class="text-brand-medium text-[10px] font-bold uppercase tracking-widest">Code</span>
                                                <span class="text-brand-white font-bold">{{ $course->courseCode }}</span>
                                            </div>
                                        </div>

                                        {{-- Course Details --}}
                                        <div class="flex-grow text-center md:text-left">
                                            <h4 class="text-xl font-bold text-brand-white mb-1">{{ $course->courseName }}</h4>
                                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm text-brand-light/70">
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $course->courseCreds }} Credits
                                                </span>
                                                <span class="hidden md:inline">•</span>
                                                <span>{{ $course->programme->progName ?? $course->progCode }}</span>
                                            </div>
                                        </div>

                                        {{-- Status Pill --}}
                                        <div class="flex-shrink-0">
                                            @php
                                                $status = $course->pivot->status;
                                                $statusColor = match(strtolower($status)) {
                                                    'approved' => 'bg-green-500/20 text-green-300 border-green-500/30',
                                                    'rejected' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                    default => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                };
                                            @endphp
                                            <span class="px-4 py-2 rounded-lg border {{ $statusColor }} font-bold text-sm uppercase tracking-wide shadow-sm">
                                                {{ $status }}
                                            </span>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Print/Export Actions --}}
                        <div class="flex justify-end pt-4 animate-fade-in-up delay-300">
                             <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-brand-white/10 text-brand-white font-bold hover:bg-brand-white hover:text-brand-dark transition-all duration-300 border border-brand-white/10 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Slip
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>