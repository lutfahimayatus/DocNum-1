@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('user.create') }}">
            @csrf
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Name</label>
                <input type="text" name="name" id="name" class="input">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">NIP</label>
                <input type="text" name="nip" id="nip" class="input">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Role</label>
                <select name="role" id="role" class="input">
                    <option value="" selected>Pilih Role</option>
                    <option value="administrator">Administrator</option>
                    <option value="employee">Employee</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Password</label>
                <input type="password" name="password" id="password" class="input">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="input">
            </div>
        
            <button type="submit">Add User</button>
        </form>
    </div>
</div>

@endsection