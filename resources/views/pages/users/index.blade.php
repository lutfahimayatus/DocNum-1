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
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nip }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('user.update', $user->id) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('user.delete', $user->id) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection