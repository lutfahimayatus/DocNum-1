@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('jenis.create') }}" class="table-button">Tambah Jenis</a>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th width="50px">Jenis</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th width="800px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $dt)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $dt->kode }}</td>
                            <td>{{ $dt->jenis }}</td>
                            <td>{{ $dt->category->desc ?? '' }}</td>
                            <td>
                                @if($dt->deleted_at)
                                    <span class="badge badge-danger">Disable</span>
                                @else
                                    <span class="badge badge-success">Enable</span>
                                @endif
                            </td>
                            <td>
                                @if(!$dt->deleted_at)
                                <a href="{{ route('jenis.update', encrypt($dt->id)) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('jenis.delete', encrypt($dt->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @elseif($dt->deleted_at)
                                <a href="{{ route('jenis.restore', encrypt($dt->id)) }}" class="table-button-success" onclick="return confirm('Are you sure?')">Restore</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection