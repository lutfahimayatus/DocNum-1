@extends('layout.auth')

@section('content')

    <div class="form">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            @method('POST')
            <div class="nip">
                <label for="username">NIP</label>
                <input type="number" id="nip" name="nip" placeholder="Masukkan Nomor Induk Pegawai" required>
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="role">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="employee">Employee</option>
                    <option value="administrator">Administrator</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="password">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <i class="uil uil-eye-slash showHidePw"></i>
            </div>
            <div class="password">
                <label for="password">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Masukkan Ulang Kata Sandi" required>
            </div>
            <br>
            <input class="button-input" type="submit" value="Daftar">
        </form>
        <div class="akun">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>

@endsection