@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('div.create') }}">
            @csrf

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kode</label>
                <input placeholder="Masukkan Kode Divisi" type="text" name="kode" id="kode" class="input">
                @error('kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Divisi</label>
                <input placeholder="Masukkan Nama Divisi" type="text" name="divisi" id="divisi" class="input">
                @error('divisi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Tambah Divisi</button>
        </form>
    </div>
</div>

@endsection