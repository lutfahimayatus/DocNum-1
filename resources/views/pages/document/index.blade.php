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
                    <div class="input-group">
                        <select name="show_entries" class="input">
                            <option value="" selected>Show Entries</option>
                            <option value="5" {{ $showEntries == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $showEntries == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $showEntries == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $showEntries == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $showEntries == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <button type="submit">Search</button>
                    @if (Auth::user()->role === 'administrator')
                    <a href="{{ route('document.download.all')}}">
                        Download
                    </a>
                    @endif
                </div>
            </form>
            @if ($data->isEmpty())
                <div class="no-data-message">
                    <img src="{{ asset('assets/img/no-data.jpg')}}" alt="">
                    <h1 class="title">Tidak ada data.</h1>
                </div>
            @else
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
                        <a class="item-option" href="{{ route('document.update', encrypt($dokumen->id))}}">
                            <i class="bx bx-edit-alt"></i>
                            Edit
                        </a>
                        @endif
                        @if (Auth::user()->role === 'employee')
                        <a class="item-option" href="{{ route('employee.download', $dokumen->id)}}">
                            <i class="bx bx-download"></i>
                            Download 
                        </a>
                        <a class="item-option" href="{{ route('employee.upload', encrypt($dokumen->id))}}">
                            <i class="bx bx-upload"></i>
                            Upload 
                        </a>
                        <a class="item-option" href="{{ route('employee.document.update', encrypt($dokumen->id))}}">
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
                        <a href="{{ Auth::user()->role === 'administrator' ? route('document.detail', encrypt($dokumen->id)) : route('employee.detail', encrypt($dokumen->id)) }}">
                            <p>Detail</p>
                            <i class="bx bx-chevron-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            @endif 
            {{ $data->links('custom.pagination') }}
        </div>
    </div>
</div>

@endsection
