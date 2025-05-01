<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->only(['showLogin', 'showRegister', 'loginPost', 'storeAkun']);
    }

    public function showLogin(){
        return view ('auth.login');
    }

    public function showRegister(){
        return view ('auth.register');
    }

    public function loginPost(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'dokter') {
                return redirect()->route('dokter.dashboard');
            }
            elseif (Auth::user()->role == 'pasien') {
                return redirect()->route('pasien.dashboard');
            }
            else {
                return redirect()->route('login');
            }

        }
 
        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }
    
    public function storeAkun(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:pasien,dokter',
            // 'terms' => 'accepted',
        ]);

        User::create([
            'nama' => $validateData['nama'],
            'alamat' => $validateData['alamat'],
            'no_hp' => $validateData['no_hp'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']), // Enkripsi password
            'role' => $validateData['role'],
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}