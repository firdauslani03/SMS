<x-guest-layout title="Confirm Password">
    <div class="min-h-screen flex flex-col items-center justify-center bg-brand-dark py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-500">
        
        <div class="mb-10 animate-fade-in-up">
            <a href="/" class="flex items-center justify-center p-6 bg-brand-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-brand-medium/20 hover:bg-brand-white/15 transition-all duration-300 transform hover:scale-105 hover:shadow-brand-medium/30">
                <img src="{{ asset('images/smslogo.png') }}" alt="SMS LOGO" class="w-64 h-auto drop-shadow-lg">
            </a>
        </div>

        <div class="max-w-md w-full space-y-8 bg-brand-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-brand-medium/20 animate-fade-in-up delay-100">
            
            <div class="text-center">
                <h2 class="mt-2 text-2xl font-extrabold text-brand-white tracking-tight">
                    Secure Area
                </h2>
                <p class="mt-2 text-sm text-brand-light">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-6">
                @csrf

                <div class="group">
                    <label for="password" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="appearance-none block w-full px-3 py-2 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-brand-dark bg-brand-medium hover:bg-brand-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-medium transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>