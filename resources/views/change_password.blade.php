@extends('layout.app')

@section('content')
<style>
    .form-wrapper {
    display: flex;
}

.form-image {
    flex-shrink: 0;
    margin-right: 20px;
}

.form-image img {
    max-width: 100%;
    height: auto;
}

.form-inputs {
    flex-grow: 1;
}

</style>
<div class="content">
    <div class="main">
        <form class="form-wrapper" action="{{ route('profile.change.password', encrypt($data->id)) }}" method="POST">
            @csrf
            @method('POST')

            <!-- Add an image to the left of the form -->
            <div class="form-image">
                <img style="width: 340px;" src="{{ asset('assets/img/logo-beranda.png')}}" alt="Image Description">
            </div>

            <!-- Input fields container -->
            <div style="margin-top: 60px;" class="form-inputs">
                <div class="input-wrapper">
                    <label class="input-label" for="old_password">Kata Sandi Lama</label>
                    <div class="input-group">
                        <input class="input" placeholder="Masukkan Kata Sandi Lama" type="password" id="old_password" name="old_password">
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
                        <input class="input" placeholder="Masukkan Kata Sandi Baru" type="password" id="new_password" name="new_password">
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
                        <input class="input" placeholder="Konfirmasi Kata Sandi Baru" type="password" id="new_password_confirmation" name="new_password_confirmation">
                        <i class="toggle-password-icon far fa-eye" data-target="new_password_confirmation"></i>
                    </div>
                </div>

                <button style="width: 200px; float: right;"  type="submit">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
