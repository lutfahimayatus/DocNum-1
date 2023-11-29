@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ Auth::user()->role == 'administrator' ? route('document.update', encrypt($data->id)) : route('employee.document.update', encrypt($data->id)) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Nomor Dokumen</label>
                <input type="text" name="document_number" id="document_number" class="input" value="{{ $data->document_number }}" disabled>
                @error('document_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Judul Dokumen</label>
                <input type="text" name="document" id="document" class="input" value="{{ $data->document }}">
                @error('document')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="file">File Dokumen</label>
                <input class="input" type="file" id="file_document" name="file_document" value="{{ $data->file }}">
                @if($data->file)
                    <p>Current File: {{ $data->file }}</p>
                @endif
                @error('file_document')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            @if (Auth::user()->role === 'administrator')
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Status</label>
                <select name="status" id="status" class="input" {{ $data->status === 'belum_upload' ? 'disabled' : ''}}>
                    @if ($data->status === 'belum_upload')
                        <option value="belum_upload" selected>Belum Upload</option>
                    @endif
                    @if ($data->status === 'sudah_upload')
                        <option value="sudah_upload" disabled selected>Sudah Upload</option>
                        <option value="verifikasi_berkas">Verifikasi Berkas</option>
                    @endif
                    @if ($data->status === 'verifikasi_berkas')
                        <option value="verifikasi_berkas" disabled selected>Verifikasi Berkas</option>
                        <option value="disposisi">Disposisi</option>
                    @endif
                    @if ($data->status === 'disposisi')
                        <option value="disposisi" disabled selected>Disposisi</option>
                        <option value="selesai">Selesai</option>
                    @endif
                    @if ($data->status === 'selesai')
                        <option value="selesai" selected>Selesai</option>
                    @endif
                </select>                
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            @endif

            <button type="submit">Update</button>
        </form>
    </div>
</div>

@endsection