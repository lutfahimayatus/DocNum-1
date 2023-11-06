<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(10);
        $title = 'Data Users';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'DataUser', '');
        return view('pages.users.index', compact('users', 'title'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|string',
                'nomor_hp' => 'required|string',
                'nip' => 'required|unique:users',
                'role' => 'required',
                'divisi_id' => 'required',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ];

            $messages = [
                'name.required' => 'Kolom nama wajib diisi.',
                'nomor_hp.required' => 'Kolom nomor telepon wajib diisi.',
                'nip.required' => 'Kolom NIP wajib diisi.',
                'role.required' => 'Kolom role wajib diisi.',
                'divisi_id.required' => 'Kolom divisi wajib diisi.',
                'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
                'email.required' => 'Kolom email wajib diisi.',
                'email.unique' => 'email ini telah digunakan sebelumnya.',
                'password.required' => 'Kolom kata sandi wajib diisi.',
                'password.min' => 'Kata sandi harus terdiri dari setidaknya 8 karakter.',
            ];

            $this->validate($request, $rules, $messages);
    
            $addUser = User::create([
                'name' => $request->input('name'),
                'nomor_hp' => $request->input('nomor_hp'),
                'nip' => $request->input('nip'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'divisi' => $request->input('divisi'),
                'password' => bcrypt($request->input('password')),
            ]);

            if ($addUser) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('user.index')->with('success', 'Berhasil menambahkan user');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah user');
            }            
        }

        $title = 'Add User';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'TambahUser', '');
        return view('pages.users.store', compact('title'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|string',
                'nomor_hp' => 'required|string',
                'nip' => 'required|unique:users,nip,'.$id,
                'email' => 'required|string|unique:users,email'.$request->input('email'),
                'role' => 'required',
                'divisi_id' => 'required',
            ];
    
            $messages = [
                'name.required' => 'Kolom nama wajib diisi.',
                'nomor_hp.required' => 'Kolom nomor telepon wajib diisi.',
                'nip.required' => 'Kolom NIP wajib diisi.',
                'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
                'email.required' => 'Kolom email wajib diisi.',
                'email.unique' => 'email ini telah digunakan sebelumnya.',
                'role.required' => 'Kolom role wajib diisi.',
                'divisi_id.required' => 'Kolom divisi wajib diisi.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->nomor_hp = $request->input('nomor_hp');
            $user->nip = $request->input('nip');
            $user->email = $request->input('email');
            $user->role = $request->input('role');
            $user->divisi_id = $request->input('divisi_id');
    
            if ($user->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('user.index', $id)
                    ->with('success', 'User information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('user.update', $id)
                    ->with('error', 'User information update failed');
            }
        } 
    
        $user = User::find($id);
        $title = 'Update User';
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'User ID:'.$id, '');
        return view('pages.users.update', compact('user', 'title'));
    }    

    public function delete(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

            return redirect()->route('user.index')
                ->with('success', 'User deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('user.index')
                ->with('error', 'User not found');
        }
    }
}
