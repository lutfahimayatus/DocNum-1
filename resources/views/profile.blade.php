@extends('layout.app')

@section('content')

<div class="content">
    <div class="main">
        <form class="form-wrapper" action="{{ route('profile', encrypt(Auth::user()->id)) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="profile-wrapper">
                <div class="picture-wrapper">
                    <div class="profile-case">
                        @if ($user[0]->foto_profile)
                            <img class="foto-profile" src="{{ asset('profile_photos/'.$user[0]->foto_profile)}}">
                        @else
                            <img class="foto-profile" src="{{ asset('assets/img/default-profile.png')}}">
                        @endif
                    </div>
                    <div class="input-wrapper profile-case">
                        <label class="input-label" for="profile_photo"></label>
                        <input type="file" id="profile_photo" name="profile_photo">
                        @error('profile_photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="detail-wrapper">
                    <div class="input-wrapper">
                        <label class="input-label" for="inputField">Nama Lengkap</label>
                        <input class="input" type="text" id="name" name="name" value="{{ $user[0]->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-wrapper">
                        <label class="input-label" for="inputField">No Telpon</label>
                        <input class="input" type="number" id="nomor_hp" name="nomor_hp" value="{{ $user[0]->nomor_hp }}">
                        @error('nomor_hp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-wrapper">
                        <label class="input-label" for="inputField">NIP</label>
                        <input class="input" type="text" id="nip" name="nip" value="{{ $user[0]->nip }}">
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-wrapper">
                        <label class="input-label" for="inputField">Email</label>
                        <input class="input" type="text" id="email" name="email" value="{{ $user[0]->email }}">
                        @error('email')
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
                </div>
            </div>
            <button type="submit">Simpan</button>
        </form>
    </div>
</div>

@endsection