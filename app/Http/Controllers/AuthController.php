<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:pengguna,username',
            'email' => 'required|email|max:100|unique:pengguna,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Pengguna::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role' => 'student',
            'total_exp' => 0,
            'tanggal_registrasi' => now(),
        ]);

        // login: simpan session sederhana (alternatif: Auth::loginUsingId($user->id_pengguna))
        session()->put('pengguna_id', $user->id_pengguna);
        session()->put('pengguna_username', $user->username);
        session()->put('pengguna_role', $user->role);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Selamat datang '.$user->username);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Pengguna::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return redirect()->back()->withErrors(['username' => 'Username atau password salah'])->withInput();
        }

        session()->put('pengguna_id', $user->id_pengguna);
        session()->put('pengguna_username', $user->username);
        session()->put('pengguna_role', $user->role);

    
        if ($user->role === 'teacher') {
            // dd($user);
            return redirect()
                ->route('guru.dashboard')
                ->with('success', 'Berhasil login, selamat datang ' . $user->username);
        } elseif ($user->role === 'student') {
            return redirect()
                ->route('home')
                ->with('success', 'Berhasil login, selamat datang ' . $user->username);
        }
        return redirect()->route('dashboard')->with('success','Berhasil login, selamat datang '.$user->username);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('landing')->with('success','Anda telah logout.');
    }

    // Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
    
            $user = Pengguna::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'username' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password_hash' => Hash::make(uniqid()),
                    'role' => 'student',
                    'total_exp' => 0,
                    'tanggal_registrasi' => now(),
                ]
            );
    
            // pakai session sama seperti login manual
            session()->put('pengguna_id', $user->id_pengguna);
            session()->put('pengguna_username', $user->username);
            session()->put('pengguna_role', $user->role);
    
            return redirect()->route('home')->with('success','Berhasil login dengan Google, selamat datang '.$user->username);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google: '.$e->getMessage());
        }
    }
}
