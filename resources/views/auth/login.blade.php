@extends('layout.auth')

@section('content')

    <div class="form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-wrapper">
                <div class="input-group">
                    <label for="nip">NIP</label>
                    <input type="number" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan Nomor Induk Pegawai" required>
                </div>
            </div>
            <div class="input-wrapper">
                <label for="password">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
                    <i class="toggle-password-icon far fa-eye" data-target="password"></i>
                </div>
            </div>
            <br>
            <button type="submit">Masuk</button>
        </form>
        <div class="akun">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </div>
    </div>

@endsection