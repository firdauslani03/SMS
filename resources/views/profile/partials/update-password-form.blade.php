<section>
    <header class="mb-8 border-b border-brand-white/10 pb-6">
        <h2 class="text-3xl font-extrabold text-brand-white">
            {{ __('Update Password') }}
        </h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="group">
            <label for="update_password_current_password" class="block text-sm font-bold text-brand-light mb-2">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium hover:shadow-md">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="group">
            <label for="update_password_password" class="block text-sm font-bold text-brand-light mb-2">New Password</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium hover:shadow-md">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="group">
            <label for="update_password_password_confirmation" class="block text-sm font-bold text-brand-light mb-2">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium hover:shadow-md">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-brand-white/10 mt-6">
            <button type="submit" 
                class="px-8 py-4 bg-brand-medium text-brand-dark font-extrabold text-lg rounded-2xl shadow-lg hover:bg-brand-white hover:scale-105 transition-all duration-300 transform">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-brand-light font-medium flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>