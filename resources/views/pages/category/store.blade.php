@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('cat.create') }}">
            @csrf

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Kategori</label>
                <input type="text" name="desc" id="desc" class="input">
                @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <button type="submit">Add Category</button>
        </form>
    </div>
</div>

@endsection