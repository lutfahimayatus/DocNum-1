<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    public function Redirect()
    {
        return redirect()->route('login');
    }

    public function register(Request $request, RateLimiter $limiter)
    {
        try {
            if ($request->isMethod('post')) {
                $rules = [
                    'nip' => 'required|unique:users',
                    'role' => 'required|string',
                    'password' => 'required|min:8|confirmed',
                ];

                $messages = [
                    'nip.required' => 'Kolom NIP wajib diisi.',
                    'role.required' => 'Kolom Role wajib diisi.',
                    'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
                    'password.required' => 'Kolom kata sandi wajib diisi.',
                    'password.min' => 'Kata sandi harus terdiri dari setidaknya 8 karakter.',
                    'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
                ];

                $this->validate($request, $rules, $messages);

                if (RateLimiter::tooManyAttempts('/register', $perMinute = 5)) {
                    $seconds = RateLimiter::availableIn('/register');
                    return redirect('/register')->with('error', 'Too many registration attempts. You may try again in '.$seconds.' seconds.');
                }

                $registerUser = User::create([
                    'name' => '',
                    'email' => '',
                    'nomor_hp' => '',
                    'foto_profile' => '',
                    'divisi_id' => null,
                    'nip' => $request->input('nip'),
                    'role' => $request->input('role'),
                    'password' => bcrypt($request->input('password')),
                ]);

                if ($registerUser) {
                    RateLimiter::clear('/register');
                    UserLogs::logAction($request, 'ATTEMPT REGISTER USER', $registerUser->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect('/register')->with('success', 'Pendaftaran berhasil, anda sekarang dapat masuk.');
                }
            }

            $title = 'Register';
            return view('auth.register', compact('title'));
        } catch (\Exception $e) {
            RateLimiter::hit('/register');
            $errorMessage = 'Pendaftaran gagal: ' . $e->getMessage();
            UserLogs::logAction($request, 'ATTEMPT REGISTER USER', '0', '', '{"isStatus": false, "pesan": "' . $errorMessage . '"}');
            return back()->withInput()->with('error', $errorMessage);
        }
    }

    public function login(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $rules = [
                    'nip' => 'required',
                    'password' => 'required',
                ];

                $messages = [
                    'nip.required' => 'Kolom NIP wajib diisi.',
                    'password.required' => 'Kolom kata sandi wajib diisi.',
                ];

                $this->validate($request, $rules, $messages);

                if (RateLimiter::tooManyAttempts('/login', $perMinute = 5)) {
                    $seconds = RateLimiter::availableIn('/login');
                    return redirect('/login')->with('error', 'Too many login attempts. You may try again in '.$seconds.' seconds.');
                }

                try {
                    $user = User::where('nip', $request->input('nip'))->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    RateLimiter::hit('/login');
                    UserLogs::logAction($request, 'NIP NOT FOUND', '0', '', '{"isStatus": false, "pesan": "User dengan NIP tidak ditemukan."}');
                    return redirect('/login')->with('error', 'User with the provided NIP does not exist.');
                }

                if (RateLimiter::tooManyAttempts('/login_password', $maxAttempts = 3, $perMinute = 3)) {
                    $seconds = RateLimiter::availableIn('/login_password'); 
                    RateLimiter::hit('/login_password');
                    UserLogs::logAction($request, 'PASSWORD ATTEMPT LIMIT EXCEEDED', '0', '', '{"isStatus": false, "pesan": "Gagal - batas percobaan kata sandi terlampaui."}');
                    return redirect('/login')->with('error', 'Too many incorrect password attempts. You may try again in '.$seconds.' seconds.');
                }
                

                if (Auth::attempt(['nip' => $request->input('nip'), 'password' => $request->input('password')])) {
                    RateLimiter::clear('/login');
                    RateLimiter::clear('/login_password');
                    
                    UserLogs::logAction($request, 'ATTEMPT LOGIN USER', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect('/dashboard')->with('success', 'Login berhasil!');
                } else {
                    RateLimiter::hit('/login_password');
                    UserLogs::logAction($request, 'ATTEMPT LOGIN USER', '0', '', '{"isStatus": false, "pesan": "Gagal"}');
                    return redirect('/login')->with('error', 'Password salah!');
                }
            }

            $title = 'Login';
            return view('auth.login', compact('title'));
        } catch (\Exception $e) {
            UserLogs::logAction($request, 'LOGIN ERROR', '0', '', '{"isStatus": false, "pesan": "Terjadi kesalahan saat login: ' . $e->getMessage() . '"}');
            return redirect('/login')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function Logout(Request $request): RedirectResponse
    {
        $user = Auth::user()->id;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        UserLogs::logAction($request, 'ATTEMPT LOGOUT USER', $user, '', '{"isStatus": true, "pesan": "Sukses"}');

        return redirect('/login')->with('success', 'Anda telah keluar.');
    }
}
