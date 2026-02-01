<x-admin-layout title="Modify Course">
    <div class="animate-fade-in-up max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.courses.index') }}" class="text-brand-medium hover:text-white flex items-center gap-2 mb-4 font-bold text-sm">
                &larr; Cancel & Return
            </a>
            <h1 class="text-3xl font-extrabold text-brand-white">Modify Course: <span class="text-brand-medium">{{ $course->courseCode }}</span></h1>
        </div>

        <div class="bg-[#2a2e4b] border border-brand-white/10 rounded-[2rem] p-8 shadow-2xl">
            <form action="{{ route('admin.courses.update', $course->courseCode) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-brand-light mb-2">Course Name</label>
                        <input type="text" name="courseName" value="{{ old('courseName', $course->courseName) }}" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                        @error('courseName') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Credits</label>
                        <input type="number" name="courseCreds" value="{{ old('courseCreds', $course->courseCreds) }}" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                        @error('courseCreds') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Capacity</label>
                        <input type="number" name="courseCapacity" value="{{ old('courseCapacity', $course->courseCapacity) }}" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                        @error('courseCapacity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Building</label>
                        <select name="courseLocBuilding" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                            <option value="N28" {{ old('courseLocBuilding', $course->courseLocBuilding) == 'N28' ? 'selected' : '' }}>N28</option>
                            <option value="N28A" {{ old('courseLocBuilding', $course->courseLocBuilding) == 'N28A' ? 'selected' : '' }}>N28A</option>
                        </select>
                        @error('courseLocBuilding') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Room</label>
                        <input type="text" name="courseLocRoom" value="{{ old('courseLocRoom', $course->courseLocRoom) }}" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                        @error('courseLocRoom') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Day</label>
                        <select name="courseDate" class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ old('courseDate', $course->courseDate) == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('courseDate') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-light mb-2">Time Duration</label>
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <input type="time" name="courseTimeStart" 
                                       value="{{ old('courseTimeStart', $startTime) }}" 
                                       class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent text-center"
                                       title="Start Time">
                            </div>
                            <span class="text-brand-light font-bold">-</span>
                            <div class="flex-1">
                                <input type="time" name="courseTimeEnd" 
                                       value="{{ old('courseTimeEnd', $endTime) }}" 
                                       class="w-full bg-brand-dark border border-brand-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent text-center"
                                       title="End Time">
                            </div>
                        </div>
                        @error('courseTimeStart') <p class="text-red-400 text-xs mt-1">Start: {{ $message }}</p> @enderror
                        @error('courseTimeEnd') <p class="text-red-400 text-xs mt-1">End: {{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-brand-light mb-2">Lecturer Staff No.</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-brand-light/50 font-bold">#</span>
                            </div>
                            <input type="text" 
                                   name="staffNum" 
                                   value="{{ old('staffNum', $course->staffNum) }}" 
                                   placeholder="Enter Staff ID (e.g. 10234)" 
                                   class="w-full bg-brand-dark border border-brand-white/20 rounded-xl pl-8 pr-4 py-3 text-white focus:ring-2 focus:ring-brand-medium focus:border-transparent placeholder-brand-light/30">
                        </div>
                        <p class="text-xs text-brand-light/50 mt-1">System will verify if this staff ID exists upon saving.</p>
                        @error('staffNum') 
                            <p class="text-red-400 text-sm mt-1 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <input type="hidden" name="courseSem" value="{{ $course->courseSem }}">
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="px-8 py-3 rounded-xl bg-brand-medium text-brand-dark font-bold hover:bg-brand-light transition-colors shadow-lg shadow-brand-medium/20">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>