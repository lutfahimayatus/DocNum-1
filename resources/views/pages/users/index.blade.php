@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('user.create') }}" class="table-button">Tambah User</a>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nip }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if($user->deleted_at)
                                    <span class="badge badge-danger">Disable</span>
                                @else
                                    <span class="badge badge-success">Enable</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.update', encrypt($user->id)) }}" class="table-button-primary">Edit</a>
                                @if(!$user->deleted_at)
                                <a href="{{ route('user.delete', encrypt($user->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @endif
                                <a href="{{ route('user.restore', encrypt($user->id)) }}" class="table-button-success" onclick="return confirm('Are you sure?')">Restore</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection