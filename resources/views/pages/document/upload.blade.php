@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('employee.upload', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
        
            <div class="input-wrapper">
                <label class="input-label" for="file">File Dokumen</label>
                <input class="input" type="file" id="file_document" name="file_document" value="{{ $data->file }}">
                @if($data->file)
                    <p>Current File: {{ $data->file }}</p>
                @endif
                @error('file_document')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit">Upload Dokumen</button>
        </form>
    </div>
</div>

@endsection