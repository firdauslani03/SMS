<x-lecturer-layout title="Lecturer Dashboard">
    <div class="animate-fade-in-up">
        
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-brand-white tracking-tight drop-shadow-md">
                Welcome back, <span class="text-brand-medium">{{ Auth::guard('lecturer')->user()->fName }}</span>
            </h1>
            <p class="text-brand-light mt-2 text-lg">Manage your courses and students efficiently.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="p-6 rounded-[2rem] bg-brand-white/10 border border-brand-white/20 shadow-xl backdrop-blur-md hover:scale-[1.02] transition-transform duration-300">
                <div class="h-12 w-12 rounded-full bg-brand-medium/20 flex items-center justify-center mb-4 text-brand-medium">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-white mb-2">My Courses</h3>
                <p class="text-brand-light/70 text-sm mb-4">View and manage the courses you are currently teaching.</p>
                <a href="#" class="inline-flex items-center text-sm font-bold text-brand-medium hover:text-brand-white">
                    Access Courses &rarr;
                </a>
            </div>

            <div class="p-6 rounded-[2rem] bg-brand-white/10 border border-brand-white/20 shadow-xl backdrop-blur-md hover:scale-[1.02] transition-transform duration-300">
                <div class="h-12 w-12 rounded-full bg-purple-500/20 flex items-center justify-center mb-4 text-purple-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-white mb-2">Student Lists</h3>
                <p class="text-brand-light/70 text-sm mb-4">Access detailed lists of students enrolled in your subjects.</p>
                <a href="#" class="inline-flex items-center text-sm font-bold text-brand-medium hover:text-brand-white">
                    View Students &rarr;
                </a>
            </div>

        </div>
    </div>
</x-lecturer-layout>