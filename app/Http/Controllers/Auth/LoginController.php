<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pages.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::whereEmail($credentials['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        if($user->status == 0){
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }
        if (Auth::attempt($credentials)) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } else if (auth()->user()->hasRole('teacher')) {
                return redirect()->intended(route('teacher.dashboard'));
            } else {
                return redirect()->intended(route('student.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
