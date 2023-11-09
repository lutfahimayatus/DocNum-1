<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenis;
use App\Models\UserLogs;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;

class JenisController extends Controller
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
        $title = 'Data Jenis';
        $data = Jenis::with('category')->get();
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'DataJenis', '');
        return view('pages.jenis.index', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'jenis' => 'required|string',
                'kode' => 'required|string',
                'category_id' => 'required'
            ];

            $messages = [
                'jenis.required' => 'Kolom jenis wajib diisi.',
                'kode.required' => 'Kolom kode wajib diisi.',
                'category_id.required' => 'Kolom kategori wajib diisi.',
            ];

            $this->validate($request, $rules, $messages);
    
            $data = Jenis::create([
                'jenis' => $request->input('jenis'),
                'kode' => $request->input('kode'),
                'category_id' => $request->input('category_id'),
            ]);

            if ($data) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('jenis.index')->with('success', 'Berhasil menambahkan jenis');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah jenis');
            }
        }

        $title = 'Add Jenis';
        $categories = Categories::all();
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'TambahJenis', '');
        return view('pages.jenis.store', compact('title', 'categories'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        if ($request->isMethod('post')) {
            $rules = [
                'jenis' => 'required|string',
                'kode' => 'required|string',
                'category_id' => 'required'
            ];
    
            $messages = [
                'jenis.required' => 'Kolom jenis wajib diisi.',
                'kode.required' => 'Kolom kode wajib diisi.',
                'category_id.required' => 'Kolom kategori wajib diisi.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $data = Jenis::find($id);
            $data->jenis = $request->input('jenis');
            $data->kode = $request->input('kode');
            $data->category_id = $request->input('category_id');
    
            if ($data->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('jenis.index')
                    ->with('success', 'Jenis information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return redirect()->route('jenis.index')
                    ->with('error', 'Jenis information update failed');
            }
        } 
    
        $data = Jenis::with('category')->where('id', $id)->get();
        $categories = Categories::all();
        $title = 'Update Jenis';
        UserLogs::logAction($request, 'Data Access', Auth::user()->id, 'Jenis ID:'.$id, '');
        return view('pages.jenis.update', compact('data', 'title', 'categories'));
    }

    public function delete(Request $request, $id)
    {
        $data = Jenis::find($id);

        if ($data) {
            $data->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

            return redirect()->route('jenis.index')
                ->with('success', 'Jenis deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('jenis.index')
                ->with('error', 'Jenis not found');
        }
    }
}
