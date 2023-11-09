<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <p>
                        {{ session('success') }}
                    </p>
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            @if(session('message'))
                <div class="alert alert-primary">
                    <p>
                        {{ session('message') }}
                    </p>
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <p>
                        {{ session('error') }}
                    </p>
                    <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
        </div>            

        @yield('content')
    </div>
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>

</body>
</html>