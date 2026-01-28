<x-app-layout title="Profile">
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="animate-fade-in-up text-center">
                <h2 class="text-4xl font-extrabold text-brand-white">
                    {{ __('Student Profile') }}
                </h2>
                <p class="text-brand-light text-lg mt-2">
                    Manage your personal information and account security.
                </p>
            </div>

            <div class="space-y-8 animate-fade-in-up delay-100">
                
                <div class="p-10 bg-brand-white/10 backdrop-blur-lg rounded-[2.5rem] shadow-xl border border-brand-medium/20">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-10 bg-brand-white/10 backdrop-blur-lg rounded-[2.5rem] shadow-xl border border-brand-medium/20">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>