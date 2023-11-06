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
        $data = Auth::user()->role === 'administrator' ? Document::paginate(5) : Document::where('users', Auth::user()->id)->paginate(5);
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
        return view('pages.document.generate', compact('title', 'jenis', 'kategori'));
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
}
