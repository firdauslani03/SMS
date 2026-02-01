<x-lecturer-layout title="Manage Profile">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <div class="flex items-center justify-between border-b border-white/10 pb-6">
            <div>
                <h2 class="text-3xl font-bold text-white">Academic Profile</h2>
                <p class="text-gray-400 mt-2">Manage your personal details, office location, and account credentials.</p>
            </div>
            <div class="hidden md:block">
                <div class="h-12 w-12 rounded-full bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl font-bold border border-cyan-500/30">
                    {{ substr(Auth::user()->fName, 0, 1) }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-[#2a2e4b] rounded-2xl shadow-xl border border-white/5 p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>

                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <span class="w-1 h-6 bg-cyan-500 rounded-full"></span>
                        Professional Information
                    </h3>

                    <form method="post" action="{{ route('lecturer.profile.update') }}" class="space-y-6 relative z-10">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="fName" :value="__('First Name')" class="text-gray-300" />
                                <x-text-input id="fName" name="fName" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('fName', $user->fName)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fName')" />
                            </div>

                            <div>
                                <x-input-label for="lName" :value="__('Last Name')" class="text-gray-300" />
                                <x-text-input id="lName" name="lName" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('lName', $user->lName)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lName')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="email" :value="__('Email Address')" class="text-gray-300" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('email', $user->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="phoneOp" :value="__('Phone Operator')" class="text-gray-300" />
                                <x-text-input id="phoneOp" name="phoneOp" type="text" placeholder="+60" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('phoneOp', $user->phoneOp)" />
                            </div>
                            <div>
                                <x-input-label for="subNum" :value="__('Phone Number')" class="text-gray-300" />
                                <x-text-input id="subNum" name="subNum" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('subNum', $user->subNum)" />
                            </div>
                        </div>

                        <div class="border-t border-white/10 my-6"></div>

                        <h3 class="text-lg font-semibold text-cyan-400 mb-4">Office Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="officeBuilding" :value="__('Building')" class="text-gray-300" />
                                <x-text-input id="officeBuilding" name="officeBuilding" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('officeBuilding', $user->officeBuilding)" />
                            </div>
                            <div>
                                <x-input-label for="officeFloor" :value="__('Floor')" class="text-gray-300" />
                                <x-text-input id="officeFloor" name="officeFloor" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('officeFloor', $user->officeFloor)" />
                            </div>
                            <div>
                                <x-input-label for="officeRoom" :value="__('Room No.')" class="text-gray-300" />
                                <x-text-input id="officeRoom" name="officeRoom" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('officeRoom', $user->officeRoom)" />
                            </div>
                        </div>
                        
                        <div>
                             <x-input-label for="qualification" :value="__('Qualification')" class="text-gray-300" />
                             <x-text-input id="qualification" name="qualification" type="text" class="mt-1 block w-full bg-black/20 border-gray-600 text-white focus:border-cyan-500 focus:ring-cyan-500" :value="old('qualification', $user->qualification)" />
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 border-0">
                                {{ __('Save Changes') }}
                            </x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-400 font-semibold">
                                    {{ __('Saved successfully.') }}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-8">
                
                <div class="bg-[#2a2e4b] rounded-2xl shadow-xl border border-white/5 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Identification</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Staff ID</span>
                            <div class="text-cyan-300 font-mono text-lg font-bold">{{ $user->staffNum }}</div>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Faculty Code</span>
                            <div class="text-white font-semibold">{{ $user->facCode }}</div>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Department</span>
                            <div class="text-gray-300 text-sm">{{ $user->department ?? 'General' }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#2a2e4b] rounded-2xl shadow-xl border border-red-500/20 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                         <svg class="w-24 h-24 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    </div>

                    <h3 class="text-lg font-semibold text-white mb-4">Security</h3>
                    <p class="text-xs text-gray-400 mb-4">Ensure your account is using a long, random password to stay secure.</p>
                    
                    @include('profile.partials.update-password-form') 
                    </div>
                
            </div>
        </div>
    </div>
</x-lecturer-layout>