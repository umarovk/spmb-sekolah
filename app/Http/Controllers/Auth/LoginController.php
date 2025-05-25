<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('siswa.index');
        }

        $input = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if(Auth::attempt([$fieldType => $input['login'], 'password' => $input['password']])) {
            $request->session()->regenerate();
            
            // Record login time
            $user = Auth::user();
            try {
                $lastLoginNumber = $user->loginLogs()->max('login_number') ?? 0;
                $user->loginLogs()->create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_at' => now(),
                    'login_number' => $lastLoginNumber + 1
                ]);
            } catch (\Exception $e) {
                // If login_number column doesn't exist yet, create log without it
                $user->loginLogs()->create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_at' => now()
                ]);
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau password salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}