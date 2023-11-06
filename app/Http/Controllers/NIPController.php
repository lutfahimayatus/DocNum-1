<?php

namespace App\Http\Controllers;

use App\Imports\NIPImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\NIP;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class NIPController extends Controller
{
    public function index(Request $request)
    {
        $nips = NIP::paginate(10);
        $title = 'Data NIP';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'DataNIP', '');
        return view('pages.nips.index', compact('nips', 'title'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'nip' => 'required|unique:nips',
            ];

            $messages = [
                'nip.required' => 'Kolom NIP wajib diisi.',
                'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
            ];

            $this->validate($request, $rules, $messages);
    
            $addNip = NIP::create([
                'nip' => $request->input('nip'),
            ]);

            if ($addNip) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('nip.index')->with('success', 'Berhasil menambahkan user');
            } else {
                UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah NIP');
            }
        }

        $title = 'Add NIP';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'TambahNIP', '');
        return view('pages.nips.store', compact('title'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'nip' => 'required|unique:users,nip,'.$id,
            ];
    
            $messages = [
                'nip.required' => 'Kolom NIP wajib diisi.',
                'nip.unique' => 'NIP ini telah digunakan sebelumnya.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $nip = NIP::find($id);
            $nip->nip = $request->input('nip');
    
            if ($nip->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('nip.update', $id)
                    ->with('success', 'NIP information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                return redirect()->route('nip.update', $id)
                    ->with('error', 'NIP information update failed');
            }
        }
    
        $nips = NIP::find($id);
        $title = 'Update NIP';
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'NIP:'.$id, '');
        return view('pages.nips.update', compact('nips', 'title'));
    }

    public function delete(Request $request,$id)
    {
        $nip = NIP::find($id);

        if ($nip) {
            $nip->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
    
            return redirect()->route('nip.index')
                ->with('success', 'NIP deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('nip.index')
                ->with('error', 'NIP not found');
        }
    }

    public function csv(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            $request->validate([
                'file' => 'required|mimes:csv,xls,xlsx|max:2048',
            ]);
    
            try {
                Excel::import(new NIPImport, $file);
    
                return redirect()->back()->with('success', 'Data diunggah dan diproses dengan sukses.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
            }
        }
    
        return redirect()->back()->with('error', 'Tidak ada file yang dipilih atau format file tidak valid.');
    }    
}
