<x-admin-layout title="Admin Dashboard">
    <div class="animate-fade-in-up space-y-10">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-brand-white/10 pb-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-brand-white tracking-tight drop-shadow-lg">
                    Dashboard
                </h1>
                <p class="text-brand-light mt-2 text-xl font-medium">
                    Overview for <span class="text-brand-medium">{{ Auth::guard('it_staff')->user()->fName }}</span>
                </p>
            </div>
            
            <div class="text-right">
                <p class="text-brand-light/60 text-sm font-bold uppercase tracking-widest mb-1">Current Date</p>
                <div class="text-3xl md:text-4xl font-black text-white tracking-tight flex items-center justify-end gap-3">
                    <svg class="w-8 h-8 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ now()->format('l, d M Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="relative group p-1 rounded-[2rem] bg-gradient-to-br from-brand-medium/50 to-transparent hover:to-brand-medium/30 transition-all duration-300 shadow-lg hover:shadow-brand-medium/20 hover:-translate-y-1">
                <div class="h-full bg-[#2a2e4b] rounded-[1.9rem] p-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-brand-medium/20 blur-3xl rounded-full pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-start justify-between">
                            <div class="p-3 rounded-2xl bg-brand-medium/10 text-brand-medium">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-brand-light/50 uppercase tracking-wider border border-brand-white/10 px-2 py-1 rounded-lg">System</span>
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-5xl font-black text-white tracking-tighter">{{ $totalCourses }}</h3>
                            <p class="text-brand-light font-bold text-sm mt-1">Total Courses Available</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative group p-1 rounded-[2rem] bg-gradient-to-br from-amber-500/50 to-transparent hover:to-amber-500/30 transition-all duration-300 shadow-lg hover:shadow-amber-500/20 hover:-translate-y-1">
                <div class="h-full bg-[#2a2e4b] rounded-[1.9rem] p-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/20 blur-3xl rounded-full pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-start justify-between">
                            <div class="p-3 rounded-2xl bg-amber-500/10 text-amber-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-amber-500/80 uppercase tracking-wider border border-amber-500/20 px-2 py-1 rounded-lg bg-amber-500/5">Action Needed</span>
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-5xl font-black text-white tracking-tighter">{{ $pendingRegistrations }}</h3>
                            <p class="text-brand-light font-bold text-sm mt-1">Pending Approvals</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative group p-1 rounded-[2rem] bg-gradient-to-br from-emerald-500/50 to-transparent hover:to-emerald-500/30 transition-all duration-300 shadow-lg hover:shadow-emerald-500/20 hover:-translate-y-1">
                <div class="h-full bg-[#2a2e4b] rounded-[1.9rem] p-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/20 blur-3xl rounded-full pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-start justify-between">
                            <div class="p-3 rounded-2xl bg-emerald-500/10 text-emerald-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-emerald-500/80 uppercase tracking-wider border border-emerald-500/20 px-2 py-1 rounded-lg bg-emerald-500/5">Completed</span>
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-5xl font-black text-white tracking-tighter">{{ $approvedRegistrations }}</h3>
                            <p class="text-brand-light font-bold text-sm mt-1">Approved Registrations</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-brand-white/5 border border-brand-white/10 rounded-[2rem] shadow-2xl overflow-hidden flex flex-col h-full backdrop-blur-sm">
            <div class="p-8 border-b border-brand-white/10 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-brand-white flex items-center gap-3">
                    Recent Activity
                </h3>
                <a href="#" class="text-sm font-bold text-brand-medium hover:text-brand-white transition-colors bg-brand-white/5 px-4 py-2 rounded-lg hover:bg-brand-white/10">View Full Log &rarr;</a>
            </div>

            <div class="flex-1 overflow-auto">
                @if($recentRegistrations->isEmpty())
                    <div class="p-10 text-center text-brand-light/50 flex flex-col items-center">
                        <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <p class="text-lg">No recent registration activity.</p>
                    </div>
                @else
                    <div class="divide-y divide-brand-white/5">
                        @foreach($recentRegistrations as $reg)
                        <div class="p-6 hover:bg-brand-white/5 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                            
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-brand-medium to-brand-light flex items-center justify-center font-bold text-brand-dark text-lg shadow-lg shrink-0">
                                    {{ substr($reg->fName, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-brand-white font-bold text-lg group-hover:text-brand-medium transition-colors">
                                        {{ $reg->courseName }}
                                    </p>
                                    <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-3 text-sm text-brand-light/70">
                                        <span class="font-mono text-brand-medium font-semibold">{{ $reg->courseCode }}</span>
                                        <span class="hidden md:inline text-brand-white/20">|</span>
                                        <span>{{ $reg->fName }} {{ $reg->lName }}</span>
                                        <span class="hidden md:inline text-brand-white/20">|</span>
                                        <span class="font-mono text-xs opacity-70">{{ $reg->matricNum }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 justify-between md:justify-end w-full md:w-auto mt-2 md:mt-0">
                                <div class="text-right hidden md:block">
                                    <p class="text-brand-white font-medium text-sm">
                                        {{ \Carbon\Carbon::parse($reg->registrationDate)->format('d M Y') }}
                                    </p>
                                    <p class="text-brand-light/40 text-xs font-mono">
                                        {{ \Carbon\Carbon::parse($reg->registrationTime)->format('H:i') }}
                                    </p>
                                </div>

                                <span class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm
                                    {{ $reg->status === 'Approved' ? 'bg-emerald-500 text-emerald-950' : '' }}
                                    {{ $reg->status === 'Pending' ? 'bg-amber-400 text-amber-950' : '' }}
                                    {{ $reg->status === 'Rejected' ? 'bg-red-500 text-white' : '' }}">
                                    {{ $reg->status }}
                                </span>
                            </div>

                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-admin-layout>