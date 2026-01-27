<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Pre-processing: Append the fixed domain to the input
        // This takes the 'username' entered by the student and adds '@graduate.utm.my'
        // We do this BEFORE validation so that the 'email' rule sees a valid address.
        $request->merge([
            'email' => $request->email . '@graduate.utm.my',
        ]);

        // 2. Validate the full request (including the now-complete email)
        $request->validate([
            'matricNum' => ['required', 'string', 'max:255', 'unique:'.Student::class],
            'fName' => ['required', 'string', 'max:255'],
            'lName' => ['required', 'string', 'max:255'],
            'ic' => ['required', 'string', 'max:12', 'unique:'.Student::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Student::class],
            'year' => ['required', 'integer', 'min:1'],
            'semester' => ['required', 'integer', 'min:1'],
            'progCode' => ['required', 'string'],
            'cgpa' => ['required', 'numeric', 'between:0,4.00'],
            'countryCode' => ['required', 'string', 'max:3'],
            'phoneOp' => ['required', 'string', 'max:2'],
            'subNum' => ['required', 'string', 'max:8'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 3. Create the Student record
        $student = Student::create([
            'matricNum' => $request->matricNum,
            'fName' => $request->fName,
            'lName' => $request->lName,
            'ic' => $request->ic,
            'email' => $request->email,
            'year' => $request->year,
            'semester' => $request->semester,
            'progCode' => $request->progCode,
            'cgpa' => $request->cgpa,
            'countryCode' => $request->countryCode,
            'phoneOp' => $request->phoneOp,
            'subNum' => $request->subNum,
            'pass' => Hash::make($request->password),
        ]);

        event(new Registered($student));

        Auth::login($student);

        return redirect(route('dashboard', absolute: false));
    }
}