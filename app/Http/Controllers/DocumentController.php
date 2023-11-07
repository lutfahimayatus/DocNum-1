<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Categories;
use App\Models\Jenis;
use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $data = Auth::user()->role === 'administrator' ? Document::paginate(5) : Document::orderBy('created_at', 'desc')->where('users', Auth::user()->id)->paginate(5);
        $title = 'Data Dokumen';
        return view('pages.document.index', compact('title', 'data'));
    }

    public function generateDocument(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'document' => 'required|string',
                'jenis' => 'required|string',
            ];

            $messages = [
                'document.required' => 'Kolom judul wajib diisi.',
                'jenis.required' => 'Kolom jenis wajib diisi.',
            ];

            $this->validate($request, $rules, $messages);

            $jenisDokumen = Jenis::where('id', $request->input('jenis'))->first();
            if (!$jenisDokumen) {
                return back()->withInput()->with('error', 'Jenis dokumen tidak ditemukan');
            }

            $kode = $this->generateDocumentNumber($jenisDokumen);

            $data = Document::create([
                'users' => Auth::user()->id,
                'document_number' => $kode,
                'document' => $request->input('document'),
                'jenis_id' => $jenisDokumen->id,
                'file' => '',
                'status' => 'belum_upload',
            ]);

            if ($data) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('employee.document')->with('success', 'Berhasil menambahkan jenis');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal menambah jenis');
            }
        }

        $jenis = Jenis::all();
        $kategori = Categories::all();
        $title = 'Generate No. Dokumen';
        if (Auth::user()->divisi === '') {
            return view('pages.document.generate', compact('title', 'jenis', 'kategori'));
        } else {
            return back()->with('error', 'Lengkapi Profile Anda!');
        }
    }

    private function generateDocumentNumber($jenisDokumen)
    {
        $tanggalKelahiranBankJatim = new \DateTime('1961-08-17');
        $tanggalSekarang = new \DateTime();
        $umurBankJatim = $tanggalKelahiranBankJatim->diff($tanggalSekarang)->y;
        $umurFormatted = sprintf("%03d", $umurBankJatim);
    
        $totalDokumenJenis = Document::where('jenis_id', $jenisDokumen->id)->count();
        $sequence = $totalDokumenJenis + 1;
    
        $user = User::with('divisi')->where('id', Auth::user()->id)->first();
        $namaDivisi = $user->divisi->kode;
    
        $tahunBerjalan = date('Y');
    
        return $umurFormatted . '/' . $jenisDokumen->kode . '.' . $sequence . '/' . $namaDivisi . '/' . $tahunBerjalan;
    }
    
    public function detailDocument(Request $request, $id) 
    {
        $data = Document::with('jenis.category')->where('id', $id)->get();
        $title = 'Detail Dokumen';
        return view('pages.document.detail', compact('title','data'));
    }

    public function updateDocument(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'document' => 'required|string',
                'file_document' => 'mimes:pdf|max:2048',
            ];

            $messages = [
                'document.required' => 'Kolom judul wajib diisi.',
            ];

            $this->validate($request, $rules, $messages);

            $data = Document::find($id);
            $data->document = $request->input('document');
            $data->status = $request->input('status');

            if ($request->hasFile('file_document')) {
                $oldFileName = $data->file;
    
                $file = $request->file('file_document');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files'), $fileName);
                $data->file = $fileName;
                $data->status = 'sudah_upload';
    
                if ($oldFileName) {
                    $oldFilePath = public_path('files') . '/' . $oldFileName;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            if ($data->isDirty()) {
                if ($data->save()) {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect()->route(Auth::user()->role == 'administrator' ? 'document.update' : 'employee.document', $id)
                        ->with('success', 'Document information updated successfully');
                } else {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');
                    return redirect()->route(Auth::user()->role == 'administrator' ? 'document.update' : 'employee.document', $id)
                        ->with('error', 'Document information update failed');
                }
            } else {
                return redirect()->route('document.index')
                    ->with('error', 'No changes were made to the document information.');
            }
        }

        $title = 'Update Dokumen';
        $data = Document::find($id);
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'DataDocument', '');
        return view('pages.document.update', compact('title', 'data'));
    }

    public function downloadDocument($id)
    {
        $data = Document::find($id);

        if ($data) {
            $filePath = public_path('files') . '/' . $data->file;
    
            if (file_exists($filePath)) {
                return response()->download($filePath, $data->file);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Document not found.');
        }
    }

    public function uploadDocument(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'file_document' => 'required|mimes:pdf|max:2048',
            ];

            $this->validate($request, $rules);

            $data = Document::find($id);

            if ($request->hasFile('file_document')) {
                $oldFileName = $data->file;
    
                $file = $request->file('file_document');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files'), $fileName);
                $data->file = $fileName;
                $data->status = 'sudah_upload';
                
                if ($oldFileName) {
                    $oldFilePath = public_path('files') . '/' . $oldFileName;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            if ($data->save()) {
                UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->nip, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('employee.document', $id)
                    ->with('success', 'Document information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->nip, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('employee.document', $id)
                    ->with('error', 'Document information update failed');
            }
        }

        $title = 'Upload File Dokumen';
        $data = Document::find($id);
        UserLogs::logAction($request, 'Data Access', Auth::user()->nip, 'DataDocument', '');
        return view('pages.document.upload', compact('title', 'data'));
    }
}
