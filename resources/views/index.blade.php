@extends('layout.app')

@section('content')

    <div class="content">
        <div class="main">
            <div class="text-main">
                <h1>Selamat Datang di DocNum</h1>
                <h3>Solusi Pintar untuk Manajemen Dokumen Anda!</h3>
                <br>
                <a class="button" href="{{ Auth::user()->role === 'administrator' ? route('document.index') : route('employee.generate')}}">Buat Dokumen Sekarang</a>
            </div>
            <div class="img-main">
                <img src="{{ asset('assets/img/logo-beranda.png')}}" alt="">
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'administrator')
    <div class="card">
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h2 class="judul">Pengguna</h2>
                        <h2 class="angka">{{ $dataUser }}</h2>
                    </div>
                    <img src="{{ asset('assets/img/users.svg')}}" alt="">
                </div>
            </div>
            <a href="{{ route('user.index')}}">Selengkapnya <i class='bx bx-chevron-right' ></i></a>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h2 class="judul">Dokumen</h2>
                        <h2 class="angka">{{ $dataDoc }}</h2>
                    </div>
                    <img src="{{ asset('assets/img/Document.svg')}}" alt="">
                </div>
            </div>
            <a href="{{ route('user.index')}}">Selengkapnya <i class='bx bx-chevron-right' ></i></a>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h2 class="judul">Kategori</h2>
                        <h2 class="angka">{{ $dataCat }}</h2>
                    </div>
                    <img src="{{ asset('assets/img/Document.svg')}}" alt="">
                </div>
            </div>
            <a href="{{ route('cat.index')}}">Selengkapnya <i class='bx bx-chevron-right' ></i></a>
        </div>
    </div>
    @else 

    <div class="card">
        <div class="card-container">
            <div class="card-content">
                <div class="info">
                    <i class='bx bx-add-to-queue'></i>
                    <div class="card-info">
                        <h2 class="judul-info">Nomor Dokumen Otomatis</h2>
                        <p>
                            menghasilkan format nomor dokumen yang sesuai dengan kebutuhan pengguna
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="info">
                    <i class='bx bx-desktop'></i>
                    <div class="card-info">
                        <h2 class="judul-info">Monitoring Secara Realtime</h2>
                        <p>
                            melacak dan memantau status dokumen secara langsung, memberikan visibilitas terhadap proses dokumen
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="info">
                    <i class='bx bx-message-minus'></i>
                    <div class="card-info">
                        <h2 class="judul-info">Log Activity</h2>
                        <p>
                            meningkatkan transparansi dan akuntabilitas dalam pengelolaan dokumen
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
    <br>
    <br>

@endsection
