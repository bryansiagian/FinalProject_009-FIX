<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registration
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'shipping_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'kode_pos' => 'required|string|max:10', // Validasi kode pos
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'shipping_address' => $request->shipping_address,
            'phone_number' => $request->phone_number,
            'kode_pos' => $request->kode_pos, // Simpan kode pos
        ]);

        Auth::login($user);

        return redirect()->route('welcome')->with('success', 'Registrasi berhasil!');
    }

    // Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // Dapatkan user yang login

            if ($user->isAdmin()) {  // Gunakan method isAdmin()
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
            } else {
                return redirect()->route('welcome')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Logout berhasil!');
    }
}