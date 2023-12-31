<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\UserLogs;
use App\Models\Jenis;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $data = Categories::withTrashed()->get();
        $title = 'Data Kategori';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'DataKategori', '');
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
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('cat.index')->with('success', 'Berhasil menambahkan categories');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah kategori');
            }
        }

        $title = 'Tambah Kategori';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'TambahKategori', '');
        return view('pages.category.store', compact('title'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        if ($request->isMethod('post')) {
            $rules = [
                'desc' => 'required|string',
            ];
    
            $messages = [
                'desc.required' => 'Kolom kategori wajib diisi.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $data = Categories::find($id);
            $data->desc = $request->input('desc');
    
            if ($data->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('cat.index', $encryptedId)
                    ->with('success', 'Category information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('cat.update', $encryptedId)
                    ->with('error', 'Category information update failed');
            }
        } 
    
        $data = Categories::find($id);
        $title = 'Update Kategori';
        UserLogs::logAction($request, 'Data Access ID:'.$id, Auth::user()->id, 'UpdateCategory', '');
        return view('pages.category.update', compact('data', 'title'));
    }

    public function restore(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        $data = Categories::withTrashed()->find($id);
    
        if ($data) {
            if ($data->trashed()) {
                $data->restore();
                UserLogs::logAction($request, 'ATTEMPT RESTORE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('cat.index')->with('success', 'Categories restored successfully');
            } else {
                return redirect()->route('cat.index')->with('error', 'Categories is not soft-deleted');
            }
        } else {
            return redirect()->route('cat.index')->with('error', 'Categories not found');
        }
    }    

    public function delete(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        $data = Categories::find($id);

        if ($data) {
            $data->delete();
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

            return redirect()->route('cat.index')
                ->with('success', 'Category deleted successfully');
        } else {
            UserLogs::logAction($request, 'ATTEMPT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

            return redirect()->route('cat.index')
                ->with('error', 'Category not found');
        }
    }

    public function permanentDelete(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);

        $category = Categories::withTrashed()->find($id);

        if (!$category) {
            return redirect()->route('cat.index')->with('error', 'Category not found');
        }

        if (!$category->trashed()) {
            return redirect()->route('cat.index')->with('error', 'Category is not soft-deleted');
        }

        $relatedJenisCount = Jenis::where('category_id', $category->id)->count();

        if ($relatedJenisCount > 0) {
            return redirect()->route('cat.index')->with('error', 'Cannot permanently delete category. It has related records in Jenis.');
        }

        $category->forceDelete();

        UserLogs::logAction($request, 'ATTEMPT PERMANENT DELETE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

        return redirect()->route('cat.index')->with('success', 'Category permanently deleted successfully');
    }
}
