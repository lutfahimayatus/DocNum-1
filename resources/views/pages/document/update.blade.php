@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="form-wrapper">
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Judul Dokumen</label>
                <input disabled type="text" class="input" value="{{ $data[0]->document }}">
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Nomor Dokumen</label>
                <input disabled type="text" class="input" value="{{ $data[0]->document_number }}">
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Kategori</label>
                <input disabled type="text" class="input" value="{{ $data[0]->jenis->category->desc }}">
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Jenis</label>
                <input disabled type="text" class="input" value="{{ $data[0]->jenis->jenis }}">
            </div>    
        </div>
    </div>
</div>

@endsection