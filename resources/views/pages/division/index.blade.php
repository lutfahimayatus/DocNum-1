@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('div.create') }}" class="table-button">Tambah Divisi</a>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Divisi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $div)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $div->kode }}</td>
                            <td>{{ $div->divisi }}</td>
                            <td>
                                <a href="{{ route('div.update', encrypt($div->id)) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('div.delete', $div->id) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection