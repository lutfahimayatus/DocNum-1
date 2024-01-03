@extends('layout.app')

@section('content')

<div class="content">
    @if(Auth::user()->role === 'administrator')
    <div class="card-history">
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h1 class="angka">{{ $totalDoc }}</h1>
                        <p class="judul">Jumlah No. Surat</p>
                    </div>
                    <div class="card-img">
                        <img src="{{ asset('assets/img/mail.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h1 class="angka">{{ $totalDocNotConfirmed }}</h1>
                        <p class="judul">Jumlah Surat Belum Konfirmasi</p>
                    </div>
                    <div class="card-img">
                        <img src="{{ asset('assets/img/mail.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="main">
        @if(Auth::user()->role === 'administrator')
        <div class="table-responsive">
            <div style="display: flex; justify-content: space-between">
                <form action="{{ Auth::user()->role === 'administrator' ? route('searchs.documents') : route('search.documents') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="input" type="text" name="search" placeholder="Cari {{ Auth::user()->role === 'administrator' ? 'Dokumen/NIP' : 'Dokumen'}}">
                        </div>
                        <div class="input-group">
                            <button type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('document.download.all')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="daterange" id="daterange" class="input" autocomplete="off" />
                        </div>
                        <div class="input-group">
                            <button class="input" type="submit">
                                Download
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>No. Doc</th>
                        <th>Kode Dokumen</th>
                        <th>Nama Dokumen</th>
                        <th>User Log</th>
                        <th>Tgl Generate</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dt)
                        <tr>
                            <td>{{ $dt->jenis->category->desc}}</td>
                            <td>{{ $dt->document_number}}</td>
                            <td>{{ $dt->jenis->kode}}</td>
                            <td>{{ $dt->document}}</td>
                            <td>{{ $dt->user->nip ?? 'NIP Not Found'}} - {{ $dt->user->name ?? 'Name Not Found' }}</td>
                            <td>{{ $dt->created_at}}</td>
                            <td>
                                @if($dt->status == 'belum_upload')
                                    <span class="badge badge-warning">Belum Upload</span>
                                @elseif($dt->status == 'sudah_upload')
                                    <span class="badge badge-primary">Sudah Upload</span>
                                @elseif($dt->status == 'verifikasi_berkas')
                                    <span class="badge badge-primary">Verifikasi Berkas</span>
                                @elseif($dt->status == 'disposisi')
                                    <span class="badge badge-primary">Disposisi</span>
                                @elseif($dt->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>                            
                            <td>
                                <a href="{{ route('document.update', encrypt($dt->id)) }}" class="table-button-primary">Edit</a>
                                @if(!$dt->deleted_at)
                                <a href="{{ route('document.delete', encrypt($dt->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @endif
                                <a href="{{ route('document.download.single', $dt->id) }}" class="table-button-primary">Download</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>   
        @else
        <div class="document-wrapper">   
            <h4>Download Report</h4>
            <form action="{{ route('employee.download.report')}}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="daterange" id="daterange" class="input" autocomplete="off" />
                    </div>
                    <div class="input-group">
                        <button class="input" type="submit">
                            Download
                        </button>
                    </div>
                </div>
            </form>

            <h4>Search Documents</h4>
            <form action="{{ route('search.documents') }}" method="GET">
                <div class="form-group">
                    <div class="input-group">
                        <input class="input" type="text" name="search" placeholder="Cari {{ Auth::user()->role === 'administrator' ? 'Dokumen/NIP' : 'Dokumen'}}">
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
                    <div class="input-group">
                        <button type="submit">Search</button>
                    </div>
                </div>
            </form>
            <hr>
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
                            <p>Nomor Dokumen: <span id="document_number">{{ $dokumen->document_number}}</span><i class="fa-regular fa-copy" onclick="copyToClipboardElementP('document_number')"></i></p>
                            <p>Jenis        : <span>{{ $dokumen->jenis->jenis }}</span></p>
                        </div>
                        <div>
                            <p>Tanggal      : <span>{{ $dokumen->created_at }}</span></p>
                            @if($dokumen->status == 'belum_upload')
                                <p>status : <span class="badge badge-warning">Belum Upload</span> </p>
                            @elseif($dokumen->status == 'sudah_upload')
                                <p>status : <span class="badge badge-primary">Sudah Upload</span> </p>
                            @elseif($dokumen->status == 'verifikasi_berkas')
                                <p>status : <span class="badge badge-primary">Verifikasi Berkas</span> </p>
                            @elseif($dokumen->status == 'disposisi')
                                <p>status : <span class="badge badge-primary">Disposisi</span> </p>
                            @elseif($dokumen->status == 'selesai')
                                <p>status : <span class="badge badge-success">Selesai</span> </p>
                            @else
                                <p>Unknown status: <span>{{ $dokumen->status }}</span> </p>
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
        @endif
    </div>
</div>

@endsection
