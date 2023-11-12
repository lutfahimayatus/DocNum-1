<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    private function decryptIfEncrypted($encryptedId) 
    {
        if (preg_match('/^\d/', $encryptedId)) {
            return $encryptedId;
        } else {
            return decrypt($encryptedId);
        }
    }

    public function index(Request $request)
    {
        $data = Division::withTrashed()->get();
        $title = 'Data Divisi';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'DataDisivi', '');
        return view('pages.division.index', compact('data','title'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'divisi' => 'required|string',
                'kode' => 'required|string'
            ];

            $message = [
                'kode.required' => 'Kolom kode wajib diisi',
                'divisi.required' => 'Kolom divisi wajib diisi'
            ];

            $this->validate($request, $rules, $message);

            $data = Division::create([
                'divisi' => $request->input('divisi'),
                'kode' => $request->input('kode')
            ]);

            if ($data) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('div.index')->with('success', 'Berhasil menambahkan divisi');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah divisi');
            }
        }

        $title = 'Tambah Divisi';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'TambahDivisi', '');
        return view('pages.division.store', compact('title'));
    }
    
    public function update(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        if ($request->isMethod('post')) {
            $rules = [
                'divisi' => 'required|string',
                'kode' => 'required|string',
            ];
    
            $messages = [
                'divisi.required' => 'Kolom kategori wajib diisi.',
                'kode.required' => 'Kolom kode wajib diisi.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $data = Division::find($id);
            $data->divisi = $request->input('divisi');
            $data->kode = $request->input('kode');
    
            if ($data->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('div.index', $id)
                    ->with('success', 'Division information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('div.update', $id)
                    ->with('error', 'Division information update failed');
            }
        } 
        $data = Division::find($id);
        $title = 'Update Divisi';
        UserLogs::logAction($request, 'Data Access ID:'.$id, Auth::user()->id, 'UpdateDivision', '');
        return view('pages.division.update', compact('title', 'data'));
    }

    public function restore(Request $request, $id)
    {
        $data = Division::withTrashed()->find($id);
    
        if ($data) {
            if ($data->trashed()) {
                $data->restore();
                UserLogs::logAction($request, 'ATTEMPT RESTORE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('div.index')->with('success', 'Division restored successfully');
            } else {
                return redirect()->route('div.index')->with('error', 'Division is not soft-deleted');
            }
        } else {
            return redirect()->route('div.index')->with('error', 'Division not found');
        }
    }    

    public function delete(Request $request, $id)
    {
        $data = Division::find($id);

        if ($data) {
            $data->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

            return redirect()->route('div.index')
                ->with('success', 'Division deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('div.index')
                ->with('error', 'Division not found');
        }
    }
}
