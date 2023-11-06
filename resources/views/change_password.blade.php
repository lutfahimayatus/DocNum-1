@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" action="{{ route('profile.change.password', $data->id) }}" method="POST">
            @csrf
            @method('POST')
            
            <div class="input-wrapper">
                <label class="input-label" for="old_password">Kata Sandi Lama</label>
                <div class="input-group">
                    <input class="input" type="password" id="old_password" name="old_password">
                    <i class="toggle-password-icon far fa-eye" data-target="old_password"></i>
                </div>
                @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="new_password">Kata Sandi Baru</label>
                <div class="input-group">
                    <input class="input" type="password" id="new_password" name="new_password">
                    <i class="toggle-password-icon far fa-eye" data-target="new_password"></i>
                </div>
                @error('new_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                <div class="input-group">
                    <input class="input" type="password" id="new_password_confirmation" name="new_password_confirmation">
                    <i class="toggle-password-icon far fa-eye" data-target="new_password_confirmation"></i>
                </div>
            </div>

            <button type="submit">Simpan</button>
        </form>
    </div>
</div>
@endsection
