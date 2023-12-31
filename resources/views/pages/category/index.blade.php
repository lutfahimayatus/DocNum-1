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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $cat)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $cat->desc }}</td>
                            <td>
                                @if($cat->deleted_at)
                                    <span class="badge badge-danger">Disable</span>
                                @else
                                    <span class="badge badge-success">Enable</span>
                                @endif
                            </td>
                            <td>
                                @if(!$cat->deleted_at)
                                <a href="{{ route('cat.update', encrypt($cat->id)) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('cat.delete', encrypt($cat->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @elseif($cat->deleted_at)
                                <a href="{{ route('cat.restore', encrypt($cat->id)) }}" class="table-button-success" onclick="return confirm('Are you sure?')">Restore</a>
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