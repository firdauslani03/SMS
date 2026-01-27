<x-guest-layout title="Registration">
    <div class="min-h-screen flex flex-col items-center justify-center bg-brand-dark py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-500">
        
        <div class="mb-10 animate-fade-in-up">
            <div class="flex items-center justify-center p-6 bg-brand-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-brand-medium/20">
                <img src="{{ asset('images/smslogo.png') }}" alt="SMS LOGO" class="w-64 h-auto drop-shadow-lg">
            </div>
        </div>

        <div class="max-w-2xl w-full space-y-8 bg-brand-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-brand-medium/20 animate-fade-in-up delay-100">
            
            <div class="text-center">
                <h2 class="mt-2 text-3xl font-extrabold text-brand-white tracking-tight">
                    Student Registration
                </h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-brand-medium border-b border-brand-medium/30 pb-1">Personal Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label for="matricNum" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">Matric Number</label>
                            <input id="matricNum" name="matricNum" type="text" required autofocus 
                                value="{{ old('matricNum') }}"
                                class="appearance-none relative block w-full px-3 py-2 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent focus:z-10 sm:text-sm bg-brand-white transition-all duration-300 shadow-sm hover:shadow-md" 
                                placeholder="e.g. A25xxyyyy">
                            <x-input-error :messages="$errors->get('matricNum')" class="mt-1" />
                        </div>

                        <div class="group">
                            <label for="ic" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">IC Number (Without Dashes)</label>
                            <input id="ic" name="ic" type="text" required maxlength="12"
                                value="{{ old('ic') }}"
                                class="appearance-none relative block w-full px-3 py-2 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent focus:z-10 sm:text-sm bg-brand-white transition-all duration-300 shadow-sm hover:shadow-md" 
                                placeholder="e.g. xxxxxxxxxxxx">
                            <x-input-error :messages="$errors->get('ic')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label for="fName" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">First Name</label>
                            <input id="fName" name="fName" type="text" required 
                                value="{{ old('fName') }}"
                                class="appearance-none block w-full px-3 py-2 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                                placeholder="John">
                            <x-input-error :messages="$errors->get('fName')" class="mt-1" />
                        </div>
                        <div class="group">
                            <label for="lName" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">Last Name</label>
                            <input id="lName" name="lName" type="text" required 
                                value="{{ old('lName') }}"
                                class="appearance-none block w-full px-3 py-2 border border-brand-medium/30 placeholder-brand-dark/50 text-brand-dark rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                                placeholder="Doe">
                            <x-input-error :messages="$errors->get('lName')" class="mt-1" />
                        </div>
                    </div>

                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-brand-light mb-1 transition-colors group-focus-within:text-brand-white">Email Address</label>
                        <div class="flex rounded-md shadow-sm">
                            <input id="email" name="email" type="text" required 
                                value="{{ old('email') }}"
                                class="appearance-none block w-full px-3 py-2 border border-brand-medium/30 border-r-0 placeholder-brand-dark/50 text-brand-dark rounded-l-lg focus:outline-none focus:ring-2 focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                                placeholder="username">
                            
                            <span class="inline-flex items-center px-3 rounded-r-lg border border-brand-medium/30 border-l-0 bg-brand-medium/20 text-brand-light sm:text-sm font-medium select-none">
                                @graduate.utm.my
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <h3 class="text-lg font-medium text-brand-medium border-b border-brand-medium/30 pb-1">Academic Details</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label for="year" class="block text-sm font-medium text-brand-light mb-1">Year</label>
                            <input id="year" name="year" type="number" value="2026" readonly
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg bg-brand-white/30 focus:ring-brand-medium focus:border-transparent sm:text-sm cursor-not-allowed font-bold">
                        </div>

                        <div class="group">
                            <label for="semester" class="block text-sm font-medium text-brand-light mb-1">Semester</label>
                            <select id="semester" name="semester" required 
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md">
                                @foreach(range(1, 3) as $s)
                                    <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label for="facCode" class="block text-sm font-medium text-brand-light mb-1">Faculty</label>
                            <select id="facCode" name="facCode" required onchange="updateProgrammes()"
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md">
                                <option value="" disabled selected>Select Faculty</option>
                                <option value="FC" {{ old('facCode') == 'FC' ? 'selected' : '' }}>Faculty of Computing (FC)</option>
                                <option value="FS" {{ old('facCode') == 'FS' ? 'selected' : '' }}>Faculty of Science (FS)</option>
                            </select>
                        </div>

                        <div class="group">
                            <label for="progCode" class="block text-sm font-medium text-brand-light mb-1">Program Code</label>
                            <select id="progCode" name="progCode" required 
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md">
                                <option value="" disabled selected>Select Faculty First</option>
                            </select>
                            <x-input-error :messages="$errors->get('progCode')" class="mt-1" />
                        </div>
                    </div>

                    <div class="group">
                        <label for="cgpa" class="block text-sm font-medium text-brand-light mb-1">Current CGPA</label>
                        <input id="cgpa" name="cgpa" type="number" step="0.01" min="0" max="4.00" required 
                            value="{{ old('cgpa') }}"
                            class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                            placeholder="4.00">
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <h3 class="text-lg font-medium text-brand-medium border-b border-brand-medium/30 pb-1">Contact Info</h3>
                    <div class="flex gap-3">
                        <div class="w-1/3">
                            <label for="countryCode" class="block text-xs font-medium text-brand-light mb-1">Country Code</label>
                            <select id="countryCode" name="countryCode" required 
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white">
                                <option value="60" {{ old('countryCode') == '60' ? 'selected' : '' }}>🇲🇾 (+60)</option>
                                <option value="65" {{ old('countryCode') == '65' ? 'selected' : '' }}>🇸🇬 (+65)</option>
                                <option value="62" {{ old('countryCode') == '62' ? 'selected' : '' }}>🇮🇩 (+62)</option>
                                <option value="66" {{ old('countryCode') == '66' ? 'selected' : '' }}>🇹🇭 (+66)</option>
                                <option value="84" {{ old('countryCode') == '84' ? 'selected' : '' }}>🇻🇳 (+84)</option>
                                <option value="63" {{ old('countryCode') == '63' ? 'selected' : '' }}>🇵🇭 (+63)</option>
                                <option value="1"  {{ old('countryCode') == '1' ? 'selected' : '' }}>🇺🇸 (+1)</option>
                                <option value="44" {{ old('countryCode') == '44' ? 'selected' : '' }}>🇬🇧 (+44)</option>
                                <option value="86" {{ old('countryCode') == '86' ? 'selected' : '' }}>🇨🇳 (+86)</option>
                                <option value="81" {{ old('countryCode') == '81' ? 'selected' : '' }}>🇯🇵 (+81)</option>
                                <option value="82" {{ old('countryCode') == '82' ? 'selected' : '' }}>🇰🇷 (+82)</option>
                                <option value="61" {{ old('countryCode') == '61' ? 'selected' : '' }}>🇦🇺 (+61)</option>
                                <option value="91" {{ old('countryCode') == '91' ? 'selected' : '' }}>🇮🇳 (+91)</option>
                            </select>
                        </div>
                        <div class="w-1/4">
                            <label for="phoneOp" class="block text-xs font-medium text-brand-light mb-1">Operator</label>
                            <select id="phoneOp" name="phoneOp" required 
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white text-center">
                                @foreach(range(11, 19) as $op)
                                    <option value="{{ $op }}" {{ old('phoneOp') == $op ? 'selected' : '' }}>{{ $op }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label for="subNum" class="block text-xs font-medium text-brand-light mb-1">Number</label>
                            <input id="subNum" name="subNum" type="text" placeholder="1234567" maxlength="8" required 
                                value="{{ old('subNum') }}"
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white">
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <h3 class="text-lg font-medium text-brand-medium border-b border-brand-medium/30 pb-1">Security</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label for="password" class="block text-sm font-medium text-brand-light mb-1">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                                placeholder="Minimum 8 characters">
                        </div>
                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-medium text-brand-light mb-1">Confirm</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="block w-full px-3 py-2 border border-brand-medium/30 text-brand-dark rounded-lg focus:ring-brand-medium focus:border-transparent sm:text-sm bg-brand-white transition-all duration-300 hover:shadow-md"
                                placeholder="Re-enter your password">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6">
                    <a class="text-sm font-medium text-brand-light hover:text-brand-white transition-colors duration-200" href="{{ route('login') }}">
                        Already have an account?
                    </a>

                    <button type="submit" 
                        class="group relative w-full sm:w-auto flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-lg text-brand-dark bg-brand-medium hover:bg-brand-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-medium transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const programmes = {
            'FC': [
                { code: 'SECPH', name: 'Bachelor of Computer Science (Data Engineering) (SECPH)' },
                { code: 'SECBH', name: 'Bachelor of Computer Science (Bioinformatics) (SECBH)' }
            ],
            'FS': [
                { code: 'SSCAH', name: 'Bachelor of Science (Chemistry) (SSCAH)' },
                { code: 'SSCEH', name: 'Bachelor of Science (Mathematics) (SSCEH)' }
            ]
        };

        function updateProgrammes() {
            const facultySelect = document.getElementById('facCode');
            const progSelect = document.getElementById('progCode');
            const selectedFaculty = facultySelect.value;
            
            progSelect.innerHTML = '<option value="" disabled selected>Select Programme</option>';
            
            if (selectedFaculty && programmes[selectedFaculty]) {
                programmes[selectedFaculty].forEach(prog => {
                    const option = document.createElement('option');
                    option.value = prog.code;
                    option.textContent = prog.name;
                    progSelect.appendChild(option);
                });
            } else {
                progSelect.innerHTML = '<option value="" disabled selected>Select Faculty First</option>';
            }
        }

        // Run once on load to handle validation errors returning old input
        document.addEventListener('DOMContentLoaded', function() {
            const oldFaculty = "{{ old('facCode') }}";
            const oldProg = "{{ old('progCode') }}";
            
            if (oldFaculty) {
                updateProgrammes();
                // If there was an old program selected, re-select it
                if (oldProg) {
                    document.getElementById('progCode').value = oldProg;
                }
            }
        });
    </script>
</x-guest-layout>