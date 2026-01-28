<x-app-layout title="Student Dashboard">
    <div class="py-10" x-data="{ showFacultyModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Hello, <span class="text-brand-medium">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</span>
                </h1>
                <p class="text-brand-light mt-2 text-lg font-medium">
                    Program Structure for 
                    <span class="px-3 py-1 rounded-lg bg-brand-white/20 border border-brand-white/20 text-brand-white font-bold shadow-lg">
                        {{ Auth::user()->progCode }}
                    </span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                
                <div class="lg:col-span-2 animate-fade-in-up delay-100">
                    <div class="bg-brand-white/10 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-brand-white/20 sticky top-24">
                        
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="h-28 w-28 rounded-full bg-gradient-to-br from-brand-medium to-brand-light p-1.5 shadow-2xl mb-4">
                                <div class="h-full w-full rounded-full bg-brand-dark flex items-center justify-center border-[4px] border-brand-dark">
                                    <span class="text-4xl font-bold text-brand-white">{{ substr(Auth::user()->fName, 0, 1) }}</span>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold text-brand-white leading-tight mb-1">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</h2>
                            <p class="text-brand-medium text-lg font-medium tracking-wide">{{ Auth::user()->matricNum }}</p>
                        </div>

                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-5 rounded-2xl bg-brand-medium text-center shadow-lg transform transition hover:scale-105 duration-200">
                                    <p class="text-xs text-brand-dark/80 uppercase font-bold tracking-wider mb-1">Sem</p>
                                    <p class="text-brand-dark font-extrabold text-3xl">{{ Auth::user()->semester }}</p>
                                </div>
                                <div class="p-5 rounded-2xl bg-brand-light text-center shadow-lg transform transition hover:scale-105 duration-200">
                                    <p class="text-xs text-brand-dark/80 uppercase font-bold tracking-wider mb-1">CGPA</p>
                                    <p class="text-brand-dark font-extrabold text-3xl">{{ number_format(Auth::user()->cgpa, 2) }}</p>
                                </div>
                            </div>

                            <div class="p-6 rounded-2xl bg-brand-white/10 border border-brand-white/20">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-brand-medium uppercase font-bold tracking-wider">Faculty</span>
                                    
                                    <button 
                                        @click="showFacultyModal = true"
                                        class="px-3 py-1 rounded-lg bg-brand-white/20 text-brand-white text-sm font-bold border border-brand-white/10 hover:bg-brand-medium hover:text-brand-dark hover:scale-105 transition-all duration-300 shadow-md cursor-pointer"
                                        title="View Faculty Details">
                                        {{ Auth::user()->facCode }}
                                    </button>

                                </div>
                                <div class="mt-4">
                                    <p class="text-sm text-brand-medium uppercase font-bold tracking-wider mb-1">Program Name</p>
                                    <p class="text-brand-light font-medium text-base leading-snug">
                                        {{ Auth::user()->programme->progName ?? Auth::user()->progCode }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 space-y-6">
                    @if($curriculum->isEmpty())
                         <div class="bg-brand-white/10 backdrop-blur-lg rounded-[2rem] p-10 text-center border border-brand-white/20">
                            <p class="text-brand-light text-lg">No curriculum data found.</p>
                         </div>
                    @else
                        @foreach($curriculum as $sem => $courses)
                            @php
                                $currentSem = Auth::user()->semester;
                                $isCurrentSem = ($sem == $currentSem);
                                $isPastSem = ($sem < $currentSem);
                                
                                $cardClasses = $isCurrentSem 
                                    ? 'bg-brand-light text-brand-dark shadow-[0_0_30px_rgba(220,214,247,0.5)] border-none' 
                                    : 'bg-brand-white/20 border border-brand-white/20';
                                
                                $headerText = $isCurrentSem ? 'text-brand-dark' : 'text-brand-white';
                                $subText = $isCurrentSem ? 'text-brand-dark/70' : 'text-brand-medium';
                                
                                $badgeText = $isCurrentSem ? "IN PROGRESS" : ($isPastSem ? "COMPLETED" : "");
                                $badgeClass = $isCurrentSem ? "bg-brand-dark text-brand-white" : ($isPastSem ? "bg-brand-medium text-brand-dark" : "");
                                
                                $tableHeaderBg = $isCurrentSem ? 'bg-brand-dark/10 text-brand-dark' : 'bg-brand-white/30 text-brand-white';
                                $rowBg = $isCurrentSem ? 'bg-brand-white/40' : 'bg-brand-white/20';
                                $rowHover = $isCurrentSem ? 'hover:bg-brand-white hover:shadow-lg' : 'hover:bg-brand-white/40 hover:shadow-lg';
                                
                                $codeColor = $isCurrentSem ? 'text-brand-dark font-extrabold' : 'text-brand-light font-bold';
                                $textColor = $isCurrentSem ? 'text-brand-dark' : 'text-brand-white';
                            @endphp

                            <div class="rounded-[2rem] p-6 backdrop-blur-md {{ $cardClasses }} animate-fade-in-up">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $isCurrentSem ? 'bg-brand-dark text-brand-white' : 'bg-brand-white/20 text-brand-white' }} font-bold text-lg shadow-md">
                                            {{ $sem }}
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-bold {{ $headerText }}">Semester {{ $sem }}</h3>
                                            @if($isCurrentSem)
                                                <p class="text-xs font-bold uppercase tracking-widest {{ $subText }}">Current Session</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($badgeText)
                                        <span class="px-4 py-1.5 rounded-full {{ $badgeClass }} text-xs font-bold shadow-md tracking-wider">{{ $badgeText }}</span>
                                    @endif
                                </div>
                                <div class="overflow-hidden rounded-2xl border {{ $isCurrentSem ? 'border-brand-dark/10' : 'border-brand-white/10' }}">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="{{ $tableHeaderBg }} text-xs uppercase tracking-wider">
                                                <th class="py-3 px-5 font-bold">Code</th>
                                                <th class="py-3 px-5 font-bold">Course Name</th>
                                                <th class="py-3 px-5 text-center font-bold">Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y {{ $isCurrentSem ? 'divide-brand-dark/10' : 'divide-brand-white/10' }}">
                                            @foreach($courses as $course)
                                                <tr class="{{ $rowBg }} {{ $rowHover }} transition-all duration-200 cursor-default">
                                                    <td class="py-4 px-5 {{ $codeColor }} text-sm whitespace-nowrap">{{ $course->courseCode }}</td>
                                                    <td class="py-4 px-5 {{ $textColor }} text-sm font-medium">{{ $course->courseName }}</td>
                                                    <td class="py-4 px-5 text-center {{ $textColor }} text-sm font-bold opacity-80">{{ $course->courseCreds }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div x-show="showFacultyModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div x-show="showFacultyModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-brand-dark/80 backdrop-blur-lg transition-opacity" 
                 @click="showFacultyModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showFacultyModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-[2rem] bg-[#2a2e4b] border border-brand-white/20 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-medium text-brand-dark font-bold text-xl shadow-lg">
                                    {{ Auth::user()->facCode }}
                                </div>
                                <h3 class="text-2xl font-extrabold text-brand-white" id="modal-title">
                                    {{ Auth::user()->faculty->facName ?? 'Faculty Details' }}
                                </h3>
                            </div>
                            <button @click="showFacultyModal = false" class="text-brand-medium hover:text-brand-white transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-6">
                            <p class="text-lg text-brand-light leading-relaxed">
                                {{ Auth::user()->faculty->facDesc ?? 'No description available for this faculty.' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-black/20 px-6 py-4 flex flex-row-reverse">
                        <button type="button" 
                                class="inline-flex w-full justify-center rounded-xl bg-brand-medium px-5 py-3 text-base font-bold text-brand-dark shadow-lg hover:bg-brand-white hover:scale-105 transition-all duration-200 sm:ml-3 sm:w-auto" 
                                @click="showFacultyModal = false">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>