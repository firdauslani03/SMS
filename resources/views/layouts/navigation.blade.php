<nav x-data="{ open: false }" class="fixed w-full z-50 top-0 bg-[#2a2e4b]/95 backdrop-blur-md border-b border-brand-white/10 shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group p-3 rounded-2xl bg-brand-white/10 border border-brand-white/5 hover:bg-brand-light hover:text-brand-dark hover:scale-105 transition-all duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-brand-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
            </div>

            <div class="hidden sm:flex items-center">
                <a href="{{ route('course.registration') }}" class="px-8 py-3 rounded-2xl bg-brand-light text-brand-dark font-bold shadow-[0_0_15px_rgba(220,214,247,0.3)] hover:bg-brand-white hover:text-brand-dark hover:shadow-[0_0_25px_rgba(244,238,255,0.6)] transition-all duration-300 ease-out transform hover:-translate-y-1 tracking-wide border border-transparent">
                    Register Course
                </a>
            </div>

            <div class="hidden sm:flex items-center space-x-6">
                
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group">
                    <div class="h-12 w-12 rounded-2xl bg-brand-white/10 border border-brand-white/5 flex items-center justify-center group-hover:bg-brand-light group-hover:scale-105 transition-all duration-300 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-brand-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-brand-white group-hover:text-brand-medium transition-colors">{{ Auth::user()->fName }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="h-12 w-12 flex items-center justify-center rounded-2xl bg-brand-white/10 border border-brand-white/5 hover:bg-red-400 hover:text-white hover:scale-105 transition-all duration-300 shadow-md group" title="Log Out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-2xl text-brand-light hover:text-brand-dark hover:bg-brand-light focus:outline-none transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#2a2e4b] border-b border-brand-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-brand-light hover:text-brand-white hover:bg-brand-white/10">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            <a href="{{ route('course.registration') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-brand-dark bg-brand-light hover:bg-brand-white transition duration-150 ease-in-out">
                Register Course
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-brand-white/10">
            <div class="px-4">
                <div class="font-bold text-base text-brand-white">{{ Auth::user()->fName }} {{ Auth::user()->lName }}</div>
                <div class="font-medium text-sm text-brand-medium">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-brand-light hover:text-brand-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-400 hover:text-red-300">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>