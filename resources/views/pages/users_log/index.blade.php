@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <form action="{{ route('log.download.all')}}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <select id="select2" class="input" name="users">
                            <option></option>
                            @foreach($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="text" name="daterange" id="daterange" class="input" autocomplete="off" />
                    </div>
                    <div class="input-group">
                        <button class="input" type="submit">
                            Download
                        </button>
                    </div>
                </div>
            </form>
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
                                <td>{{ $ul->request }}</td>
                                <td>{{ $ul->response }}</td>
                                <td>{{ $ul->user->nip ?? 'NIP Not Found' }} - {{ $ul->user->name ?? 'User Not Found' }}</td>
                                <td>{{ $ul->ip }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
