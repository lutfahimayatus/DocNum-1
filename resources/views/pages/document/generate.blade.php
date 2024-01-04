@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('employee.generate') }}">
            @csrf
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Kategori</label>
                <select name="category" id="category" class="input" onchange="filterJenisOptions()">
                    <option value="" selected>Pilih Kategori Dokumen</option>
                    @foreach ($kategori as $data)
                    <option value="{{ $data->id }}">{{ $data->desc }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Jenis</label>
                <select name="jenis" id="jenis" class="input" disabled>
                    <option value="" selected>Pilih Jenis Dokumen</option>
                    @foreach ($jenis as $data)
                        <option value="{{ $data->id }}" data-category="{{ $data->category_id }}">{{ $data->jenis }}</option>
                    @endforeach
                </select>                
                @error('jenis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField" class="input-label" for="inputField">Judul</label>
                <input type="text" name="document" id="document" class="input" placeholder="Masukkan Judul Dokumen">
                @error('document')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit">Generate</button>
        </form>
    </div>
</div>

@endsection