@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" method="POST" action="{{ route('user.update', $user[0]->id) }}">
            @csrf
            @method('POST')
            <div class="input-wrapper">
                <label class="input-label" for="inputField">Name</label>
                <input type="text" name="name" id="name" class="input" value="{{ $user[0]->name }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField">Email</label>
                <input type="email" name="email" id="email" class="input" value="{{ $user[0]->email }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">NIP</label>
                <input type="text" name="nip" id="nip" class="input"  value="{{ $user[0]->nip }}">
                @error('nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-wrapper">
                <label class="input-label" for="inputField"class="input-label" for="inputField">Nomor HP</label>
                <input type="number" name="nomor_hp" id="nomor_hp" class="input" value="{{ $user[0]->nomor_hp }}">
                @error('nomor_hp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="input-wrapper">
                <label class="input-label" for="role">Role</label>
                <select name="role" id="role" class="input">
                    <option value="administrator" {{ $user[0]->role == 'administrator' ? 'selected' : '' }}>Administrator</option>
                    <option value="employee" {{ $user[0]->role == 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>            

            <div class="input-wrapper">
                <label class="input-label" for="divisi_id">Divisi</label>
                <select name="divisi_id" id="divisi_id" class="input">
                    @php
                        $selectedDivisiId = $user[0]->divisi_id;
                        $hasSelectedOption = false;
                    @endphp
                    @foreach ($divisi as $data)
                        <option value="{{ $data->id }}" {{ $data->id == $selectedDivisiId ? 'selected' : '' }}>
                            {{ $data->divisi }}
                        </option>
                        @if ($data->id == $selectedDivisiId)
                            @php
                                $hasSelectedOption = true;
                            @endphp
                        @endif
                    @endforeach
                    @if (!$hasSelectedOption)
                        <option value="0" selected>No Division</option>
                    @endif
                </select>
                @error('divisi_id')
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