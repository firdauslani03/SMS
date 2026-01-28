<x-guest-layout title="Login">
    <div class="min-h-screen flex flex-col items-center justify-center bg-brand-dark py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-500">
        
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center justify-center p-6 bg-brand-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-brand-medium/20">
                <img src="{{ asset('images/smslogo.png') }}" alt="SMS LOGO" class="w-56 h-auto drop-shadow-lg">
            </div>
        </div>

        <div class="max-w-xl w-full space-y-6 bg-brand-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-brand-medium/20 animate-fade-in-up delay-100">
            
            <div class="text-center mb-6">
                <h2 class="mt-2 text-4xl font-extrabold text-brand-white tracking-tight">
                    Welcome Back!
                </h2>
                <p class="mt-2 text-lg text-brand-light">
                    Please sign in to access your dashboard.
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
                @csrf

                <div class="space-y-5">
                    <div class="group">
                        <label for="email" class="block text-base font-bold text-brand-light mb-2 transition-colors group-focus-within:text-brand-white">Email Address</label>
                        <input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"
                            class="appearance-none block w-full px-5 py-3 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent text-lg bg-brand-white transition-all duration-300 hover:shadow-md">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="group">
                        <label for="password" class="block text-base font-bold text-brand-light mb-2 transition-colors group-focus-within:text-brand-white">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="appearance-none block w-full px-5 py-3 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent text-lg bg-brand-white transition-all duration-300 hover:shadow-md">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-bold rounded-xl text-brand-dark bg-brand-medium hover:bg-brand-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-medium transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="text-center pt-4">
                    <p class="text-base text-brand-light">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-bold text-brand-medium hover:text-brand-white hover:underline transition-colors duration-200">
                            Register here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>