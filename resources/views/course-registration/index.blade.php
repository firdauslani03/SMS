<x-app-layout title="Course Registration">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Course Registration
                </h1>
                <p class="text-brand-light mt-2 text-lg font-medium">
                    Faculty of <span class="font-bold text-brand-white">{{ Auth::user()->facCode }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
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

                <div class="lg:col-span-3 space-y-6 animate-fade-in-up delay-200">
                    
                    <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-8 border border-brand-white/20">
                        <h2 class="text-2xl font-bold text-brand-white mb-6">Available Courses</h2>

                        @if($courses->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-brand-light text-lg">No courses found for your faculty.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($courses as $course)
                                    <div class="group relative bg-[#9095CA]/25 border border-[#9095CA]/40 rounded-2xl p-6 hover:bg-[#9095CA]/35 hover:border-[#9095CA]/60 transition-all duration-300 shadow-xl hover:shadow-[0_0_25px_rgba(144,149,202,0.4)] hover:-translate-y-1">
                                        
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="bg-brand-dark/90 text-[#9095CA] font-extrabold px-3 py-1 rounded-lg text-sm shadow-md border border-[#9095CA]/30">
                                                {{ $course->courseCode }}
                                            </div>
                                            <span class="text-brand-dark text-sm font-bold bg-[#9095CA] px-2 py-1 rounded shadow-sm">
                                                {{ $course->courseCreds }} Credits
                                            </span>
                                        </div>

                                        <h3 class="text-2xl font-bold text-brand-white mb-2 leading-tight group-hover:text-[#9095CA] transition-colors">
                                            {{ $course->courseName }}
                                        </h3>
                                        
                                        <div class="flex items-center gap-2 mb-6">
                                            <span class="text-xs font-bold text-brand-light uppercase tracking-wider">
                                                Sem {{ $course->courseSem }}
                                            </span>
                                            <span class="text-brand-light/50">•</span>
                                            <span class="text-xs font-bold text-brand-light uppercase tracking-wider">
                                                {{ $course->progCode }}
                                            </span>
                                        </div>

                                        <button class="w-full py-3 rounded-xl bg-[#9095CA] text-brand-dark font-bold hover:bg-brand-white hover:text-brand-dark transition-all duration-300 shadow-lg flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                            </svg>
                                            Add Course
                                        </button>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>