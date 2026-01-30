<x-guest-layout title="Registration">
    {{-- Main Container --}}
    <div class="min-h-screen flex flex-col items-center justify-center bg-brand-dark py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- LOGO SECTION: Outside the container, centered on top with background --}}
        <div class="mb-8 animate-fade-in-up">
            <div class="p-5 bg-brand-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-brand-medium/20 flex items-center justify-center">
                <img src="{{ asset('images/smslogo.png') }}" alt="SMS LOGO" class="w-48 h-auto drop-shadow-lg">
            </div>
        </div>

        {{-- MAIN FORM CONTAINER --}}
        <div class="w-full max-w-7xl bg-brand-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-brand-medium/20 p-8 animate-fade-in-up delay-100">
            
            {{-- Header: Just Title & Link now --}}
            <div class="flex items-center justify-between mb-8 border-b border-brand-medium/20 pb-4">
                <h2 class="text-3xl font-extrabold text-brand-white tracking-tight">
                    Student Registration
                </h2>
                <div class="text-right">
                    <a class="text-base font-medium text-brand-light hover:text-brand-white transition-colors duration-200" href="{{ route('login') }}">
                        Already have an account? <span class="text-brand-medium hover:underline ml-1">Log in</span>
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    {{-- LEFT COLUMN: Personal & Contact --}}
                    <div class="space-y-6">
                        <h3 class="text-2xl font-bold text-brand-white/90 border-b border-brand-medium/50 pb-2 mb-4">Personal Details</h3>
                        
                        {{-- Name Row --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">First Name</label>
                                <input id="fName" name="fName" type="text" required value="{{ old('fName') }}"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="John">
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Last Name</label>
                                <input id="lName" name="lName" type="text" required value="{{ old('lName') }}"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="Doe">
                            </div>
                        </div>

                        {{-- ID Row --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Matric No.</label>
                                <input id="matricNum" name="matricNum" type="text" required value="{{ old('matricNum') }}"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="A25xxyyyy">
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">IC No. <span class="text-xs font-normal opacity-70">(No dash)</span></label>
                                <input id="ic" name="ic" type="text" required maxlength="12" value="{{ old('ic') }}"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="000000112222">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="group">
                            <label class="block text-base font-bold text-brand-white mb-2">Email Address</label>
                            <div class="flex rounded-xl shadow-sm">
                                <input id="email" name="email" type="text" required value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-brand-medium/30 border-r-0 text-brand-dark text-lg rounded-l-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white"
                                    placeholder="username">
                                <span class="inline-flex items-center px-4 rounded-r-xl border border-brand-medium/30 bg-brand-medium/20 text-brand-white text-base font-semibold select-none">
                                    @graduate.utm.my
                                </span>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="group">
                            <label class="block text-base font-bold text-brand-white mb-2">Phone Number</label>
                            <div class="flex gap-3">
                                <select id="countryCode" name="countryCode" required class="w-[25%] px-2 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl bg-brand-white shadow-sm">
                                    <option value="60">🇲🇾 +60</option>
                                    <option value="65">🇸🇬 +65</option>
                                    <option value="62">🇮🇩 +62</option>
                                </select>
                                <select id="phoneOp" name="phoneOp" required class="w-[25%] px-2 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl bg-brand-white text-center shadow-sm">
                                    @foreach(range(11, 19) as $op)
                                        <option value="{{ $op }}">{{ $op }}</option>
                                    @endforeach
                                </select>
                                <input id="subNum" name="subNum" type="text" placeholder="1234567" maxlength="8" required 
                                    class="flex-1 px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Academic & Security --}}
                    <div class="space-y-6 lg:pl-8 lg:border-l border-brand-medium/20">
                        <h3 class="text-2xl font-bold text-brand-white/90 border-b border-brand-medium/50 pb-2 mb-4">Academic & Security</h3>

                        {{-- Faculty & Program --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Faculty</label>
                                <select id="facCode" name="facCode" required onchange="updateProgrammes()"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm">
                                    <option value="" disabled selected>Select Faculty</option>
                                    <option value="FC" {{ old('facCode') == 'FC' ? 'selected' : '' }}>Faculty of Computing (FC)</option>
                                    <option value="FS" {{ old('facCode') == 'FS' ? 'selected' : '' }}>Faculty of Science (FS)</option>
                                </select>
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Program</label>
                                <select id="progCode" name="progCode" required 
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm">
                                    <option value="" disabled selected>Select Faculty First</option>
                                </select>
                            </div>
                        </div>

                        {{-- Year, Sem, CGPA --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Year</label>
                                <input name="year" type="number" value="2026" readonly
                                    class="w-full px-2 py-3 border border-brand-medium/30 text-brand-dark font-bold text-lg rounded-xl bg-brand-white/50 text-center cursor-not-allowed shadow-sm">
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Semester</label>
                                <select name="semester" required class="w-full px-2 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl bg-brand-white text-center shadow-sm">
                                    @foreach(range(1, 3) as $s)
                                        <option value="{{ $s }}">{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">CGPA</label>
                                <input name="cgpa" type="number" step="0.01" min="0" max="4.00" required placeholder="3.50"
                                    class="w-full px-2 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl bg-brand-white text-center focus:ring-2 focus:ring-brand-medium focus:outline-none shadow-sm">
                            </div>
                        </div>

                        {{-- Password Row --}}
                        <div class="grid grid-cols-2 gap-5 pt-2">
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Password</label>
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="********">
                            </div>
                            <div class="group">
                                <label class="block text-base font-bold text-brand-white mb-2">Confirm</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required 
                                    class="w-full px-4 py-3 border border-brand-medium/30 text-brand-dark text-lg rounded-xl focus:ring-2 focus:ring-brand-medium focus:outline-none bg-brand-white shadow-sm"
                                    placeholder="********">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-8">
                            <button type="submit" 
                                class="w-full flex justify-center py-4 px-8 border border-transparent text-xl font-bold rounded-xl text-brand-dark bg-brand-medium hover:bg-brand-white hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-medium transition-all duration-200 shadow-lg">
                                Register
                            </button>
                            @if ($errors->any())
                                <div class="mt-4 text-center">
                                    <p class="text-red-400 font-bold text-sm bg-red-900/20 py-1 px-3 rounded inline-block">
                                        Please fix the errors in the form.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const programmes = {
            'FC': [
                { code: 'SECPH', name: 'Data Engineering (SECPH)' },
                { code: 'SECBH', name: 'Bioinformatics (SECBH)' }
            ],
            'FS': [
                { code: 'SSCAH', name: 'Chemistry (SSCAH)' },
                { code: 'SSCEH', name: 'Mathematics (SSCEH)' }
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

        document.addEventListener('DOMContentLoaded', function() {
            const oldFaculty = "{{ old('facCode') }}";
            const oldProg = "{{ old('progCode') }}";
            
            if (oldFaculty) {
                updateProgrammes();
                if (oldProg) document.getElementById('progCode').value = oldProg;
            }
        });
    </script>
</x-guest-layout>