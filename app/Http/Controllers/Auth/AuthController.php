<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function auth()
    {
        return view('auth.auth');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->with('dangerLogin', 'Email atau password salah');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'email' => 'email|unique:users,email',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);

        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            Auth::loginUsingId($data->id);

            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        } catch (\Throwable $e) {
            return back()->with('dangerRegister', 'Maaf, Terjadi kesalahan pada server');
        }
    }

    public function logout() 
    {
        Auth::logout();

        return redirect('/');
    }
}
