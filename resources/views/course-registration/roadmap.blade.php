<x-app-layout title="My Roadmap">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header with Progress Bar --}}
            <div class="mb-10 animate-fade-in-up">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                            Academic Roadmap
                        </h1>
                        <p class="text-brand-light mt-2 text-lg font-medium">
                            Your journey through <span class="text-brand-medium font-bold">{{ $student->programme->progName ?? $student->progCode }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-extrabold text-brand-medium">{{ $progress }}%</span>
                        <span class="text-brand-light text-sm uppercase font-bold tracking-widest block">Completed</span>
                    </div>
                </div>
                
                {{-- Creative Progress Bar --}}
                <div class="h-4 w-full bg-brand-white/10 rounded-full overflow-hidden border border-brand-white/5 shadow-inner">
                    <div class="h-full bg-gradient-to-r from-brand-medium to-purple-500 shadow-[0_0_20px_rgba(166,177,225,0.6)] transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                </div>
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

                        {{-- ACTIVE STATE FOR VIEW COURSES --}}
                        <a href="{{ route('course.roadmap') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-brand-medium text-brand-dark font-bold shadow-md transform scale-105 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span>View Courses</span>
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

                {{-- Main Content: The Roadmap Timeline --}}
                <div class="lg:col-span-3 space-y-6 animate-fade-in-up delay-200">
                    <div class="relative pl-8 border-l-2 border-brand-white/10 space-y-12">
                        
                        @foreach($curriculum as $sem => $courses)
                            @php
                                $isPast = $sem < $student->semester;
                                $isCurrent = $sem == $student->semester;
                                $isNext = $sem == ($student->semester + 1);
                                $isFuture = $sem > ($student->semester + 1);
                                
                                // Expansion Logic: Current OR Next are expanded by default
                                $isExpanded = ($isCurrent || $isNext) ? 'true' : 'false';

                                // Colors & Styles based on status
                                if ($isPast) {
                                    $dotColor = 'bg-brand-medium border-brand-medium shadow-[0_0_15px_rgba(166,177,225,0.8)]';
                                    $textColor = 'text-brand-light/60';
                                    $cardBorder = 'border-brand-medium/30';
                                    $statusLabel = 'Completed';
                                    $statusColor = 'text-brand-medium/50';
                                } elseif ($isCurrent) {
                                    $dotColor = 'bg-brand-white border-brand-white animate-pulse shadow-[0_0_20px_rgba(255,255,255,0.8)]';
                                    $textColor = 'text-brand-white';
                                    $cardBorder = 'border-brand-white/50 ring-1 ring-brand-white/20';
                                    $statusLabel = 'Current Session';
                                    $statusColor = 'text-brand-medium';
                                } elseif ($isNext) {
                                    // STYLE FOR "TO REGISTER"
                                    $dotColor = 'bg-yellow-400 border-yellow-200 shadow-[0_0_20px_rgba(250,204,21,0.6)]';
                                    $textColor = 'text-brand-white';
                                    $cardBorder = 'border-yellow-400/30 ring-1 ring-yellow-400/10';
                                    $statusLabel = 'To Register';
                                    $statusColor = 'text-yellow-400';
                                } else {
                                    $dotColor = 'bg-brand-dark border-brand-white/20';
                                    $textColor = 'text-brand-light/30';
                                    $cardBorder = 'border-brand-white/5';
                                    $statusLabel = 'Locked';
                                    $statusColor = 'text-brand-light/20';
                                }
                            @endphp

                            <div class="relative group" x-data="{ expanded: {{ $isExpanded }} }">
                                {{-- Timeline Dot --}}
                                <div class="absolute -left-[41px] top-6 h-5 w-5 rounded-full border-4 {{ $dotColor }} transition-all duration-500 z-10"></div>

                                {{-- Semester Card --}}
                                <div class="bg-brand-white/5 backdrop-blur-md rounded-2xl border {{ $cardBorder }} overflow-hidden transition-all duration-300 hover:bg-brand-white/10">
                                    
                                    {{-- Card Header (Clickable) --}}
                                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                                        <div class="flex flex-col">
                                            <span class="text-xs uppercase font-bold tracking-widest {{ $statusColor }}">
                                                {{ $statusLabel }}
                                            </span>
                                            <h3 class="text-2xl font-bold {{ $isFuture ? 'text-brand-light/40' : 'text-brand-white' }}">
                                                Semester {{ $sem }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-sm font-bold {{ $isFuture ? 'text-brand-light/20' : 'text-brand-light' }}">
                                                {{ $courses->sum('courseCreds') }} Credits
                                            </span>
                                            {{-- Chevron Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                 class="h-6 w-6 text-brand-light transition-transform duration-300"
                                                 :class="{'rotate-180': expanded}" 
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </button>

                                    {{-- Card Body (Courses List) --}}
                                    <div x-show="expanded" 
                                         x-collapse
                                         class="border-t border-brand-white/5 bg-black/10">
                                        <div class="p-6 grid gap-4 grid-cols-1 md:grid-cols-2">
                                            @foreach($courses as $course)
                                                {{-- Individual Course Item --}}
                                                {{-- UPDATED: Increased padding to p-4 --}}
                                                <div class="flex items-center justify-between p-4 rounded-xl {{ ($isCurrent || $isNext) ? 'bg-brand-white/10' : 'bg-brand-white/5' }} border border-brand-white/5 group/item hover:bg-brand-white/15 transition-colors">
                                                    
                                                    <div class="flex items-start gap-4">
                                                        <div class="flex-shrink-0 pt-1.5">
                                                            @if($isPast)
                                                                <div class="bg-brand-medium/20 p-1.5 rounded-full">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-medium" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                            @elseif($isCurrent)
                                                                <div class="bg-brand-white/20 p-1.5 rounded-full animate-pulse">
                                                                    <div class="h-4 w-4 rounded-full bg-brand-white"></div>
                                                                </div>
                                                            @elseif($isNext)
                                                                 <div class="bg-yellow-400/20 p-1.5 rounded-full">
                                                                    <div class="h-4 w-4 rounded-full bg-yellow-400"></div>
                                                                </div>
                                                            @else
                                                                <div class="bg-brand-light/5 p-1.5 rounded-full">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-light/30" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            {{-- UPDATED: text-lg for name --}}
                                                            <h4 class="font-bold text-lg leading-tight {{ $isFuture ? 'text-brand-white/50' : 'text-brand-white' }}">{{ $course->courseName }}</h4>
                                                            {{-- UPDATED: text-sm for code/creds --}}
                                                            <p class="text-sm font-mono text-brand-light/60 mt-1">{{ $course->courseCode }} • {{ $course->courseCreds }} Cr</p>
                                                        </div>
                                                    </div>

                                                    {{-- Info Button --}}
                                                    <button x-on:click="$dispatch('open-modal', 'course-info-{{ $course->courseCode }}')" 
                                                            class="p-2.5 rounded-xl bg-brand-white/5 text-brand-light hover:bg-brand-white hover:text-brand-dark transition-all duration-300 opacity-60 group-hover/item:opacity-100 flex-shrink-0 ml-2"
                                                            title="View Details">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                    
                    {{-- End of Road Decor --}}
                    <div class="text-center pt-8 pb-4 opacity-50">
                        <p class="text-sm font-bold text-brand-light uppercase tracking-widest">Graduation</p>
                        <div class="h-8 w-0.5 bg-gradient-to-b from-brand-white/20 to-transparent mx-auto mt-2"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODALS CONTAINER --}}
    @foreach($curriculum->flatten() as $course)
        <x-modal name="course-info-{{ $course->courseCode }}" focusable>
            {{-- SMS Style Modal Card --}}
            <div class="bg-brand-dark/95 backdrop-blur-xl border border-brand-white/10 rounded-2xl shadow-2xl p-8 text-left relative overflow-hidden">
                
                {{-- Decorative Glow --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-brand-medium/20 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Modal Header --}}
                <div class="flex justify-between items-start mb-8 border-b border-brand-white/10 pb-6 relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-brand-medium text-brand-dark text-sm font-extrabold px-3 py-1 rounded-lg shadow-lg">
                                {{ $course->courseCode }}
                            </span>
                            <span class="text-brand-light/80 text-sm font-bold uppercase tracking-widest">
                                {{ $course->progCode }}
                            </span>
                        </div>
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
                        <p class="text-brand-white leading-relaxed text-lg bg-brand-white/10 p-5 rounded-xl border border-brand-white/5">
                            {{ $course->courseDesc }}
                        </p>
                    </div>

                    {{-- Details Grid --}}
                    <div class="grid grid-cols-2 gap-5">
                        
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

                        {{-- Prerequisite --}}
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

                    {{-- Lecturer Information --}}
                    @if($course->lecturer)
                        <div class="mt-8 border-t border-brand-white/10 pt-6">
                            <h3 class="text-sm font-bold text-brand-medium uppercase tracking-widest mb-4">Lecturer Information</h3>
                            
                            <div class="bg-brand-white/10 p-6 rounded-2xl border border-brand-white/5 flex flex-col md:flex-row items-center md:items-start gap-6 hover:bg-brand-white/15 transition-colors">
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

</x-app-layout>