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
                        <th>Status</th>
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
                                @if($div->deleted_at)
                                    <span class="badge badge-danger">Disable</span>
                                @else
                                    <span class="badge badge-success">Enable</span>
                                @endif
                            </td>
                            <td>
                                @if(!$div->deleted_at)
                                <a href="{{ route('div.update', encrypt($div->id)) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('div.delete', encrypt($div->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @elseif($div->deleted_at)
                                <a href="{{ route('div.restore', encrypt($dt->id)) }}" class="table-button-success" onclick="return confirm('Are you sure?')">Restore</a>
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