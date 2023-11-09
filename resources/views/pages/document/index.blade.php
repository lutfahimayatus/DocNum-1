@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="document-wrapper">   
            <form action="{{ Auth::user()->role === 'administrator' ? route('searchs.documents') : route('search.documents') }}" method="GET">
                <div class="form-group">
                    <div class="input-group">
                        <input class="input" type="text" name="search" placeholder="Cari Dokumen/NIP">
                    </div>
                    <div class="input-group">
                        <select class="input" name="jenis">
                            <option value="" selected>Select Jenis</option>
                            @foreach ($jenis as $jenisOption)
                                <option value="{{ $jenisOption->id }}">{{ $jenisOption->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit">Search</button>
                </div>
            </form>
            @if ($data)
            @foreach ($data as $dokumen)
            <div class="card-document">
                <div class="topbar">
                    <h1>{{ $dokumen->document }}</h1>
                    <a href="#" class="menu-toggle" data-id="{{ $dokumen->id }}">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
                <div id="menu-{{ $dokumen->id }}" class="menu" style="display: none;">
                    @if (Auth::user()->role === 'administrator')
                    <a class="item-option" href="{{ route('document.download.single', $dokumen->id)}}">
                        <i class="bx bx-download"></i>
                        Download 
                    </a>
                    <a class="item-option" href="{{ route('document.update', $dokumen->id)}}">
                        <i class="bx bx-edit-alt"></i>
                        Edit
                    </a>
                    @endif
                    @if (Auth::user()->role === 'employee')
                    <a class="item-option" href="{{ route('employee.download', $dokumen->id)}}">
                        <i class="bx bx-download"></i>
                        Download 
                    </a>
                    <a class="item-option" href="{{ route('employee.upload', $dokumen->id)}}">
                        <i class="bx bx-upload"></i>
                        Upload 
                    </a>
                    <a class="item-option" href="{{ route('employee.document.update', $dokumen->id)}}">
                        <i class="bx bx-edit-alt"></i>
                        Edit
                    </a>
                    @endif
                </div>
                <hr>
                <div class="content-document">
                    <div>
                        <p>Nomor Dokumen: <span>{{ $dokumen->document_number}}</span></p>
                        <p>Jenis        : <span>{{ $dokumen->jenis->jenis }}</span></p>
                    </div>
                    <div>
                        <p>Tanggal      : <span>{{ $dokumen->created_at }}</span></p>
                        @if ($dokumen->status == 'belum_upload')
                            <p>status : <span class="belum-upload">Belum Upload</span></p>
                        @elseif ($dokumen->status == 'sudah_upload')
                            <p>status : <span class="sudah-upload">Sudah Upload</span></p>
                        @elseif ($dokumen->status == 'verifikasi_berkas')
                            <p>status : <span class="verifikasi-berkas">Verifikasi Berkas</span></p>
                        @elseif ($dokumen->status == 'disposisi')
                            <p>status : <span class="disposisi">Disposisi</span></p>
                        @elseif ($dokumen->status == 'selesai')
                            <p>status : <span class="selesai">Selesai</span></p>
                        @else
                            <p>Unknown status: <span>{{ $dokumen->status }}</span></p>
                        @endif
                    </div>
                </div>
                <div class="content-footer">
                    <a href="{{ Auth::user()->role === 'administrator' ? route('document.detail', $dokumen->id) : route('employee.detail', $dokumen->id) }}">
                        <p>Detail</p>
                        <i class="bx bx-chevron-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
            {{ $data->links('custom.pagination') }}
            @else
            <h1 class="title">Tidak ada data.</h1>
            @endif 
        </div>
    </div>
</div>

@endsection
