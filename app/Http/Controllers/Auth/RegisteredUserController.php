<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:65535'],
            'status' => ['required', 'in:umum,mahasiswa'],
            'student_id_card' => ['nullable', 'required_if:status,mahasiswa', 'image', 'max:2048'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $studentIdCardPath = null;
        if ($request->hasFile('student_id_card')) {
            $studentIdCardPath = $request->file('student_id_card')->store('student_id_cards', 'public');
        }

        $is_approved = $request->status === 'umum';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'status' => $request->status,
            'student_id_card_path' => $studentIdCardPath,
            'password' => Hash::make($request->password),
            'is_approved' => $is_approved,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if (!$is_approved) {
            return redirect(route('pending.approval'));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
