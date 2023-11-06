<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <title>Bank Jatim | {{ $title }}</title> 
</head>
<body>
    
    <div class="container">
        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset('assets/img/logo.png')}}" alt="">
            </div>
        </div>
        <hr>
        <div class="alert-container">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>X</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('message'))
                <div class="alert alert-primary">
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>&times;</span>
                    </button>
                    {{ session('message') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif
        </div>            

        @yield('content')
    </div>
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>

</body>
</html>