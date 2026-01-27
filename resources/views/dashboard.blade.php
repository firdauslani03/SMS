<x-app-layout title="Dashboard">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-bold text-brand-white">
                    Academic Roadmap
                </h1>
                <p class="text-brand-light mt-1">
                    Program Structure for <span class="text-brand-medium font-semibold">{{ Auth::user()->progCode }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 animate-fade-in-up delay-100">
                    <div class="bg-brand-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-brand-medium/20 sticky top-6">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="h-16 w-16 rounded-full bg-gradient-to-br from-brand-medium to-brand-dark flex items-center justify-center text-brand-white text-2xl font-bold shadow-lg">
                                {{ substr(Auth::user()->fName, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-brand-white">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</h2>
                                <p class="text-brand-medium font-medium">{{ Auth::user()->matricNum }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl bg-brand-dark/30 border border-brand-white/5">
                                    <p class="text-xs text-brand-light uppercase tracking-wider">Current Sem</p>
                                    <p class="text-brand-white font-bold text-xl">{{ Auth::user()->semester }}</p>
                                </div>
                                <div class="p-4 rounded-xl bg-brand-dark/30 border border-brand-white/5">
                                    <p class="text-xs text-brand-light uppercase tracking-wider">CGPA</p>
                                    <p class="text-brand-medium font-bold text-xl">{{ number_format(Auth::user()->cgpa, 2) }}</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-brand-dark/30 border border-brand-white/5">
                                <p class="text-xs text-brand-light uppercase tracking-wider">Program</p>
                                <p class="text-brand-white font-semibold">{{ Auth::user()->progCode }}</p>
                                <p class="text-xs text-brand-light mt-1">{{ Auth::user()->facCode }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    
                    @if($curriculum->isEmpty())
                         <div class="bg-brand-white/10 backdrop-blur-lg rounded-2xl p-8 text-center border border-brand-medium/20">
                            <p class="text-brand-light">No curriculum data found for this program code.</p>
                         </div>
                    @else
                        @foreach($curriculum as $sem => $courses)
                            @php
                                $isCurrentSem = ($sem == Auth::user()->semester);
                                $cardClasses = $isCurrentSem 
                                    ? 'bg-brand-white/15 border-brand-medium shadow-[0_0_15px_rgba(var(--color-brand-medium),0.3)] transform scale-[1.02]' 
                                    : 'bg-brand-white/5 border-brand-white/10 opacity-70 hover:opacity-100';
                            @endphp

                            <div class="rounded-2xl p-6 backdrop-blur-md border transition-all duration-300 {{ $cardClasses }} animate-fade-in-up">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-bold text-brand-white">
                                        Semester {{ $sem }}
                                    </h3>
                                    @if($isCurrentSem)
                                        <span class="px-3 py-1 rounded-full bg-brand-medium text-brand-dark text-xs font-bold shadow-lg">
                                            CURRENT
                                        </span>
                                    @endif
                                </div>

                                <div class="overflow-hidden rounded-xl border border-brand-white/5">
                                    <table class="w-full text-left bg-brand-dark/20">
                                        <thead>
                                            <tr class="text-brand-light text-xs uppercase tracking-wider bg-brand-white/5">
                                                <th class="py-3 px-4 font-medium">Code</th>
                                                <th class="py-3 px-4 font-medium">Course Name</th>
                                                <th class="py-3 px-4 text-center font-medium">Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-brand-white/5">
                                            @foreach($courses as $course)
                                                <tr class="hover:bg-brand-white/5 transition-colors">
                                                    <td class="py-3 px-4 text-brand-medium font-bold text-sm whitespace-nowrap">
                                                        {{ $course->courseCode }}
                                                    </td>
                                                    <td class="py-3 px-4 text-brand-white text-sm">
                                                        {{ $course->courseName }}
                                                        @if($course->coursePreReq)
                                                            <div class="text-xs text-brand-light/60 mt-0.5">
                                                                Pre-req: {{ $course->coursePreReq }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 text-center text-brand-light text-sm">
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