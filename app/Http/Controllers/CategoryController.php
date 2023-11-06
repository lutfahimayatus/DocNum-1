<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Categories::paginate(10);
        $title = 'Data Kategori';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'DataKategori', '');
        return view('pages.category.index', compact('data', 'title'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'desc' => 'required|string',
            ];

            $messages = [
                'desc.required' => 'Kolom kategori wajib diisi.',
            ];

            $this->validate($request, $rules, $messages);
    
            $addCategories = Categories::create([
                'desc' => $request->input('desc'),
            ]);

            if ($addCategories) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('cat.index')->with('success', 'Berhasil menambahkan categories');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah kategori');
            }
        }

        $title = 'Tambah Kategori';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->nip, 'TambahKategori', '');
        return view('pages.category.store', compact('title'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'desc' => 'required|string',
            ];
    
            $messages = [
                'desc.required' => 'Kolom kategori wajib diisi.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $data = Categories::find($id);
            $data->category = $request->input('desc');
    
            if ($data->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('cat.update', $id)
                    ->with('success', 'Category information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('cat.update', $id)
                    ->with('error', 'Category information update failed');
            }
        } 
    
        $data = Categories::find($id);
        $title = 'Perbarui Kategori';
        UserLogs::logAction($request, 'Data Access ID:'.$id, Auth::user()->nip, 'UpdateCategory', '');
        return view('pages.category.update', compact('data', 'title'));
    }

    public function delete(Request $request, $id)
    {
        $data = Categories::find($id);

        if ($data) {
            $data->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

            return redirect()->route('cat.index')
                ->with('success', 'Category deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('cat.index')
                ->with('error', 'Category not found');
        }
    }
}