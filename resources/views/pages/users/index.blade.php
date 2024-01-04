@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('user.create') }}" class="table-button">Add User</a>
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
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
                                @if(!$user->deleted_at)
                                <a href="{{ route('user.update', encrypt($user->id)) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('user.delete', encrypt($user->id)) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Soft Delete</a>
                                @elseif($user->deleted_at)
                                <a href="{{ route('user.restore', encrypt($user->id)) }}" class="table-button-success" onclick="return confirm('Are you sure?')">Restore</a>
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