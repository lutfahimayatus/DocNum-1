@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('cat.create') }}" class="table-button">Tambah Kategori</a>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $cat)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $cat->desc }}</td>
                            <td>
                                <a href="{{ route('cat.update', $cat->id) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('cat.delete', $cat->id) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection