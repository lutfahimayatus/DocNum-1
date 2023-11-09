@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="form-wrapper">

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Judul Dokumen</label>
                <input disabled type="text" class="input" value="{{ $data[0]->document }}">
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Nomor Dokumen</label>
                <div class="input-group">
                    <input class="input" type="text" id="document_number" value="{{ $data[0]->document_number }}" readonly>
                    <i class="fa-regular fa-copy" onclick="copyToClipboard('document_number')"></i>
                </div>    
                <div id="copy-success-message" class="alert alert-success" style="display: none; margin-top: 5px;">
                    Nomor Dokumen Berhasil Disalin
                </div>            
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Kategori</label>
                <input disabled type="text" class="input" value="{{ $data[0]->jenis->category->desc }}">
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Jenis</label>
                <input disabled type="text" class="input" value="{{ $data[0]->jenis->jenis }}">
            </div>

            <div class="timeline-wrapper">
                <div class="timeline">
                    <div class="stage @if(in_array($data[0]->status, ['belum_upload'])) stage-done @else stage-done @endif">
                        <div class="circle"></div>
                        <div class="description">Belum Upload</div>
                    </div>
                    <div class="stage @if(in_array($data[0]->status, ['sudah_upload', 'verifikasi_berkas', 'disposisi', 'selesai'])) stage-done @else stage-pending @endif">
                        <div class="circle"></div>
                        <div class="description">Sudah Upload</div>
                    </div>
                    <div class="stage @if(in_array($data[0]->status, ['verifikasi_berkas', 'disposisi', 'selesai'])) stage-done @else stage-pending @endif">
                        <div class="circle"></div>
                        <div class="description">Verifikasi Dokumen</div>
                    </div>
                    <div class="stage @if(in_array($data[0]->status, ['disposisi', 'selesai'])) stage-done @else stage-pending @endif">
                        <div class="circle"></div>
                        <div class="description">Disposisi</div>
                    </div>
                    <div class="stage @if(in_array($data[0]->status, ['selesai'])) stage-done @else stage-pending @endif">
                        <div class="circle"></div>
                        <div class="description">Selesai</div>
                    </div>
                </div>
            </div>    
            <br>
            <br>
            <a href="{{Auth::user()->role === 'administrator' ? route('document.index') : route('employee.document') }}">
                <span class="text">Kembali</span>
            </a>  

        </div>
    </div>
</div>

@endsection