@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('jenis.create') }}" class="table-button">Add Jenis</a>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $dt)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $dt->kode }}</td>
                            <td>{{ $dt->jenis }}</td>
                            <td>{{ $dt->category->desc }}</td>
                            <td>
                                <a href="{{ route('jenis.update', $dt->id) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('jenis.delete', $dt->id) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links('custom.pagination') }}
        </div>        
    </div>
</div>

@endsection