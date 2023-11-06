<div class="hero">
    <div class="navbar">
        <div class="navbar-container">
            <div class="search">
                <input type="text" placeholder="Search">
            </div>
            <div class="profile"> 
                <a href="{{ route('profile', Auth::user()->id)}}"> 
                    <p>{{ Auth::user()->name }}</p>
                    <img src="{{ asset('assets/img/profile.png') }}" alt="">
                </a>
            </div>
        </div>
        <div class="breadcrumb">
            <div>
                <h2>{{ $title }}</h2>
            </div>
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
    </div>
</div>