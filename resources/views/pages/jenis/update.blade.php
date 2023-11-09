@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('jenis.update', $data[0]->id) }}">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <label class="input-label" for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="input">
                    <option value="" selected>Pilih Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $data[0]->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->desc }}
                        </option>
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
                <input type="text" name="jenis" id="jenis" class="input" value="{{ $data[0]->jenis }}">
                @error('jenis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kode</label>
                <input type="text" name="kode" id="kode" class="input" value="{{ $data[0]->kode }}">
                @error('kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Add Jenis</button>
        </form>
    </div>
</div>

@endsection