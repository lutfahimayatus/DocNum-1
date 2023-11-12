<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | {{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    
    @include('layout.partials.sidebar')

    <section class="home-section">

        @include('layout.partials.navbar')

        @yield('content')
        
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );

        $(function() {
        // Initialize the date range picker
        $('#daterange').daterangepicker({
            opens: 'left', // Adjust the position of the date picker
            locale: {
                format: 'YYYY-MM-DD', // Adjust the date format as needed
            }
        });
    });
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>