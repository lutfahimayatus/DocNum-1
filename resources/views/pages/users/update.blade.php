@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('POST')
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Name</label>
                <input type="text" name="name" id="name" class="input" value="{{ $user->name }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">NIP</label>
                <input type="text" name="nip" id="nip" class="input"  value="{{ $user->nip }}">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Role</label>
                <select name="role" id="role" class="input">
                    <option  value="{{ $user->role }}"  selected>{{ $user->role }}</option>
                    <option value="administrator">Administrator</option>
                    <option value="employee">Employee</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

@endsection