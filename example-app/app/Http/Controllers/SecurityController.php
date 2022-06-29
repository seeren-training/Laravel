<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecurityLoginRequest;
use App\Http\Requests\SecurityRegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{

    public function store(SecurityRegisterRequest $request)
    {
        $validated = $request->validated();
        $user = new User($validated);
        $user->password = bcrypt($user->password);
        $user->save();
        return redirect()->route('task.index');
    }

    public function register(): View
    {
        return view('security.register', [
            'user' => new User()
        ]);
    }

    public function authenticate(SecurityLoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('task');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function login(): View
    {
        return view('security.login', [
            'user' => new User()
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
