<x-lecturer-layout title="My Courses">
    {{-- Initialize Alpine Data --}}
    <div x-data="{ showModal: false, selectedCourse: null, activeTab: 'details' }">
        
        {{-- ANIMATION WRAPPER --}}
        <div class="animate-fade-in-up">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                        My Courses
                    </h1>
                    <p class="text-brand-light mt-2 text-xl font-medium">
                        You are currently teaching <span class="text-brand-medium font-bold">{{ $courses->count() }}</span> courses.
                    </p>
                </div>
            
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                @forelse($courses as $course)
                    <div class="group relative flex flex-col justify-between p-8 rounded-[2.5rem] transition-all duration-300 shadow-lg backdrop-blur-md min-h-[340px] border
                                bg-brand-white/5 border-brand-white/10 text-brand-white
                                hover:bg-brand-light hover:text-brand-dark hover:border-transparent hover:shadow-[0_0_30px_rgba(220,214,247,0.6)] hover:-translate-y-2">
                        
                        <div>
                            <div class="flex items-start justify-between mb-8">
                                <div class="h-16 w-16 rounded-2xl flex items-center justify-center shadow-inner transition-colors duration-300
                                            bg-brand-medium/20 text-brand-medium
                                            group-hover:bg-brand-dark group-hover:text-brand-white">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="px-4 py-1.5 rounded-full text-sm font-extrabold tracking-wider border transition-colors duration-300
                                            bg-brand-white/10 text-brand-medium border-brand-white/10
                                            group-hover:bg-brand-dark/10 group-hover:text-brand-dark group-hover:border-brand-dark/20">
                                    {{ $course->courseCode }}
                                </span>
                            </div>

                            <h3 class="text-3xl font-extrabold mb-3 leading-tight transition-colors duration-300">
                                {{ $course->courseName }}
                            </h3>
                            
                            <div class="flex items-center gap-2 text-lg font-bold mb-8 transition-colors duration-300
                                            text-brand-light/80
                                            group-hover:text-brand-dark/70">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $course->courseCreds }} Credits
                            </div>
                        </div>

                        <div class="pt-6 border-t transition-colors duration-300
                                    border-brand-white/10
                                    group-hover:border-brand-dark/10">
                            
                            {{-- Note: We use $course->load('students') to ensure the students relationship is loaded in the JSON --}}
                            <button 
                                @click="selectedCourse = {{ json_encode($course->load('students')) }}; showModal = true; activeTab = 'details'"
                                class="w-full flex items-center justify-between text-lg font-bold transition-colors duration-300
                                    text-brand-light group-hover:text-brand-dark text-left focus:outline-none">
                                <span>View Details</span>
                                <div class="h-10 w-10 rounded-full flex items-center justify-center transition-all duration-300
                                            bg-brand-white/10 group-hover:bg-brand-dark group-hover:text-brand-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center rounded-[2.5rem] bg-brand-white/5 border border-brand-white/10 border-dashed animate-pulse">
                        <div class="h-24 w-24 mx-auto rounded-full bg-brand-dark/50 flex items-center justify-center mb-6 text-brand-light/50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-3xl font-bold text-brand-white mb-3">No Courses Found</h3>
                        <p class="text-brand-light/60 text-xl">You have not been assigned any courses yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- MODAL --}}
        <div x-show="showModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
                 @click="showModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform rounded-[2rem] bg-[#2a2e4b] border border-brand-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl overflow-hidden flex flex-col h-[85vh] max-h-[90vh]">
                    
                    {{-- Modal Header & Body --}}
                    <div class="p-8 md:p-10 overflow-y-auto flex-1 custom-scrollbar" x-if="selectedCourse">
                        
                        {{-- Header Section --}}
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-6 pb-6 border-b border-brand-white/10">
                            <div class="flex flex-col md:flex-row items-start gap-5 w-full">
                                {{-- Code Tag --}}
                                <div class="w-fit px-6 py-3 rounded-2xl bg-brand-medium text-brand-dark shadow-lg shrink-0">
                                    <span class="text-xl font-black tracking-wide" x-text="selectedCourse.courseCode"></span>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-brand-white leading-tight" x-text="selectedCourse.courseName"></h3>
                                    <span class="inline-block mt-2 px-3 py-1 rounded-lg bg-brand-white/10 text-brand-light font-bold text-sm tracking-wide shadow-sm">
                                        <span x-text="selectedCourse.courseCreds"></span> Credits
                                    </span>
                                </div>
                            </div>

                            <button @click="showModal = false" class="absolute top-6 right-6 md:static text-brand-light/50 hover:text-brand-white transition-colors bg-brand-white/5 rounded-full p-2 hover:bg-brand-white/10">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Toggle --}}
                        <div class="flex justify-center mb-8">
                            <div class="bg-black/20 p-1.5 rounded-full flex gap-1 shadow-inner border border-brand-white/5">
                                <button @click="activeTab = 'details'" 
                                        :class="activeTab === 'details' ? 'bg-brand-medium text-brand-dark shadow-md' : 'text-brand-light/60 hover:text-brand-white hover:bg-brand-white/5'"
                                        class="px-6 py-2 rounded-full font-bold transition-all duration-300 text-sm tracking-wide">
                                    Course Details
                                </button>
                                <button @click="activeTab = 'students'" 
                                        :class="activeTab === 'students' ? 'bg-brand-medium text-brand-dark shadow-md' : 'text-brand-light/60 hover:text-brand-white hover:bg-brand-white/5'"
                                        class="px-6 py-2 rounded-full font-bold transition-all duration-300 text-sm tracking-wide flex items-center gap-2">
                                    Enrolled Students
                                    <span class="px-1.5 py-0.5 rounded-md bg-black/20 text-xs font-black opacity-70" x-text="selectedCourse.students ? selectedCourse.students.length : 0"></span>
                                </button>
                            </div>
                        </div>

                        {{-- DETAILS TAB --}}
                        <div x-show="activeTab === 'details'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-6">
                            
                            <div class="bg-[#4b4f74] p-6 rounded-3xl border border-brand-white/10 shadow-lg">
                                <h4 class="text-brand-light/60 text-xs font-bold uppercase tracking-widest mb-2">Course Description</h4>
                                <p class="text-brand-white text-lg leading-relaxed font-medium" x-text="selectedCourse.courseDesc || 'No description provided.'"></p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="bg-[#4b4f74] p-5 rounded-3xl border border-brand-white/10 shadow-lg">
                                    <h4 class="text-brand-light/60 text-xs font-bold uppercase tracking-widest mb-2">Location</h4>
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="text-brand-white text-lg font-bold">
                                            <span x-text="selectedCourse.courseLocBuilding"></span> - <span x-text="selectedCourse.courseLocRoom"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="bg-[#4b4f74] p-5 rounded-3xl border border-brand-white/10 shadow-lg">
                                    <h4 class="text-brand-light/60 text-xs font-bold uppercase tracking-widest mb-2">Schedule</h4>
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-brand-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-brand-white text-lg font-bold">
                                            <span x-text="selectedCourse.courseDate"></span> @ <span x-text="selectedCourse.courseTime"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div class="bg-[#4b4f74] p-4 rounded-3xl border border-brand-white/10 text-center shadow-lg">
                                    <h4 class="text-brand-light/60 text-[10px] font-bold uppercase tracking-widest mb-1">Capacity</h4>
                                    <p class="text-brand-white text-xl font-black" x-text="selectedCourse.courseCapacity"></p>
                                </div>
                                <div class="bg-[#4b4f74] p-4 rounded-3xl border border-brand-white/10 text-center shadow-lg">
                                    <h4 class="text-brand-light/60 text-[10px] font-bold uppercase tracking-widest mb-1">Semester</h4>
                                    <p class="text-brand-white text-xl font-black" x-text="selectedCourse.courseSem"></p>
                                </div>
                                <div class="bg-[#4b4f74] p-4 rounded-3xl border border-brand-white/10 text-center shadow-lg">
                                    <h4 class="text-brand-light/60 text-[10px] font-bold uppercase tracking-widest mb-1">Prerequisite</h4>
                                    <p class="text-brand-white text-base font-bold break-words leading-tight" x-text="selectedCourse.coursePreReq || '-'"></p>
                                </div>
                            </div>
                        </div>

                        {{-- STUDENTS TAB --}}
                        <div x-show="activeTab === 'students'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-4">
                            
                             <template x-if="selectedCourse.students && selectedCourse.students.length > 0">
                                 <div class="flex flex-col space-y-4">
                                     <template x-for="student in selectedCourse.students" :key="student.matricNum">
                                         <div class="bg-[#4b4f74] p-6 rounded-2xl border border-brand-white/10 hover:border-brand-medium/50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4 group shadow-md">
                                             
                                             <div class="flex items-center gap-6">
                                                 <div class="h-16 w-16 rounded-full bg-brand-medium text-brand-dark flex items-center justify-center font-bold text-2xl shadow-inner shrink-0">
                                                     <span x-text="student.fName ? student.fName.charAt(0) : 'S'"></span>
                                                 </div>
                                                 
                                                 <div class="overflow-hidden">
                                                     <p class="text-brand-white font-bold text-2xl truncate group-hover:text-brand-medium transition-colors" x-text="student.fName + (student.lName ? ' ' + student.lName : '')"></p>
                                                     <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-brand-light/70 text-base font-bold mt-1">
                                                         <span class="uppercase tracking-wider" x-text="student.matricNum"></span>
                                                         <span class="hidden sm:inline text-brand-white/20">|</span>
                                                         <span class="text-brand-light/50 font-normal lowercase" x-text="student.email"></span>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="hidden sm:block text-right">
                                                 <span class="text-brand-white/20 font-bold text-lg" x-text="student.progCode"></span>
                                             </div>
                                         </div>
                                     </template>
                                 </div>
                             </template>

                             <template x-if="!selectedCourse.students || selectedCourse.students.length === 0">
                                 <div class="text-center py-12 rounded-3xl bg-black/10 border border-brand-white/5 border-dashed">
                                     <div class="h-16 w-16 mx-auto rounded-full bg-brand-white/5 flex items-center justify-center mb-3 text-brand-light/30">
                                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                     </div>
                                     <p class="text-brand-light/50 font-bold">No students registered yet.</p>
                                 </div>
                             </template>
                        </div>

                    </div>

                    <div class="bg-black/20 px-8 py-5 flex justify-end rounded-b-[2rem] border-t border-brand-white/5 shrink-0">
                        <button type="button" 
                                class="inline-flex w-full justify-center rounded-xl bg-brand-white/10 border border-brand-white/10 px-6 py-3 text-base font-bold text-brand-white shadow-lg hover:bg-brand-medium hover:text-brand-dark hover:scale-105 transition-all duration-200 sm:w-auto" 
                                @click="showModal = false">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-lecturer-layout>