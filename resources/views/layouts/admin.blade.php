<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title', 'Admin Portal') }}</title>

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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                         <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-brand-medium to-brand-light flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                         </div>
                         <span class="text-xl font-bold text-brand-white tracking-wide">Admin</span>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-brand-medium text-brand-dark shadow-lg' : 'text-brand-medium hover:bg-brand-white/10 hover:text-brand-white' }} transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.courses.*') ? 'bg-brand-medium text-brand-dark shadow-lg' : 'text-brand-medium hover:bg-brand-white/10 hover:text-brand-white' }} transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="font-semibold">Course Management</span>
                    </a>

                    <a href="{{ route('admin.registrations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.registrations.*') ? 'bg-brand-medium text-brand-dark shadow-lg' : 'text-brand-medium hover:bg-brand-white/10 hover:text-brand-white' }} transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="font-semibold">Registrations</span>
                    </a>

                </nav>

                <div class="p-4 border-t border-brand-white/10 bg-black/10">
                    <div class="flex items-center gap-3 mb-4 px-2">
                        <div class="h-10 w-10 rounded-full bg-brand-light text-brand-dark flex items-center justify-center font-bold text-lg">
                            {{ substr(Auth::guard('it_staff')->user()->fName ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-brand-white truncate">{{ Auth::guard('it_staff')->user()->fName ?? 'Admin' }}</p>
                            <p class="text-xs text-brand-medium truncate">IT Administrator</p>
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
                    <span class="text-lg font-bold text-brand-white">Admin Dashboard</span>
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