<x-app-layout title="Student Dashboard">
    <div class="py-10">
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
                                    <span class="px-3 py-1 rounded-lg bg-brand-white/20 text-brand-white text-sm font-bold border border-brand-white/10">{{ Auth::user()->facCode }}</span>
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
                                
                                if ($isCurrentSem) {
                                    $badgeText = "IN PROGRESS";
                                    $badgeClass = "bg-brand-dark text-brand-white";
                                } elseif ($isPastSem) {
                                    $badgeText = "COMPLETED";
                                    $badgeClass = "bg-brand-medium text-brand-dark";
                                } else {
                                    $badgeText = "";
                                    $badgeClass = "";
                                }
                                
                                $tableHeaderBg = $isCurrentSem ? 'bg-brand-dark/10 text-brand-dark' : 'bg-brand-white/30 text-brand-white';
                                $rowBg = $isCurrentSem ? 'bg-brand-white/40' : 'bg-brand-white/20';
                                $rowHover = $isCurrentSem 
                                    ? 'hover:bg-brand-white hover:shadow-lg hover:scale-[1.01]' 
                                    : 'hover:bg-brand-white/40 hover:shadow-lg hover:scale-[1.01]';
                                
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
                                            <h3 class="text-2xl font-bold {{ $headerText }}">
                                                Semester {{ $sem }}
                                            </h3>
                                            @if($isCurrentSem)
                                                <p class="text-xs font-bold uppercase tracking-widest {{ $subText }}">Current Session</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($badgeText)
                                        <span class="px-4 py-1.5 rounded-full {{ $badgeClass }} text-xs font-bold shadow-md tracking-wider">
                                            {{ $badgeText }}
                                        </span>
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
                                                    <td class="py-4 px-5 {{ $codeColor }} text-sm whitespace-nowrap">
                                                        {{ $course->courseCode }}
                                                    </td>
                                                    <td class="py-4 px-5 {{ $textColor }} text-sm font-medium">
                                                        {{ $course->courseName }}
                                                    </td>
                                                    <td class="py-4 px-5 text-center {{ $textColor }} text-sm font-bold opacity-80">
                                                        {{ $course->courseCreds }}
                                                    </td>
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
    </div>
</x-app-layout>