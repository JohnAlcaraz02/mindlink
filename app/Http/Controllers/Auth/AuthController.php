<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:Student,Administrator',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = $request->user_type;

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email', 'user_type');
    }

    public function register(Request $request)
    {
        // Debug: Log what was received
        \Log::info('Registration attempt', [
            'user_type' => $request->user_type,
            'all_data' => $request->all()
        ]);

        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::min(8)],
            'user_type' => 'required|in:Student,Administrator',
        ];

        // Add email and college validation based on user type
        if ($request->user_type === 'Student') {
            $rules['email'] = [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^\d{2}-\d{5}@g\.batstate-u\.edu\.ph$/'
            ];
            $rules['college'] = 'required|string|in:College of Engineering,College of Engineering Technology,College of Informatics and Computing Sciences,College of Architecture Fine Arts and Design';
        } else {
            $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        $messages = [
            'email.regex' => 'Student email must be in the format XX-XXXXX@g.batstate-u.edu.ph (e.g., 21-12345@g.batstate-u.edu.ph)',
        ];

        $request->validate($rules, $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'college' => $request->user_type === 'Student' ? $request->college : null,
        ]);

        Auth::login($user);

        return redirect('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}