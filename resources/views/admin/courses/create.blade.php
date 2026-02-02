<x-admin-layout title="Add Course">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-brand-white">Add New Course</h1>
                <p class="text-brand-light mt-1 text-lg">Create a new course offering.</p>
            </div>
            <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 rounded-xl border border-brand-white/10 text-brand-light hover:bg-brand-white hover:text-brand-dark transition-all font-bold text-base">
                Back to List
            </a>
        </div>

        <div class="bg-[#2a2e4b] border border-brand-white/10 rounded-2xl p-10 shadow-xl">
            <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Course Code --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Course Code</label>
                        <input type="text" name="courseCode" value="{{ old('courseCode') }}" 
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none transition-all uppercase placeholder-brand-light/30"
                               placeholder="e.g. SECJ1013">
                        @error('courseCode') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Course Name --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Course Name</label>
                        <input type="text" name="courseName" value="{{ old('courseName') }}" 
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none transition-all placeholder-brand-light/30"
                               placeholder="e.g. Programming Technique I">
                        @error('courseName') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Programme --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Programme</label>
                        <select name="progCode" class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none appearance-none cursor-pointer">
                            <option value="" class="text-brand-dark bg-brand-white">Select Programme</option>
                            @foreach($programmes as $prog)
                                <option value="{{ $prog->progCode }}" class="text-brand-dark bg-brand-white" {{ old('progCode') == $prog->progCode ? 'selected' : '' }}>
                                    {{ $prog->progCode }} - {{ $prog->progName }}
                                </option>
                            @endforeach
                        </select>
                        @error('progCode') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Lecturer --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Lecturer</label>
                        <select name="staffNum" class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none appearance-none cursor-pointer">
                            <option value="" class="text-brand-dark bg-brand-white">Select Lecturer</option>
                            @foreach($lecturers as $lec)
                                <option value="{{ $lec->staffNum }}" class="text-brand-dark bg-brand-white" {{ old('staffNum') == $lec->staffNum ? 'selected' : '' }}>
                                    {{ $lec->fName }} {{ $lec->lName }}
                                </option>
                            @endforeach
                        </select>
                        @error('staffNum') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Credits --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Credit Hours</label>
                        <input type="number" name="courseCreds" value="{{ old('courseCreds', 3) }}" min="1" max="10"
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none">
                        @error('courseCreds') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Capacity --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Capacity</label>
                        <input type="number" name="courseCapacity" value="{{ old('courseCapacity', 30) }}" min="1"
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none">
                        @error('courseCapacity') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Semester (Dropdown) --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Semester</label>
                        <select name="courseSem" class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none appearance-none cursor-pointer">
                            <option value="" class="text-brand-dark bg-brand-white">Select Semester</option>
                            <option value="1" class="text-brand-dark bg-brand-white" {{ old('courseSem') == '1' ? 'selected' : '' }}>Semester 1</option>
                            <option value="2" class="text-brand-dark bg-brand-white" {{ old('courseSem') == '2' ? 'selected' : '' }}>Semester 2</option>
                            <option value="3" class="text-brand-dark bg-brand-white" {{ old('courseSem') == '3' ? 'selected' : '' }}>Semester 3</option>
                        </select>
                        @error('courseSem') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Building (Dropdown) --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Location (Building)</label>
                        <select name="courseLocBuilding" class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none appearance-none cursor-pointer">
                            <option value="" class="text-brand-dark bg-brand-white">Select Building</option>
                            <optgroup label="Faculty of Computing (FC)" class="text-brand-dark bg-brand-light">
                                <option value="N28" class="text-brand-dark bg-brand-white" {{ old('courseLocBuilding') == 'N28' ? 'selected' : '' }}>N28</option>
                                <option value="N28A" class="text-brand-dark bg-brand-white" {{ old('courseLocBuilding') == 'N28A' ? 'selected' : '' }}>N28A</option>
                            </optgroup>
                            <optgroup label="Faculty of Science (FS)" class="text-brand-dark bg-brand-light">
                                <option value="C05" class="text-brand-dark bg-brand-white" {{ old('courseLocBuilding') == 'C05' ? 'selected' : '' }}>C05</option>
                                <option value="C06" class="text-brand-dark bg-brand-white" {{ old('courseLocBuilding') == 'C06' ? 'selected' : '' }}>C06</option>
                            </optgroup>
                        </select>
                        @error('courseLocBuilding') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Room --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Location (Room)</label>
                        <input type="text" name="courseLocRoom" value="{{ old('courseLocRoom') }}" 
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none placeholder-brand-light/30"
                               placeholder="e.g. BK1">
                        @error('courseLocRoom') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Day --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Day</label>
                        <select name="courseDate" class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none appearance-none cursor-pointer">
                            <option value="" class="text-brand-dark bg-brand-white">Select Day</option>
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'] as $day)
                                <option value="{{ $day }}" class="text-brand-dark bg-brand-white" {{ old('courseDate') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('courseDate') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Time Start --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">Start Time</label>
                        <input type="time" name="courseTimeStart" value="{{ old('courseTimeStart') }}" 
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none [color-scheme:dark]">
                        @error('courseTimeStart') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Time End --}}
                    <div>
                        <label class="block text-base font-bold text-brand-light mb-3">End Time</label>
                        <input type="time" name="courseTimeEnd" value="{{ old('courseTimeEnd') }}" 
                               class="w-full bg-brand-white/5 border border-brand-white/10 rounded-xl px-5 py-4 text-brand-white text-lg focus:ring-2 focus:ring-brand-medium outline-none [color-scheme:dark]">
                        @error('courseTimeEnd') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-8 border-t border-brand-white/10">
                    <button type="submit" class="px-10 py-4 rounded-xl bg-brand-medium text-brand-dark font-extrabold text-lg hover:bg-brand-white hover:scale-105 transition-all shadow-lg">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>