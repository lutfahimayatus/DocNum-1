@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('jenis.create') }}">
            @csrf

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Kategori</label>
                <select name="category_id" id="category_id" class="input">
                    <option value="" selected disabled>Pilih Kategori</option>
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->desc }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Jenis</label>
                <input placeholder="Masukkan Jenis Dokumen" type="text" name="jenis" id="jenis" class="input">
                @error('jenis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kode</label>
                <input placeholder="Masukkan Kode Jenis" type="text" name="kode" id="kode" class="input">
                @error('kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Tambah Jenis</button>
        </form>
    </div>
</div>

@endsection