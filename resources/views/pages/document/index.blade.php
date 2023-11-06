@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="document-wrapper">
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
                    <a class="item-option" href="#">
                        <i class="bx bx-download"></i>
                        Download 
                    </a>
                    <a class="item-option" href="#">
                        <i class="bx bx-upload"></i>
                        Upload 
                    </a>
                    <a class="item-option" href="#">
                        <i class="bx bx-edit-alt"></i>
                        Edit
                    </a>
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
