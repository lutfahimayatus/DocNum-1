<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Categories;
use App\Models\Jenis;
use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;

class DocumentController extends Controller
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
        $data = Auth::user()->role === 'administrator' ? Document::with('jenis', 'user')->get() : Document::orderBy('created_at', 'desc')->where('users', Auth::user()->nip)->paginate(5);
        $title = 'Data Dokumen';
        $totalDoc = Document::count();
        $jenis = Jenis::all();
        $showEntries = $request->input('show_entries', 5);
        //dd($data);
        return view('pages.document.index', compact('totalDoc', 'title', 'data', 'jenis', 'showEntries'));
    }

    public function search(Request $request)
    {
        $jenis = Jenis::all();
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $showEntries = $request->input('show_entries', 5);

        $query = Document::query();

        if (Auth::user()->role === 'employee') {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('users', Auth::user()->nip)
                        ->where('document', 'like', '%' . $search . '%');
            });
        } elseif (Auth::user()->role === 'administrator') {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('document', 'like', '%' . $search . '%')
                        ->orWhere('users', 'like', '%' . $search . '%');
            });
        }

        if (!empty($jenisId)) {
            $query->where('jenis_id', $jenisId);
        }

        $data = $query->paginate($showEntries);

        $totalDoc = Document::count();
        $title = 'Data Dokumen';
        return view('pages.document.index', compact('totalDoc', 'title', 'data', 'jenis', 'showEntries'));
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

            $user_nip = Auth::user()->nip;
            $data = Document::create([
                'users' => $user_nip,
                'document_number' => $kode,
                'document' => $request->input('document'),
                'jenis_id' => $jenisDokumen->id,
                'file' => '',
                'status' => 'belum_upload',
            ]);

            if ($data) {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                return redirect()->route('employee.document')->with('success', 'Berhasil generate surat');
            } else {
                UserLogs::logAction($request, 'ATTEMPT CREATE OPERATION', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return back()->withInput()->with('error', 'Gagal generate surat');
            }
        }

        $jenis = Jenis::all();
        $kategori = Categories::all();
        $title = 'Generate No. Dokumen';
        $user = User::find(Auth::user()->id);
        if ($user->divisi_id != '') {
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
    
    public function detailDocument(Request $request, $encryptedId) 
    {
        $id = $this->decryptIfEncrypted($encryptedId);
        $data = Document::with('jenis.category')->where('id', $id)->get();
        $title = 'Detail Dokumen';
        return view('pages.document.detail', compact('title','data'));
    }

    public function updateDocument(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);
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
            } else {
                if ($request->has('status') && $request->input('status') !== '') {
                    $data->status = $request->input('status');
                }
            }

            if ($data->isDirty()) {
                if ($data->save()) {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                    return redirect()->route(Auth::user()->role == 'administrator' ? 'document.update' : 'employee.document', $id)
                        ->with('success', 'Document information updated successfully');
                } else {
                    UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
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
        UserLogs::logAction($request, 'Data Access', Auth::user()->id, 'DataDocument', '');
        return view('pages.document.update', compact('title', 'data'));
    }

    public function downloadDocument(Request $request,$id)
    {
        $data = Document::find($id);
    
        if ($data) {
            $filePath = public_path('files') . '/' . $data->file;
    
            try {
                if (file_exists($filePath)) {
                    return response()->download($filePath, $data->file);
                    UserLogs::logAction($request, 'ATTEMPT DOWNLOAD DOCUMENT', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');
                } else {
                    return redirect()->back()->with('error', 'File not found.');
                    UserLogs::logAction($request, 'ATTEMPT DOWNLOAD DOCUMENT', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                }
            } catch (\Exception $e) {
                UserLogs::logAction($request, 'ATTEMPT DOWNLOAD DOCUMENT', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
                return redirect()->back()->with('error', 'An error occurred while downloading the file.');
            }
        } else {
            UserLogs::logAction($request, 'ATTEMPT DOWNLOAD DOCUMENT', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');
            return redirect()->back()->with('error', 'Document not found.');
        }
    }
    
    public function uploadDocument(Request $request, $encryptedId)
    {
        $id = $this->decryptIfEncrypted($encryptedId);
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
                UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->id, '', '{"isStatus": true, "pesan": "Sukses"}');

                return redirect()->route('employee.document', $id)
                    ->with('success', 'Document information updated successfully');
            } else {
                UserLogs::logAction($request, 'ATTEMPT UPDATE DOCUMENT', Auth::user()->id, '', '{"isStatus": false, "pesan": "Gagal"}');

                return redirect()->route('employee.document', $id)
                    ->with('error', 'Document information update failed');
            }
        }

        $title = 'Upload File Dokumen';
        $data = Document::find($id);
        UserLogs::logAction($request, 'Data Access', Auth::user()->id, 'DataDocument', '');
        return view('pages.document.upload', compact('title', 'data'));
    }

    public function downloadAllDocuments(Request $request)
    {
        try {
            $dateRange = explode(' - ', $request->input('daterange'));

            if (count($dateRange) !== 2) {
                return redirect()->back()->with('error', 'Invalid date range format.');
            }

            $startDate = Carbon::parse($dateRange[0]);
            $endDate = Carbon::parse($dateRange[1]);

            $documents = Document::with('jenis', 'user')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            if ($documents->isEmpty()) {
                return redirect()->back()->with('error', 'No documents found within the specified date range.');
            }

            return Excel::download(new DocumentsExport($documents), $startDate . '-' . $endDate . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function downloadEmployeeDocuments(Request $request)
    {
        try {
            $dateRange = explode(' - ', $request->input('daterange'));

            if (count($dateRange) !== 2) {
                return redirect()->back()->with('error', 'Invalid date range format.');
            }

            $startDate = Carbon::parse($dateRange[0]);
            $endDate = Carbon::parse($dateRange[1]);

            $documents = Document::with('jenis', 'user')
                ->where('users', Auth::user()->nip)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            if ($documents->isEmpty()) {
                return redirect()->back()->with('error', 'No documents found within the specified date range.');
            }

            return Excel::download(new DocumentsExport($documents), $startDate . '-' . $endDate . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
