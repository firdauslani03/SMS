<x-admin-layout title="Course Management">
    <div class="animate-fade-in-up space-y-6">
        
        <div class="flex flex-col md:flex-row justify-between items-end gap-4 pb-6 border-b border-brand-white/10">
            <div>
                <h1 class="text-3xl font-extrabold text-brand-white tracking-tight">Course Management</h1>
                <p class="text-brand-light mt-1 text-lg">Manage curriculum and course details.</p>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="px-5 py-2.5 rounded-xl bg-brand-medium text-brand-dark font-bold hover:bg-brand-light transition-colors shadow-lg shadow-brand-medium/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Course
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#2a2e4b] border border-brand-white/10 rounded-[2rem] shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand-white/5 border-b border-brand-white/10 text-brand-light/60 text-xs uppercase tracking-wider">
                            <th class="p-6 font-bold">Course Info</th>
                            <th class="p-6 font-bold">Credits</th>
                            <th class="p-6 font-bold">Location</th>
                            <th class="p-6 font-bold">Lecturer</th>
                            <th class="p-6 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-white/5">
                        @foreach($courses as $course)
                        <tr class="group hover:bg-brand-white/5 transition-colors">
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-lg font-bold text-brand-white group-hover:text-brand-medium transition-colors">{{ $course->courseCode }}</span>
                                    <span class="text-sm text-brand-light/80">{{ $course->courseName }}</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-lg bg-brand-white/5 text-brand-light text-sm font-mono border border-brand-white/10">
                                    {{ $course->courseCreds }} CR
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="text-sm text-brand-light">
                                    <p class="font-bold">{{ $course->courseLocBuilding }} - {{ $course->courseLocRoom }}</p>
                                    <p class="opacity-60 text-xs">{{ $course->courseDate }} • {{ $course->courseTime }}</p>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-brand-medium/20 text-brand-medium flex items-center justify-center text-xs font-bold">
                                        {{ substr($course->lecturer->fName ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-brand-light font-medium">{{ $course->lecturer->fName ?? 'Unassigned' }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    <a href="{{ route('admin.courses.show', $course->courseCode) }}" class="p-2 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500 hover:text-white transition-all duration-200" title="View Info">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a href="{{ route('admin.courses.edit', $course->courseCode) }}" class="p-2 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500 hover:text-white transition-all duration-200" title="Modify Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.courses.destroy', $course->courseCode) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all duration-200" title="Delete Course">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 border-t border-brand-white/10 bg-brand-white/5">
                {{ $courses->links('pagination.sms') }}
            </div>
        </div>
    </div>
</x-admin-layout>