<section>
    <header class="mb-8 border-b border-brand-white/10 pb-6">
        <h2 class="text-3xl font-extrabold text-brand-white">
            {{ __('Student Information') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div>
            <h3 class="text-xl font-bold text-brand-medium mb-4 uppercase tracking-wider flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                Personal Details
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                    <label for="fName" class="block text-sm font-bold text-brand-light mb-2">First Name</label>
                    <input id="fName" name="fName" type="text" value="{{ old('fName', $user->fName) }}" required
                        class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium">
                    <x-input-error class="mt-2" :messages="$errors->get('fName')" />
                </div>

                <div class="group">
                    <label for="lName" class="block text-sm font-bold text-brand-light mb-2">Last Name</label>
                    <input id="lName" name="lName" type="text" value="{{ old('lName', $user->lName) }}" required
                        class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium">
                    <x-input-error class="mt-2" :messages="$errors->get('lName')" />
                </div>

                <div class="group">
                    <label for="ic" class="block text-sm font-bold text-brand-light mb-2">IC Number</label>
                    <input id="ic" name="ic" type="text" value="{{ old('ic', $user->ic) }}" required
                        class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium">
                    <x-input-error class="mt-2" :messages="$errors->get('ic')" />
                </div>

                <div class="group">
                    <label for="email" class="block text-sm font-bold text-brand-light mb-2">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium focus:border-transparent transition-all shadow-sm font-medium">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 text-brand-medium">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline hover:text-brand-white">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-bold text-brand-light mb-2">Phone Number</label>
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <select id="countryCode" name="countryCode" required 
                            class="block w-full px-4 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium text-center font-medium appearance-none">
                            <option value="60" {{ old('countryCode', $user->countryCode) == '60' ? 'selected' : '' }}>🇲🇾 (+60)</option>
                            <option value="65" {{ old('countryCode', $user->countryCode) == '65' ? 'selected' : '' }}>🇸🇬 (+65)</option>
                            <option value="62" {{ old('countryCode', $user->countryCode) == '62' ? 'selected' : '' }}>🇮🇩 (+62)</option>
                            <option value="66" {{ old('countryCode', $user->countryCode) == '66' ? 'selected' : '' }}>🇹🇭 (+66)</option>
                            <option value="84" {{ old('countryCode', $user->countryCode) == '84' ? 'selected' : '' }}>🇻🇳 (+84)</option>
                            <option value="63" {{ old('countryCode', $user->countryCode) == '63' ? 'selected' : '' }}>🇵🇭 (+63)</option>
                            <option value="1"  {{ old('countryCode', $user->countryCode) == '1' ? 'selected' : '' }}>🇺🇸 (+1)</option>
                            <option value="44" {{ old('countryCode', $user->countryCode) == '44' ? 'selected' : '' }}>🇬🇧 (+44)</option>
                            <option value="86" {{ old('countryCode', $user->countryCode) == '86' ? 'selected' : '' }}>🇨🇳 (+86)</option>
                            <option value="81" {{ old('countryCode', $user->countryCode) == '81' ? 'selected' : '' }}>🇯🇵 (+81)</option>
                            <option value="82" {{ old('countryCode', $user->countryCode) == '82' ? 'selected' : '' }}>🇰🇷 (+82)</option>
                            <option value="61" {{ old('countryCode', $user->countryCode) == '61' ? 'selected' : '' }}>🇦🇺 (+61)</option>
                            <option value="91" {{ old('countryCode', $user->countryCode) == '91' ? 'selected' : '' }}>🇮🇳 (+91)</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <select id="phoneOp" name="phoneOp" required 
                            class="block w-full px-4 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium text-center font-medium appearance-none">
                            @foreach(range(11, 19) as $op)
                                <option value="{{ $op }}" {{ old('phoneOp', $user->phoneOp) == $op ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <input id="subNum" name="subNum" type="text" placeholder="3456789" value="{{ old('subNum', $user->subNum) }}" required
                            class="block w-full px-5 py-3 border border-brand-medium/30 bg-brand-white/80 text-brand-dark rounded-xl focus:ring-2 focus:ring-brand-medium font-medium">
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('subNum')" />
            </div>
        </div>

        <div class="border-t border-brand-white/10 my-8"></div>

        <div>
            <h3 class="text-xl font-bold text-brand-medium mb-4 uppercase tracking-wider flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" /></svg>
                Academic Records <span class="text-xs ml-2 bg-brand-dark px-2 py-1 rounded border border-brand-medium/30 text-brand-medium">READ ONLY</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">Matric Number</label>
                    <input type="text" value="{{ $user->matricNum }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-brand-white/70 rounded-xl cursor-not-allowed">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">Program Code</label>
                    <input type="text" value="{{ $user->progCode }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-brand-white/70 rounded-xl cursor-not-allowed">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">Faculty Code</label>
                    <input type="text" value="{{ $user->facCode }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-brand-white/70 rounded-xl cursor-not-allowed">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">Current Year</label>
                    <input type="text" value="{{ $user->year }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-brand-white/70 rounded-xl cursor-not-allowed">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">Current Semester</label>
                    <input type="text" value="{{ $user->semester }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-brand-white/70 rounded-xl cursor-not-allowed">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-brand-medium uppercase mb-1">CGPA</label>
                    <input type="text" value="{{ number_format($user->cgpa, 2) }}" disabled
                        class="block w-full px-5 py-3 border border-brand-white/10 bg-brand-dark/50 text-green-400 font-bold rounded-xl cursor-not-allowed">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-brand-white/10">
            <button type="submit" 
                class="px-8 py-4 bg-brand-medium text-brand-dark font-extrabold text-lg rounded-2xl shadow-lg hover:bg-brand-white hover:scale-105 transition-all duration-300 transform">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-brand-light font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    {{ __('Profile updated successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>