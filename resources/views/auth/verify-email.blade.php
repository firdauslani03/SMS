<x-guest-layout title="Verify Email">
    <div class="min-h-screen flex flex-col items-center justify-center bg-brand-dark py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-500">
        
        <div class="mb-10 animate-fade-in-up">
            <a href="/" class="flex items-center justify-center p-6 bg-brand-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-brand-medium/20 hover:bg-brand-white/15 transition-all duration-300 transform hover:scale-105 hover:shadow-brand-medium/30">
                <img src="{{ asset('images/smslogo.png') }}" alt="SMS LOGO" class="w-64 h-auto drop-shadow-lg">
            </a>
        </div>

        <div class="max-w-md w-full space-y-8 bg-brand-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-brand-medium/20 animate-fade-in-up delay-100">
            
            <div class="text-center">
                <h2 class="mt-2 text-2xl font-extrabold text-brand-white tracking-tight">
                    Verify Your Email
                </h2>
                <div class="mt-4 text-sm text-brand-light">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-400 text-center">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-8 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-brand-medium hover:text-brand-white hover:underline transition-colors duration-200">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-brand-light hover:text-red-400 underline transition-colors duration-200">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>