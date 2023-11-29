<div class="hero">
    <div class="navbar">
        <div class="navbar-container">
            <div class="title">
                <h4>{{ $title }}</h4>
            </div>
            <div class="profile"> 
                <a href="{{ route('profile', encrypt(Auth::user()->id) )}}"> 
                    <p>{{ Auth::user()->name }}</p>
                    <div class="wrapper">
                        @if (Auth::user()->foto_profile)
                            <img class="img" src="{{ asset('profile_photos/'.Auth::user()->foto_profile)}}">
                        @else
                            <img class="img" src="{{ asset('assets/img/default-profile.png')}}">
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="breadcrumb">
    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>