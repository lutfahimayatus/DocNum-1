@extends('layout.auth')

@section('content')

    <div class="form">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            @method('POST')

            <div class="input-wrapper">
                <div class="input-group">
                    <label for="nip">NIP</label>
                    <input type="number" id="nip" name="nip" placeholder="Enter Employee ID" required>
                    @error('nip')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="input-wrapper">
                <div class="input-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="employee">Employee</option>
                        <option value="administrator">Administrator</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="input-wrapper">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <i class="toggle-password-icon far fa-eye" data-target="password"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="input-wrapper">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                    <i class="toggle-password-icon far fa-eye" data-target="password_confirmation"></i>
                </div>
            </div>

            <br>

            <button type="submit">Register</button>
        </form>

        <div class="akun">
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>

    </div>

@endsection