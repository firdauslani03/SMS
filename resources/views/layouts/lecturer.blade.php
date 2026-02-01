<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title', 'Lecturer Portal') }}</title>

        <link rel="icon" href="{{ asset('images/smslogo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-brand-dark text-brand-light">
        
        <div class="min-h-screen flex bg-brand-dark" x-data="{ sidebarOpen: false }">
            
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"
                 x-transition.opacity>
            </div>

            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-[#2a2e4b] border-r border-brand-white/10 transition-transform duration-300 lg:static lg:translate-x-0 shadow-2xl flex flex-col">
                
                <div class="h-24 flex items-center justify-center border-b border-brand-white/10">
                    <a href="{{ route('lecturer.dashboard') }}" class="flex items-center gap-3 group">
                         <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-brand-medium to-brand-light flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-brand-dark font-black text-xl">L</span>
                         </div>
                         <span class="text-xl font-bold text-brand-white tracking-wide">Portal</span>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-medium hover:bg-brand-white/10 hover:text-brand-white transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="font-semibold">My Courses</span>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-medium hover:bg-brand-white/10 hover:text-brand-white transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-semibold">Student Lists</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('profile.edit') ? 'bg-brand-medium text-brand-dark shadow-lg' : 'text-brand-medium hover:bg-brand-white/10 hover:text-brand-white' }} transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-semibold">Manage Profile</span>
                    </a>

                </nav>

                <div class="p-4 border-t border-brand-white/10 bg-black/10">
                    <div class="flex items-center gap-3 mb-4 px-2">
                        <div class="h-10 w-10 rounded-full bg-brand-light text-brand-dark flex items-center justify-center font-bold text-lg">
                            {{ substr(Auth::guard('lecturer')->user()->fName ?? 'L', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-brand-white truncate">{{ Auth::guard('lecturer')->user()->fName ?? 'Lecturer' }}</p>
                            <p class="text-xs text-brand-medium truncate">{{ Auth::guard('lecturer')->user()->email ?? '' }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all duration-200 text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </aside>

            <main class="flex-1 flex flex-col h-screen overflow-hidden">
                
                <header class="h-16 flex items-center justify-between px-4 bg-[#2a2e4b] border-b border-brand-white/10 lg:hidden shrink-0">
                    <span class="text-lg font-bold text-brand-white">Lecturer Dashboard</span>
                    <button @click="sidebarOpen = true" class="p-2 text-brand-light hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </header>

                <div class="flex-1 overflow-y-auto p-6 lg:p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>