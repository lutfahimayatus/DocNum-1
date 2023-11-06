@extends('layout.auth')

@section('content')

    <div class="form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="nip">
                <label for="nip">NIP</label>
                <input type="number" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan Nomor Induk Pegawai" required>
            </div>
            <div class="password">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
                <i class="uil uil-eye-slash showHidePw"></i>
            </div>
            <br>
            <button type="submit">Masuk</button>
        </form>
        <div class="akun">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </div>
    </div>

@endsection