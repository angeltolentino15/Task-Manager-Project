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
        // 1. Validate the incoming data (including our new fields)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        // ... (Validation code stays the same) ...

        // 2. SMARTER Auto-generate Employee ID
        // Logic: Find the highest existing employee_id string in the database
        $latestUser = User::whereNotNull('employee_id')
                          ->orderBy('employee_id', 'desc')
                          ->first();

        if ($latestUser) {
            // Extract the last 4 digits (e.g., from 'EMP-2026-0005', grab '0005')
            $lastNumber = intval(substr($latestUser->employee_id, -4));
        } else {
            // If no employees exist yet, start at 0
            $lastNumber = 0;
        }

        // Add 1 to get the new number
        $nextId = $lastNumber + 1;
        $generatedEmployeeId = 'EMP-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // 3. Create the user ... (The rest stays the same)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee', // Hardcoded so they can't make themselves admins
            'employee_id' => $generatedEmployeeId,
            'department' => $request->department,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
