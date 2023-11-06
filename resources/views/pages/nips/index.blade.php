@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <div class="table-responsive">
            <a href="{{ route('nip.create') }}" class="table-button">Add NIP</a>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nips as $index => $nip)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ $nip->nip }}</td>
                            <td>
                                <a href="{{ route('nip.update', $nip->id) }}" class="table-button-primary">Edit</a>
                                <a href="{{ route('nip.delete', $nip->id) }}" class="table-button-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $nips->links('custom.pagination') }}
        </div>        
    </div>
</div>

@endsection