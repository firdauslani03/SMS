<x-app-layout title="My Submissions">
    {{-- Alpine Data for Modals --}}
    <div class="py-12 print:hidden" x-data="{ 
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
                        {{-- THE WEB VIEW CARD --}}
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
            
            {{-- Modals remain unchanged but hidden in print --}}
            {{-- CANCEL MODAL --}}
            <div x-show="cancelModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                <div x-show="cancelModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div @click.away="cancelModalOpen = false" class="bg-brand-dark rounded-2xl border border-red-500/30 max-w-md w-full p-8 relative shadow-[0_0_50px_rgba(239,68,68,0.2)]">
                        <h3 class="text-2xl font-bold text-brand-white mb-4">Cancel Registration</h3>
                        <p class="text-brand-light mb-6 text-lg">Are you sure you want to cancel your <strong class="text-brand-white">entire course registration</strong> for this semester?</p>
                        <form action="{{ route('course.cancel') }}" method="POST" class="flex gap-4">
                            @csrf
                            <button type="button" @click="cancelModalOpen = false" class="flex-1 py-3 rounded-xl border border-brand-white/10 text-brand-light hover:text-brand-white">Back</button>
                            <button type="submit" class="flex-1 py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 shadow-lg">Confirm Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MODIFY MODAL --}}
            <div x-show="modifyModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                <div x-show="modifyModalOpen" class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md transition-opacity"></div>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div @click.away="modifyModalOpen = false" class="bg-brand-dark rounded-2xl border border-blue-500/30 max-w-md w-full p-8 relative shadow-[0_0_50px_rgba(59,130,246,0.2)]">
                        <h3 class="text-2xl font-bold text-brand-white mb-4">Modify Registration</h3>
                        <p class="text-brand-light mb-6 text-lg">Request changes to your current registration?</p>
                        <form action="{{ route('course.modify') }}" method="POST" class="flex gap-4">
                            @csrf
                            <button type="button" @click="modifyModalOpen = false" class="flex-1 py-3 rounded-xl border border-brand-white/10 text-brand-light hover:text-brand-white">Back</button>
                            <button type="submit" class="flex-1 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-lg">Request Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- OFFICIAL PRINT SLIP (Visible only in Print) --}}
    {{-- ========================================== --}}
    <div id="print-slip" class="hidden font-serif bg-white text-black p-8">
        
        {{-- 1. Header with Logo --}}
        <div class="flex items-center justify-between border-b-4 border-double border-black pb-6 mb-8">
            <div class="flex items-center gap-6">
                {{-- Using the existing logo, grayscaled for professionalism --}}
                <img src="{{ asset('images/smslogo.png') }}" alt="University Logo" class="h-24 w-auto grayscale opacity-90">
                <div>
                    <h1 class="text-xl font-bold uppercase tracking-widest leading-tight">University of Ionia</h1>
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Academic Affairs Division</p>
                    <p class="text-xs text-gray-500 mt-1">Official Course Registration Record</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-extrabold uppercase tracking-widest border-2 border-black px-4 py-1 inline-block mb-2">
                    CR-Slip
                </h2>
                <p class="text-sm font-bold mt-1">Semester {{ Auth::user()->semester }}</p>
                <p class="text-xs text-gray-500 italic">Generated: {{ now()->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        {{-- 2. Student Metadata Grid --}}
        <div class="bg-gray-50 border border-black p-4 mb-8">
            <h3 class="text-sm font-bold uppercase border-b border-black/20 pb-2 mb-4">Student Particulars</h3>
            <div class="grid grid-cols-2 gap-x-12 gap-y-3 text-sm">
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Full Name:</span>
                    <span class="font-bold uppercase flex-1">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Matric Number:</span>
                    <span class="font-mono font-bold tracking-wider text-base">{{ Auth::user()->matricNum }}</span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Faculty:</span>
                    <span class="uppercase flex-1">{{ Auth::user()->facCode }}</span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Programme:</span>
                    <span class="uppercase flex-1">{{ Auth::user()->progCode }}</span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Academic Status:</span>
                    <span class="uppercase font-bold text-black border border-black px-2 py-0.5 text-xs">Active</span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 font-bold text-gray-600 uppercase text-xs pt-0.5">Registration Date:</span>
                    <span class="uppercase">{{ $submissionDate ? \Carbon\Carbon::parse($submissionDate)->format('d F Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        {{-- 3. Course Table --}}
        <div class="mb-8">
            <h3 class="text-sm font-bold uppercase mb-2">Registered Courses</h3>
            <table class="w-full border-collapse border border-black text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-black px-3 py-2 text-center w-12 font-bold text-xs uppercase">No.</th>
                        <th class="border border-black px-3 py-2 text-left w-32 font-bold text-xs uppercase">Course Code</th>
                        <th class="border border-black px-3 py-2 text-left font-bold text-xs uppercase">Course Description</th>
                        <th class="border border-black px-3 py-2 text-center w-20 font-bold text-xs uppercase">Credits</th>
                        <th class="border border-black px-3 py-2 text-center w-24 font-bold text-xs uppercase">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registeredCourses as $index => $course)
                        <tr>
                            <td class="border border-black px-3 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-black px-3 py-2 font-mono font-bold">{{ $course->courseCode }}</td>
                            <td class="border border-black px-3 py-2 uppercase">{{ $course->courseName }}</td>
                            <td class="border border-black px-3 py-2 text-center">{{ $course->courseCreds }}</td>
                            <td class="border border-black px-3 py-2 text-center text-xs uppercase font-bold">
                                {{ $course->pivot->status }}
                            </td>
                        </tr>
                    @endforeach
                    {{-- Fill empty rows to make it look full if few courses --}}
                    @for($i = $registeredCourses->count(); $i < 6; $i++)
                         <tr>
                            <td class="border border-black px-3 py-2 text-center">&nbsp;</td>
                            <td class="border border-black px-3 py-2">&nbsp;</td>
                            <td class="border border-black px-3 py-2">&nbsp;</td>
                            <td class="border border-black px-3 py-2">&nbsp;</td>
                            <td class="border border-black px-3 py-2">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="3" class="border border-black px-3 py-2 text-right uppercase text-xs">Total Credit Hours</td>
                        <td class="border border-black px-3 py-2 text-center text-base">{{ $totalCredits }}</td>
                        <td class="border border-black bg-gray-300"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- 4. Declaration & Signatures --}}
        <div class="mt-12 border-t-2 border-black pt-8">
            <p class="text-xs text-justify mb-12 italic leading-relaxed">
                I hereby declare that the information provided above is correct. I understand that any discrepancy in the registration record is my responsibility. 
                I agree to abide by the academic regulations of the University.
            </p>

            <div class="grid grid-cols-2 gap-20">
                <div class="text-center">
                    <div class="border-b border-black border-dashed mb-2 h-16 relative">
                        {{-- Optional: Digital Sig Placeholder --}}
                        {{-- <span class="absolute bottom-1 left-0 right-0 text-gray-300 text-[10px] uppercase">Digital Signature</span> --}}
                    </div>
                    <p class="font-bold text-sm uppercase">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</p>
                    <p class="text-xs uppercase tracking-wider text-gray-500">Student Signature</p>
                </div>
                <div class="text-center">
                    <div class="border-b border-black border-dashed mb-2 h-16"></div>
                    <p class="font-bold text-sm uppercase">Academic Advisor</p>
                    <p class="text-xs uppercase tracking-wider text-gray-500">Signature & Official Stamp</p>
                </div>
            </div>
        </div>

        {{-- 5. Footer Disclaimer --}}
        <div class="absolute bottom-8 left-8 right-8 text-center border-t border-gray-300 pt-2">
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">
                This document is computer generated and valid without signature for reference purposes.
                <br>
                ISO 9001:2015 Certified | System Generated ID: {{ uniqid() }}
            </p>
        </div>
    </div>

    {{-- Print Logic Overrides --}}
    <style>
        @media print {
            /* 1. HIDE EVERYTHING by default using visibility */
            /* This preserves the layout flow but makes it invisible, preventing parents from collapsing */
            body * {
                visibility: hidden;
            }

            /* 2. SHOW THE SLIP */
            /* We target the print slip and ALL its children to be visible */
            #print-slip, #print-slip * {
                visibility: visible;
            }

            /* 3. POSITION THE SLIP */
            /* Fixed positioning pulls it out of the nested DOM and puts it on top of the page */
            #print-slip {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 20px;
                background-color: white; /* Ensure it has a background to cover anything else */
                display: block !important; /* Force block in case Tailwind 'hidden' is stubborn */
                z-index: 9999;
            }

            /* 4. RESET PAGE MARGINS */
            @page { 
                margin: 0; 
                size: auto;
            }
            body {
                margin: 0;
                background-color: white;
            }
        }
    </style>
</x-app-layout>