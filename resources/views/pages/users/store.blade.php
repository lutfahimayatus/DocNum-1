@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('user.create') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Nama Lengkap</label>
                <input placeholder="Masukkan Nama Lengkap" type="text" name="name" id="name" class="input">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Email</label>
                <input placeholder="Masukkan Alamat Email" type="email" name="email" id="email" class="input">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Nomor Induk Pegawai</label>
                <input placeholder="Masukkan Nomor Induk Pegawai" type="number" name="nip" id="nip" class="input">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Nomor Telepon</label>
                <input placeholder="Masukkan Nomor Telepon" type="number" name="nomor_hp" id="nomor_hp" class="input">
                @error('nomor_hp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Role</label>
                <select name="role" id="role" class="input">
                    <option value="" selected>Pilih Role</option>
                    <option value="administrator">Administrator</option>
                    <option value="employee">Employee</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Divisi</label>
                <select name="divisi_id" id="divisi_id" class="input">
                    <option value="" selected>Pilih Divisi</option>
                    @foreach ($divisi as $data)
                        <option value="{{ $data->id }}">{{ $data->divisi }}</option>
                    @endforeach
                </select>                
                @error('divisi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Kata Sandi</label>
                <div class="input-group">
                    <input placeholder="Masukkan Kata Sandi" type="password" name="password" id="password" class="input">
                    <i class="toggle-password-icon far fa-eye" data-target="password"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <input  placeholder="Konfirmasi Kata Sandi" type="password" name="password_confirmation" id="password_confirmation" class="input">
                    <i class="toggle-password-icon far fa-eye" data-target="password_confirmation"></i>
                </div>
            </div>
        
            <button type="submit">Tambah User</button>
        </form>
    </div>
</div>

@endsection