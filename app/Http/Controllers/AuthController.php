<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\WilayahDesa; // Tambahkan import

class AuthController extends Controller
{
    // Registration
    public function showRegistrationForm()
    {
        $wilayahDesas = WilayahDesa::all(); // Ambil semua wilayah desa
        return view('auth.register', compact('wilayahDesas'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'shipping_address' => 'required|string|max:255',
            'phone_number' => 'required|string|min:9|max:15|regex:/^[0-9]+$/',
            'wilayah_desa_id' => 'required|exists:wilayah_desa,id', // Wajib diisi dan harus ada di tabel wilayah_desa
        ], [
            'phone_number.min' => 'Nomor telepon minimal 9 digit.',
            'phone_number.max' => 'Nomor telepon maksimal 15 digit.',
            'phone_number.regex' => 'Nomor telepon harus berupa angka.',
            'wilayah_desa_id.required' => 'Wilayah/Desa harus dipilih.',
            'wilayah_desa_id.exists' => 'Wilayah/Desa tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $phoneNumber = '+62' . $request->phone_number;


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'shipping_address' => $request->shipping_address,
            'phone_number' => $phoneNumber,
            'wilayah_desa_id' => $request->wilayah_desa_id, // Pastikan data ini benar
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

            // Contoh penggunaan role (jika ada)
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('welcome')->with('success', 'Login berhasil!');
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