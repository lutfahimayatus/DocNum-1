<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NIP;
use App\Models\UserLogs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Redirect()
    {
        return redirect()->route('login');
    }

    public function Register(Request $request)
    {
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
            ];
    
            $this->validate($request, $rules, $messages);
            
            try {
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
                    UserLogs::logAction($request, 'ATTEMPT REGISTER USER', $request->input('nip'), '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect('/register')->with('success', 'Pendaftaran berhasil, anda sekarang dapat masuk.');
                }
            } catch (\Exception $e) {
                UserLogs::logAction($request, 'ATTEMPT REGISTER USER', $request->input('nip'), '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Pendaftaran gagal: ');
            }    
        } 
        
        $title = 'Register';
        return view('auth.Register', compact('title'));
    }    

    public function Login(Request $request)
    {
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

            if (Auth::attempt(['nip' => $request->input('nip'), 'password' => $request->input('password')])) {
                UserLogs::logAction($request, 'ATTEMPT LOGIN USER', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect('/dashboard')->with('success', 'Login berhasil!');
            } else {
                UserLogs::logAction($request, 'ATTEMPT LOGIN USER', $request->input('nip'), '', '{"isStatus": false, "pesan": "Gagal"}');
                return redirect('/login')->with('error', 'Password salah!');
            }
        } 

        $title = 'Login';
        return view('auth.login', compact('title'));
    }

    public function CheckpointNIP(Request $request)
    {
        $nipExists = NIP::where('nip', $request->input('nip'))->exists();
        if ($nipExists) {
            return response()->json(['message' => 'NIP tersedia dalam database.']);
        } else {
            return response()->json(['message' => 'NIP tidak tersedia dalam database.'], 404);
        }
    }

    public function Logout(Request $request): RedirectResponse
    {
        $user = Auth::user()->nip;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        UserLogs::logAction($request, 'ATTEMPT LOGOUT USER', $user, '', '{"isStatus": true, "pesan": "Sukses"}');

        return redirect('/login')->with('success', 'Anda telah keluar.');
    }
}
