<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'min:2', 'max:50'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'confirmed', 'min:8', new StrongPassword()],
            'age'          => ['required', 'integer', 'min:13', 'max:100'],
            'height_cm'    => ['required', 'numeric', 'min:100', 'max:250'],
            'weight_kg'    => ['required', 'numeric', 'min:30', 'max:300'],
            'fitness_goal' => ['required', 'string', 'in:lose_weight,build_muscle,stay_fit,improve_endurance'],
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'age'          => (int) $request->age,
            'height_cm'    => (float) $request->height_cm,
            'weight_kg'    => (float) $request->weight_kg,
            'fitness_goal' => $request->fitness_goal,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Store fitness goal in session on registration
        session(['fitness_goal' => $user->fitness_goal]);

        return redirect(route('dashboard', absolute: false));
    }
}
