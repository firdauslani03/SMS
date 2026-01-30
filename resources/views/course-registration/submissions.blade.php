<x-app-layout title="My Submissions">
    {{-- Alpine Data for Modals --}}
    <div class="py-12" x-data="{ 
        cancelModalOpen: false, 
        modifyModalOpen: false 
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Page Header --}}
            <div class="mb-10 animate-fade-in-up">
                <h1 class="text-5xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                    Course Submissions
                </h1>
                <p class="text-brand-light mt-3 text-xl font-medium">
                    Review your official registration record for <span class="font-bold text-brand-white">Semester {{ Auth::user()->semester }}</span>
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
                
                {{-- Sidebar Navigation (RESIZED TO MATCH STANDARD) --}}
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
                        
                        {{-- Active State --}}
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
                <div class="lg:col-span-3 animate-fade-in-up delay-200">
                    
                    @if($registeredCourses->isEmpty())
                        {{-- No Submissions State --}}
                        <div class="bg-brand-white/10 backdrop-blur-lg rounded-3xl p-16 text-center border border-brand-white/20 flex flex-col items-center justify-center min-h-[450px]">
                            <div class="bg-brand-white/5 p-8 rounded-full mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-brand-light/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-4xl font-extrabold text-brand-white mb-4">No Active Registration</h2>
                            <p class="text-brand-light text-xl mb-10 max-w-lg">You haven't submitted any course registrations for this session yet.</p>
                            <a href="{{ route('course.registration') }}" class="px-10 py-4 rounded-xl bg-brand-medium text-brand-dark text-lg font-bold hover:bg-brand-white hover:scale-105 transition-all duration-300 shadow-lg">
                                Start Registration
                            </a>
                        </div>
                    @else
                        {{-- THE UNIFIED TICKET CONTAINER --}}
                        <div class="relative">
                            
                            {{-- Glow Effect Behind --}}
                            <div class="absolute -inset-1 bg-gradient-to-r from-brand-medium via-purple-500 to-brand-medium rounded-[2.5rem] blur opacity-30 animate-pulse"></div>

                            {{-- Main Card --}}
                            <div class="relative bg-brand-dark/90 backdrop-blur-2xl rounded-[2rem] border border-brand-white/20 shadow-2xl overflow-hidden">
                                
                                {{-- DECORATIVE WATERMARK --}}
                                <div class="absolute top-0 right-0 -mt-10 -mr-10 text-[12rem] font-black text-brand-white/5 select-none pointer-events-none leading-none z-0">
                                    {{ Auth::user()->facCode }}
                                </div>

                                {{-- 1. HEADER SECTION (Identity) --}}
                                <div class="relative z-10 p-10 border-b border-brand-white/10 bg-brand-white/5">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                        <div>
                                            <h2 class="text-4xl font-black text-brand-white tracking-tight uppercase">
                                                Registration Slip
                                            </h2>
                                            <p class="text-brand-medium font-bold text-sm tracking-[0.2em] uppercase mt-2">
                                                Official Student Record
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-5 bg-black/20 px-6 py-3 rounded-2xl border border-brand-white/5">
                                            <div class="text-right">
                                                <p class="text-brand-white font-bold text-lg">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</p>
                                                <p class="text-brand-light text-sm font-mono tracking-wider">{{ Auth::user()->matricNum }}</p>
                                            </div>
                                            <div class="h-12 w-12 rounded-full bg-brand-medium flex items-center justify-center text-brand-dark font-bold text-xl">
                                                {{ substr(Auth::user()->fName, 0, 1) }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Meta Grid --}}
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                                        <div>
                                            <span class="text-xs text-brand-light/50 uppercase font-bold tracking-wider">Programme</span>
                                            <p class="text-brand-white font-bold text-lg mt-1">{{ Auth::user()->progCode }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-brand-light/50 uppercase font-bold tracking-wider">Faculty</span>
                                            <p class="text-brand-white font-bold text-lg mt-1">{{ Auth::user()->facCode }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-brand-light/50 uppercase font-bold tracking-wider">Semester</span>
                                            <p class="text-brand-white font-bold text-lg mt-1">Sem {{ Auth::user()->semester }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-brand-light/50 uppercase font-bold tracking-wider">Submitted</span>
                                            <p class="text-brand-white font-bold text-lg mt-1">
                                                {{ $submissionDate ? \Carbon\Carbon::parse($submissionDate)->format('d M Y') : 'Pending' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. TICKET BODY (The List) --}}
                                <div class="relative z-10 p-10 bg-gradient-to-b from-transparent to-brand-dark/50">
                                    
                                    {{-- Receipt "Jagged Edge" Divider Visual --}}
                                    <div class="flex items-center gap-4 mb-8">
                                        <div class="h-px bg-brand-white/20 flex-1"></div>
                                        <span class="text-xs font-bold text-brand-light/50 uppercase tracking-[0.2em]">Course Details</span>
                                        <div class="h-px bg-brand-white/20 flex-1"></div>
                                    </div>

                                    <div class="overflow-hidden rounded-xl border border-brand-white/10">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-brand-white/5 text-brand-light text-xs uppercase tracking-wider">
                                                    <th class="p-5 font-bold border-b border-brand-white/10">Code</th>
                                                    <th class="p-5 font-bold border-b border-brand-white/10">Course Name</th>
                                                    <th class="p-5 font-bold border-b border-brand-white/10 text-center">Credits</th>
                                                    <th class="p-5 font-bold border-b border-brand-white/10 text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-brand-white/5 text-base">
                                                @foreach($registeredCourses as $course)
                                                    <tr class="hover:bg-brand-white/5 transition-colors group">
                                                        <td class="p-5 font-mono font-bold text-brand-medium group-hover:text-brand-white transition-colors text-lg">
                                                            {{ $course->courseCode }}
                                                        </td>
                                                        <td class="p-5 font-medium text-brand-white text-lg">
                                                            {{ $course->courseName }}
                                                        </td>
                                                        <td class="p-5 text-center">
                                                            <span class="inline-block px-3 py-1.5 rounded-md bg-brand-white/5 text-sm font-bold text-brand-light border border-brand-white/10">
                                                                {{ $course->courseCreds }}
                                                            </span>
                                                        </td>
                                                        <td class="p-5 text-right">
                                                            @php
                                                                $status = $course->pivot->status;
                                                                $statusColor = match(strtolower($status)) {
                                                                    'submitted' => 'text-green-400',
                                                                    'approved' => 'text-green-400',
                                                                    'pending' => 'text-yellow-400',
                                                                    'cancellation pending' => 'text-red-400',
                                                                    'modification pending' => 'text-blue-400',
                                                                    default => 'text-brand-light',
                                                                };
                                                            @endphp
                                                            <span class="font-bold text-xs {{ $statusColor }} uppercase tracking-wider bg-black/30 px-3 py-1 rounded-full">
                                                                {{ $status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="bg-brand-white/5">
                                                    <td colspan="2" class="p-5 text-right text-brand-light font-bold text-sm uppercase tracking-wider">Total Credits</td>
                                                    <td class="p-5 text-center font-black text-brand-white text-2xl">{{ $totalCredits }}</td>
                                                    <td class="p-5"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                {{-- 3. FOOTER (Global Actions) --}}
                                <div class="relative z-10 p-8 bg-black/40 border-t border-brand-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                                    
                                    {{-- Status Badge --}}
                                    <div class="flex items-center gap-4">
                                        <div class="relative flex h-3 w-3">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </div>
                                        <span class="text-brand-light font-medium text-base">
                                            Status: <strong class="text-brand-white">{{ $submissionStatus }}</strong>
                                        </span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex gap-4 w-full md:w-auto">
                                        {{-- Only show Modify/Cancel if status is strictly 'Submitted' --}}
                                        @if($submissionStatus === 'Submitted')
                                            <button @click="modifyModalOpen = true" 
                                                    class="flex-1 px-6 py-3 rounded-xl border border-blue-500/30 text-blue-300 font-bold hover:bg-blue-500 hover:text-white transition-all">
                                                Modify
                                            </button>
                                            <button @click="cancelModalOpen = true" 
                                                    class="flex-1 px-6 py-3 rounded-xl border border-red-500/30 text-red-300 font-bold hover:bg-red-500 hover:text-white transition-all">
                                                Cancel
                                            </button>
                                        @endif

                                        <button onclick="window.print()" class="flex-1 md:flex-none flex items-center justify-center gap-3 px-8 py-3.5 rounded-xl bg-brand-medium text-brand-dark font-black hover:bg-brand-white hover:scale-105 transition-all shadow-[0_0_20px_rgba(166,177,225,0.4)] text-base">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Print Slip
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- CANCEL MODAL (Global) --}}
        <div x-show="cancelModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div x-show="cancelModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click.away="cancelModalOpen = false" class="bg-brand-dark rounded-2xl border border-red-500/30 max-w-md w-full p-8 relative shadow-[0_0_50px_rgba(239,68,68,0.2)]">
                    <h3 class="text-2xl font-bold text-brand-white mb-4">Cancel Registration</h3>
                    <p class="text-brand-light mb-6 text-lg">Are you sure you want to cancel your <strong class="text-brand-white">entire course registration</strong> for this semester?</p>
                    <p class="text-red-400 text-sm mb-6 bg-red-500/10 p-4 rounded-xl border border-red-500/20">
                        Warning: This will flag your submission for cancellation. An advisor must approve this action.
                    </p>
                    <form action="{{ route('course.cancel') }}" method="POST" class="flex gap-4">
                        @csrf
                        <button type="button" @click="cancelModalOpen = false" class="flex-1 py-3 rounded-xl border border-brand-white/10 text-brand-light hover:text-brand-white">Back</button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 shadow-lg">Confirm Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODIFY MODAL (Global) --}}
        <div x-show="modifyModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div x-show="modifyModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click.away="modifyModalOpen = false" class="bg-brand-dark rounded-2xl border border-blue-500/30 max-w-md w-full p-8 relative shadow-[0_0_50px_rgba(59,130,246,0.2)]">
                    <h3 class="text-2xl font-bold text-brand-white mb-4">Modify Registration</h3>
                    <p class="text-brand-light mb-6 text-lg">Do you want to request changes to your current registration?</p>
                    <p class="text-blue-300 text-sm mb-6 bg-blue-500/10 p-4 rounded-xl border border-blue-500/20">
                        This will change your status to <strong>"Modification Pending"</strong>. Once approved, your submission will be unlocked for editing.
                    </p>
                    <form action="{{ route('course.modify') }}" method="POST" class="flex gap-4">
                        @csrf
                        <button type="button" @click="modifyModalOpen = false" class="flex-1 py-3 rounded-xl border border-brand-white/10 text-brand-light hover:text-brand-white">Back</button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-lg">Request Edit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            nav, header, .animate-pulse, a[href*="course.registration"], .lg\:col-span-1 { display: none !important; }
            .lg\:col-span-3 { width: 100% !important; margin: 0 !important; }
            body { background: white !important; color: black !important; }
            .bg-brand-dark\/90 { background: white !important; border: 2px solid black !important; box-shadow: none !important; }
            .text-brand-white { color: black !important; }
            .text-brand-light { color: #555 !important; }
            .bg-brand-white\/5 { background: #f3f3f3 !important; }
            .text-brand-medium { color: black !important; }
        }
    </style>
</x-app-layout>