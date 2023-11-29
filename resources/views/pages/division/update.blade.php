@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('div.update', encrypt($data->id)) }}">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kode</label>
                <input type="text" name="kode" id="kode" class="input" value="{{ $data->kode }}">
                @error('kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Divisi</label>
                <input type="text" name="divisi" id="divisi" class="input" value="{{ $data->divisi }}">
                @error('divisi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Update</button>
        </form>
    </div>
</div>

@endsection