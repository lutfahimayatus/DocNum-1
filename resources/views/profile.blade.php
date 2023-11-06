@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" action="{{ route('profile', $user->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Name</label>
                <input class="input" type="text" id="name" name="name" value="{{ $user->name }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-wrapper">
                <label class="input-label" for="inputField">NIP</label>
                <input class="input" type="text" id="nip" name="nip" value="{{ $user->nip }}">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Role</label>
                <select class="input" name="role" id="role">
                    <option value="{{ $user->role }}" selected>{{ $user->role }}</option>
                    <option value="administrator">Administrator</option>
                    <option value="employee">Employee</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit">Simpan</button>
        </form>
    </div>
</div>

@endsection