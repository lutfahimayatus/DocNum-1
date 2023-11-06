<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dataUser = User::count();
        $dataCat = Categories::count();
        $title = 'Beranda';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'Dashboard', '');
        return view('index', compact('dataCat', 'dataUser', 'user', 'title'));
    }

    public function changePassword(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'old_password' => 'required|string',
                'new_password' => 'required|min:8|confirmed',
            ];
    
            $messages = [
                'old_password.required' => 'Kolom kata sandi lama wajib diisi.',
                'new_password.required' => 'Kolom kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru harus terdiri dari setidaknya 8 karakter.',
            ];
    
            $this->validate($request, $rules, $messages);

            $data = User::find($id);
            if (password_verify($request->input('old_password'), $data->password)) {
                $data->password = bcrypt($request->input('new_password'));
                if ($data->save()) {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE USER PASSWORD', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect()->route('profile.change.password', $id)
                        ->with('success', 'User password updated successfully');
                } else {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE USER PASSWORD', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                    return redirect()->route('profile.change.password', $id)
                        ->with('error', 'User password update failed');
                }
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE USER PASSWORD', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('profile.change.password', $id)
                    ->with('error', 'Old password is incorrect');
            }
        }

        $data = User::find($id);
        $title = 'Ganti Kata Sandi';
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'PasswordUser', '');
        return view('change_password', compact(['data', 'title']));
    }

    public function profile(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|string',
                'nip' => 'required|unique:users,nip,'.$id,
                'role' => 'required',
            ];
    
            $messages = [
                'name.required' => 'Kolom nama wajib diisi.',
                'nip.required' => 'Kolom NIP wajib diisi.',
                'role.required' => 'Kolom role wajib diisi.',
                'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
            ];
    
            $this->validate($request, $rules, $messages);

            $user = User::find($id);
            $user->name = $request->input('name');
            $user->nip = $request->input('nip');
            $user->role = $request->input('role');

            if ($user->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE USER DATA', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('profile', $id)
                    ->with('success', 'User information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE USER DATA', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('profile', $id)
                    ->with('error', 'User information update failed');
            }
        }

        $user = User::find($id);
        $title = 'Profile';
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'ProfileUser', '');
        return view('profile', compact(['user', 'title']));
    }
}
