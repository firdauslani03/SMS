<x-admin-layout title="Manage Registrations">
    <div x-data="{ 
            detailsModalOpen: false,
            amendModalOpen: false,
            selectedReg: null,
            openDetails(reg) {
                this.selectedReg = reg;
                this.detailsModalOpen = true;
            },
            openAmend(reg) {
                this.selectedReg = reg;
                this.amendModalOpen = true;
            }
        }">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-brand-white">Registrations</h1>
                <p class="text-brand-light mt-1">Manage student course enrollments.</p>
            </div>
            
            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                {{-- Status Filter: Updated text to black/dark for readability options --}}
                <select name="status" class="bg-brand-white/10 border border-brand-white/20 text-brand-white rounded-xl px-4 py-2 focus:ring-brand-medium outline-none">
                    <option value="all" class="text-brand-dark bg-brand-white" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="Pending" class="text-brand-dark bg-brand-white" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Waiting for Approval" class="text-brand-dark bg-brand-white" {{ request('status') === 'Waiting for Approval' ? 'selected' : '' }}>Waiting for Approval</option>
                    <option value="Approved" class="text-brand-dark bg-brand-white" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Disapproved" class="text-brand-dark bg-brand-white" {{ request('status') === 'Disapproved' ? 'selected' : '' }}>Disapproved</option>
                    <option value="Cancelled" class="text-brand-dark bg-brand-white" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student or course..." 
                           class="w-full md:w-64 bg-brand-white/10 border border-brand-white/20 text-brand-white placeholder-brand-light/50 rounded-xl pl-10 pr-4 py-2 focus:ring-brand-medium outline-none">
                    <div class="absolute left-3 top-2.5 text-brand-light/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button type="submit" class="bg-brand-medium text-brand-dark font-bold px-6 py-2 rounded-xl hover:bg-brand-white transition-colors">
                    Filter
                </button>
            </form>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-200 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 text-red-200 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-[#2a2e4b] border border-brand-white/10 rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-black/20 text-brand-light text-base uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">Student</th>
                            <th class="px-6 py-4 font-bold">Course</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-white/5">
                        @forelse($registrations as $reg)
                            <tr class="hover:bg-brand-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-full bg-brand-medium/20 text-brand-medium flex items-center justify-center font-bold text-lg">
                                            {{ substr($reg->fName, 0, 1) }}{{ substr($reg->lName, 0, 1) }}
                                        </div>
                                        <div>
                                            {{-- Increased font size --}}
                                            <div class="font-bold text-brand-white text-lg">{{ $reg->fName }} {{ $reg->lName }}</div>
                                            <div class="text-sm text-brand-light">{{ $reg->matricNum }} • {{ $reg->progCode }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Increased font size --}}
                                    <div class="font-bold text-brand-white text-base">{{ $reg->courseCode }}</div>
                                    <div class="text-sm text-brand-light truncate max-w-[200px]">{{ $reg->courseName }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'Approved' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                            'Waiting for Approval' => 'bg-orange-500/20 text-orange-400 border-orange-500/30',
                                            'Pending' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                            'Disapproved' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                            'Cancelled' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                        ];
                                        $colorClass = $colors[$reg->status] ?? 'bg-brand-white/10 text-brand-white';
                                    @endphp
                                    {{-- Increased Badge Text Size --}}
                                    <span class="px-3 py-1 rounded-full text-sm font-bold border {{ $colorClass }}">
                                        {{ $reg->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Changed justify-center to justify-end to hug right side --}}
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View Details --}}
                                        <button @click="openDetails({{ json_encode($reg) }})" 
                                                class="p-2 rounded-lg bg-brand-white/5 text-brand-light hover:bg-brand-white hover:text-brand-dark transition-all" title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        {{-- Approve (Only for Waiting) --}}
                                        @if($reg->status === 'Waiting for Approval')
                                            <form action="{{ route('admin.registrations.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="matricNum" value="{{ $reg->matricNum }}">
                                                <input type="hidden" name="courseCode" value="{{ $reg->courseCode }}">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="p-2 rounded-lg bg-green-500/10 text-green-400 hover:bg-green-500 hover:text-white transition-all" title="Approve">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>

                                            {{-- Cancel (Only for Waiting) --}}
                                            <form action="{{ route('admin.registrations.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="matricNum" value="{{ $reg->matricNum }}">
                                                <input type="hidden" name="courseCode" value="{{ $reg->courseCode }}">
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all" title="Cancel">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Disapprove (Only for Approved) --}}
                                        @if($reg->status === 'Approved')
                                            <form action="{{ route('admin.registrations.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="matricNum" value="{{ $reg->matricNum }}">
                                                <input type="hidden" name="courseCode" value="{{ $reg->courseCode }}">
                                                <input type="hidden" name="action" value="disapprove">
                                                <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all" title="Disapprove">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Amend (Always available) --}}
                                        <button @click="openAmend({{ json_encode($reg) }})" 
                                                class="p-2 rounded-lg bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500 hover:text-white transition-all" title="Amend / Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-brand-light">
                                    No registrations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($registrations->hasPages())
                <div class="px-6 py-4 border-t border-brand-white/10">
                    {{-- Updated Pagination View --}}
                    {{ $registrations->links('pagination.sms') }}
                </div>
            @endif
        </div>

        {{-- DETAILS MODAL --}}
        <div x-show="detailsModalOpen" style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div x-show="detailsModalOpen" class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="detailsModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="detailsModalOpen" 
                     class="bg-[#2a2e4b] rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-brand-white/10 relative">
                    
                    <button @click="detailsModalOpen = false" class="absolute top-4 right-4 text-brand-light hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <h3 class="text-2xl font-bold text-brand-white mb-6">Registration Details</h3>
                    
                    <template x-if="selectedReg">
                        <div class="space-y-4">
                            <div class="bg-brand-white/5 p-4 rounded-xl">
                                <span class="block text-xs uppercase text-brand-light tracking-widest mb-1">Student</span>
                                <p class="text-lg font-bold text-brand-white" x-text="selectedReg.fName + ' ' + selectedReg.lName"></p>
                                <p class="text-sm text-brand-medium" x-text="selectedReg.matricNum"></p>
                                <p class="text-sm text-brand-light/50" x-text="'Program: ' + selectedReg.progCode"></p>
                            </div>

                            <div class="bg-brand-white/5 p-4 rounded-xl">
                                <span class="block text-xs uppercase text-brand-light tracking-widest mb-1">Course</span>
                                <p class="text-lg font-bold text-brand-white" x-text="selectedReg.courseName"></p>
                                <div class="flex gap-4 mt-2">
                                    <span class="text-sm text-brand-medium px-2 py-1 bg-brand-medium/10 rounded" x-text="selectedReg.courseCode"></span>
                                    <span class="text-sm text-brand-light px-2 py-1 bg-brand-white/10 rounded" x-text="selectedReg.courseCreds + ' Credits'"></span>
                                    <span class="text-sm text-brand-light px-2 py-1 bg-brand-white/10 rounded" x-text="'Sem ' + selectedReg.courseSem"></span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center bg-brand-white/5 p-4 rounded-xl">
                                <div>
                                    <span class="block text-xs uppercase text-brand-light tracking-widest mb-1">Status</span>
                                    <span class="font-bold text-lg" x-text="selectedReg.status" 
                                          :class="{
                                              'text-green-400': selectedReg.status === 'Approved',
                                              'text-orange-400': selectedReg.status === 'Waiting for Approval',
                                              'text-red-400': selectedReg.status === 'Disapproved',
                                              'text-gray-400': selectedReg.status === 'Cancelled'
                                          }"></span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs uppercase text-brand-light tracking-widest mb-1">Date</span>
                                    <p class="text-sm text-brand-white" x-text="selectedReg.registrationDate"></p>
                                    <p class="text-xs text-brand-light/50" x-text="selectedReg.registrationTime"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- AMEND MODAL --}}
        <div x-show="amendModalOpen" style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div x-show="amendModalOpen" class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="amendModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="amendModalOpen" 
                     class="bg-[#2a2e4b] rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-brand-white/10 relative">
                    
                    <h3 class="text-2xl font-bold text-brand-white mb-2">Amend Registration</h3>
                    <p class="text-brand-light mb-6">Manually override the status for this registration.</p>

                    <template x-if="selectedReg">
                        <form action="{{ route('admin.registrations.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="matricNum" :value="selectedReg.matricNum">
                            <input type="hidden" name="courseCode" :value="selectedReg.courseCode">
                            <input type="hidden" name="action" value="amend">

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-brand-light mb-2">New Status</label>
                                <select name="new_status" class="w-full bg-brand-white/10 border border-brand-white/20 text-brand-white rounded-xl px-4 py-3 focus:ring-brand-medium outline-none">
                                    <option value="Approved" class="text-brand-dark bg-brand-white">Approved</option>
                                    <option value="Waiting for Approval" class="text-brand-dark bg-brand-white">Waiting for Approval</option>
                                    <option value="Pending" class="text-brand-dark bg-brand-white">Pending</option>
                                    <option value="Disapproved" class="text-brand-dark bg-brand-white">Disapproved</option>
                                    <option value="Cancelled" class="text-brand-dark bg-brand-white">Cancelled</option>
                                </select>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" @click="amendModalOpen = false" class="px-6 py-2 rounded-xl border border-brand-white/10 text-brand-light hover:bg-brand-white/10">
                                    Cancel
                                </button>
                                <button type="submit" class="px-6 py-2 rounded-xl bg-yellow-500 text-black font-bold hover:bg-yellow-400">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>