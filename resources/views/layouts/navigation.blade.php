<nav x-data="{ open: false }" class="fixed w-full z-50 top-0 bg-[#2a2e4b]/95 backdrop-blur-md border-b border-brand-white/10 shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            
            <div class="flex items-center">
                <a href="{{ Auth::guard('lecturer')->check() ? route('lecturer.dashboard') : route('dashboard') }}" class="group p-3 rounded-2xl bg-brand-white/10 border border-brand-white/5 hover:bg-brand-light hover:text-brand-dark hover:scale-105 transition-all duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-brand-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
            </div>

            @if(!Auth::guard('lecturer')->check())
                <div class="hidden sm:flex items-center">
                    <a href="{{ route('course.registration') }}" class="px-8 py-3 rounded-2xl bg-brand-light text-brand-dark font-bold shadow-[0_0_15px_rgba(220,214,247,0.3)] hover:bg-brand-white hover:text-brand-dark hover:shadow-[0_0_25px_rgba(244,238,255,0.6)] transition-all duration-300 ease-out transform hover:-translate-y-1 tracking-wide border border-transparent">
                        Register Course
                    </a>
                </div>
            @endif

            <div class="hidden sm:flex items-center space-x-6">
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 rounded-2xl bg-brand-white/10 border border-brand-white/5 hover:bg-brand-light hover:text-brand-dark transition-all duration-300 shadow-md group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-brand-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        
                        @if(Auth::user()?->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                
                    <div x-show="open" 
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-80 bg-[#2a2e4b] border border-brand-white/10 rounded-xl shadow-xl overflow-hidden z-50 py-2">
                        
                        <div class="px-4 py-2 border-b border-brand-white/10 text-brand-light font-bold text-sm">
                            Notifications
                        </div>
                
                        <div class="max-h-64 overflow-y-auto">
                            @forelse(Auth::user()->notifications->take(5) as $notification)
                                <div x-data="{ read: {{ $notification->read_at ? 'true' : 'false' }} }" 
                                    @mouseenter="
                                        if (!read) {
                                            fetch('{{ route('notifications.mark', $notification->id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json'
                                                }
                                            }).then(() => {
                                                read = true; 
                                            });
                                        }
                                    "
                                    class="px-4 py-3 border-b border-brand-white/5 hover:bg-brand-white/5 transition-colors cursor-pointer relative group">
                                    
                                    <p class="text-sm text-brand-white font-medium transition-opacity duration-300" 
                                       :class="{ 'opacity-100': !read, 'opacity-70': read }">
                                       {{ $notification->data['message'] }}
                                    </p>
                                    
                                    <span class="text-xs text-brand-medium block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                                    
                                    <span x-show="!read" x-transition.opacity.duration.500ms class="absolute right-2 top-4 w-2 h-2 bg-blue-500 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                                </div>
                            @empty
                                <div class="px-4 py-3 text-sm text-brand-medium text-center">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if(!Auth::guard('lecturer')->check())
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group">
                    <div class="h-12 w-12 rounded-2xl bg-brand-white/10 border border-brand-white/5 flex items-center justify-center group-hover:bg-brand-light group-hover:scale-105 transition-all duration-300 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-light group-hover:text-brand-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-brand-white group-hover:text-brand-medium transition-colors">{{ (Auth::user() ?? Auth::guard('lecturer')->user())->fName }}</span>
                </a>
                @endif

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
            <x-responsive-nav-link :href="Auth::guard('lecturer')->check() ? route('lecturer.dashboard') : route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('lecturer.dashboard')" class="text-brand-light hover:text-brand-white hover:bg-brand-white/10">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            @if(!Auth::guard('lecturer')->check())
            <a href="{{ route('course.registration') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-brand-dark bg-brand-light hover:bg-brand-white transition duration-150 ease-in-out">
                Register Course
            </a>
            @endif
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

                @if(Auth::user()->notifications->count() > 0)
                <div class="border-t border-brand-white/10 mt-2 pt-2">
                    <div class="px-4 text-xs font-bold text-brand-medium uppercase tracking-wider mb-2">Recent Notifications</div>
                    @foreach(Auth::user()?->notifications?->take(3) ?? [] as $notification)
                        <div x-data="{ read: {{ $notification->read_at ? 'true' : 'false' }} }"
                             @click="if(!read) { 
                                fetch('{{ route('notifications.mark', $notification->id) }}', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                }).then(() => read = true)
                             }"
                             class="flex items-start pl-3 pr-4 py-2 text-sm hover:bg-brand-white/5 cursor-pointer transition-colors"
                             :class="{ 'text-brand-white font-bold': !read, 'text-brand-light font-normal': read }">
                             
                             <span x-show="!read" class="mt-1.5 mr-2 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>
                             <span x-show="read" class="mr-4"></span> <span>{{ $notification->data['message'] }}</span>
                        </div>
                    @endforeach
                </div>
                @endif

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