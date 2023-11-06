@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('cat.update', $data->id) }}">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kategori</label>
                <input type="text" name="desc" id="desc" class="input" value="{{ $data->desc }}">
                @error('desc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Tambah Kategori</button>
        </form>
    </div>
</div>

@endsection