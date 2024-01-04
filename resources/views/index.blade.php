@extends('layout.app')

@section('content')

    <div class="content">
        <div class="main">
            <div class="text-main">
                <h1>Selamat Datang di DocNum</h1>
                <p>Solusi Pintar untuk Manajemen Dokumen Anda!</p>
                <br>
                @if(Auth::user()->role == 'employee')
                <a class="button" href="{{route('employee.generate')}}">Buat Dokumen Sekarang</a>
                @endif
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
            <a style="font-size: 14px; display: flex; align-items: center; justify-content: space-between;" href="{{ route('user.index')}}">
                <span>Selengkapnya</span>
                <i style="margin-left: 5px;" class='bx bx-chevron-right'></i>
            </a>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h2 class="judul">Dokumen</h2>
                        <h2 class="angka">{{ $dataDoc }}</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="45" viewBox="0 0 64 60" fill="none">
                    <path d="M53.333 10H10.6663C7.73301 10 5.35967 12.25 5.35967 15L5.33301 45C5.33301 47.75 7.73301 50 10.6663 50H53.333C56.2663 50 58.6663 47.75 58.6663 45V15C58.6663 12.25 56.2663 10 53.333 10ZM53.333 20L31.9997 32.5L10.6663 20V15L31.9997 27.5L53.333 15V20Z" fill="black"/>
                    </svg>
                </div>
            </div>
            <a style="font-size: 14px; display: flex; align-items: center; justify-content: space-between;" href="{{ route('document.index')}}">
                <span>Selengkapnya</span>
                <i style="margin-left: 5px;" class='bx bx-chevron-right'></i>
            </a>        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="card-saperate">
                    <div class="card-info">
                        <h2 class="judul">Kategori</h2>
                        <h2 class="angka">{{ $dataCat }}</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top: 8px;" width="45" height="32" viewBox="0 0 48 50" fill="none">
                    <path d="M34.6264 0C42.735 0 47.25 4.45 47.25 12.075V37.9C47.25 45.65 42.735 50 34.6264 50H12.6263C4.64625 50 0 45.65 0 37.9V12.075C0 4.45 4.64625 0 12.6263 0H34.6264ZM13.335 34.35C12.5475 34.275 11.7863 34.625 11.3663 35.275C10.9462 35.9 10.9462 36.725 11.3663 37.375C11.7863 38 12.5475 38.375 13.335 38.275H33.915C34.9624 38.175 35.7525 37.3225 35.7525 36.325C35.7525 35.3 34.9624 34.45 33.915 34.35H13.335ZM33.915 22.9475H13.335C12.2036 22.9475 11.2875 23.825 11.2875 24.9C11.2875 25.975 12.2036 26.85 13.335 26.85H33.915C35.0438 26.85 35.9625 25.975 35.9625 24.9C35.9625 23.825 35.0438 22.9475 33.915 22.9475ZM21.1811 11.625H13.335V11.65C12.2036 11.65 11.2875 12.525 11.2875 13.6C11.2875 14.675 12.2036 15.55 13.335 15.55H21.1811C22.3125 15.55 23.2313 14.675 23.2313 13.5725C23.2313 12.5 22.3125 11.625 21.1811 11.625Z" fill="black"/>
                    </svg>
                </div>
            </div>
            <a style="font-size: 14px; display: flex; align-items: center; justify-content: space-between;" href="{{ route('cat.index')}}">
                <span>Selengkapnya</span>
                <i style="margin-left: 5px;" class='bx bx-chevron-right'></i>
            </a>        </div>
    </div>
    @else 

    <div class="card">
    <div class="card-container">
            <div class="card-content">
                <div class="info">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="50" viewBox="0 0 65 65" fill="none">
                    <path d="M45.5 48.75H16.25V19.5H35.75V16.25H16.25C14.4625 16.25 13 17.7125 13 19.5V48.75C13 50.5375 14.4625 52 16.25 52H45.5C47.2875 52 48.75 50.5375 48.75 48.75V29.25H45.5V48.75Z" fill="black"/>
                    <path d="M22.75 26V29.25H35.75H39V26H22.75Z" fill="black"/>
                    <path d="M22.75 32.5H39V35.75H22.75V32.5Z" fill="black"/>
                    <path d="M22.75 39H39V42.25H22.75V39Z" fill="black"/>
                    <path d="M48.75 9.75H45.5V16.25H39V19.5H45.5V26H48.75V19.5H55.25V16.25H48.75V9.75Z" fill="black"/>
                </svg>
                    <div class="card-info">
                        
                        <h5 class="judul-info">Nomor Dokumen Otomatis</h5>
                        <p style="font-size: 14px;">
                            menghasilkan format nomor dokumen yang sesuai dengan kebutuhan pengguna
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="info">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" viewBox="0 0 50 50" fill="none">
                    <path d="M43.75 25V34.375H6.25V9.375H17.1875V6.25H6.25C5.4212 6.25 4.62634 6.57924 4.04029 7.16529C3.45424 7.75134 3.125 8.5462 3.125 9.375V34.375C3.125 35.2038 3.45424 35.9987 4.04029 36.5847C4.62634 37.1708 5.4212 37.5 6.25 37.5H18.75V43.75H12.5V46.875H37.5V43.75H31.25V37.5H43.75C44.5788 37.5 45.3737 37.1708 45.9597 36.5847C46.5458 35.9987 46.875 35.2038 46.875 34.375V25H43.75ZM28.125 43.75H21.875V37.5H28.125V43.75Z" fill="black"/>
                    <path d="M28.125 28.1252H28.1094C27.7727 28.1217 27.4462 28.0095 27.1784 27.8053C26.9107 27.6012 26.716 27.3161 26.6234 26.9924L23.8219 17.1877H17.1875V14.0627H25C25.3396 14.0625 25.6701 14.173 25.9413 14.3774C26.2125 14.5818 26.4097 14.869 26.5031 15.1955L28.1812 21.0705L32.8828 5.78924C32.9843 5.47212 33.183 5.19503 33.4509 4.99729C33.7187 4.79955 34.0421 4.69122 34.375 4.68767C34.7042 4.68272 35.0263 4.78402 35.2934 4.97654C35.5605 5.16905 35.7584 5.44254 35.8578 5.75642L38.625 14.0627H46.875V17.1877H37.5C37.1719 17.1878 36.8522 17.0846 36.586 16.8927C36.3199 16.7009 36.1209 16.4302 36.0172 16.1189L34.4344 11.3689L29.6187 27.022C29.5205 27.3415 29.3224 27.621 29.0535 27.8196C28.7847 28.0181 28.4592 28.1252 28.125 28.1252Z" fill="black"/>
                </svg>
                    <div class="card-info">
                        
                        <h5 class="judul-info">Monitoring Secara Realtime</h5>
                        <p style="font-size: 14px;">
                            melacak dan memantau status dokumen secara langsung, memberikan visibilitas terhadap proses dokumen
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card-content">
                <div class="info">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" viewBox="0 0 24 24" fill="none">
                <path d="M13 3C10.6131 3 8.32387 3.94821 6.63604 5.63604C4.94821 7.32387 4 9.61305 4 12H1L4.89 15.89L4.96 16.03L9 12H6C6 8.13 9.13 5 13 5C16.87 5 20 8.13 20 12C20 15.87 16.87 19 13 19C11.07 19 9.32 18.21 8.06 16.94L6.64 18.36C7.47341 19.198 8.46449 19.8627 9.55606 20.3158C10.6476 20.769 11.8181 21.0015 13 21C15.3869 21 17.6761 20.0518 19.364 18.364C21.0518 16.6761 22 14.3869 22 12C22 9.61305 21.0518 7.32387 19.364 5.63604C17.6761 3.94821 15.3869 3 13 3ZM12 8V13L16.25 15.52L17.02 14.24L13.5 12.15V8H12Z" fill="black"/>
                </svg>
                    <div class="card-info">
                        <h5 class="judul-info">Riwayat Dokumen</h5>
                        <p style="font-size: 14px;">
                            mencatat riwayat dokumen yang telah di generate pengguna untuk memudahkan pengelolaan dokumen
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
