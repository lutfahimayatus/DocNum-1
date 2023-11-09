@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <table id="myTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Log Action</th>
                        <th>Datetime</th>
                        <th>Request</th>
                        <th>Response</th>
                        <th>User</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersLog as $index => $ul)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $ul->log }}</td>
                            <td>{{ $ul->created_at }}</td>
                            <td>{{ $ul->request}}</td>
                            <td>{{ $ul->response }}</td>
                            <td>{{ $ul->user->nip }} - {{ $ul->user->name }}</td>
                            <td>{{ $ul->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection