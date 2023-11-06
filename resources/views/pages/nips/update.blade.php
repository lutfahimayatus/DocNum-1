@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('nip.update', $nips->id) }}">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">NIP</label>
                <input type="text" name="nip" id="nip" class="input" value="{{ $nips->nip }}">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Add NIP</button>
        </form>
    </div>
</div>

@endsection