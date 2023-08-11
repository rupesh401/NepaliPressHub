<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsNews Admin : Dashboard</title>


    <link rel="shortcut icon" href="https://placehold.it/64.png/000/fff">

    <link rel="apple-touch-icon" sizes="144x144" href="https://placehold.it/144.png/000/fff">

    <link rel="apple-touch-icon" sizes="114x114" href="https://placehold.it/114.png/000/fff">

    <link rel="apple-touch-icon" sizes="72x72" href="https://placehold.it/72.png/000/fff">

    <link rel="apple-touch-icon" sizes="57x57" href="https://placehold.it/57.png/000/fff">
    <link href="{{ ("$pF/dash/assets/css/lib/chartist/chartist.min.css") }}" rel="stylesheet">

    <link href="{{ ("$pF/dash/assets/css/lib/owl.carousel.min.css") }}" rel="stylesheet" />
    <link href="{{ ("$pF/dash/assets/css/lib/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ ("$pF/dash/assets/css/lib/themify-icons.css") }}" rel="stylesheet">
    <link href="{{ ("$pF/dash/assets/css/lib/menubar/sidebar.css") }}" rel="stylesheet">
    <link href="{{ ("$pF/dash/assets/css/lib/bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ ("$pF/dash/assets/css/lib/unix.css") }}" rel="stylesheet">
    <link href="{{ ("$pF/dash/assets/css/style.css") }}" rel="stylesheet">
</head>

<body class="@if (request()->getRequestUri() == '/login') bg-primary @else body @endif">
    <div id="app">
        @if(Auth::check())
            <mainapps :user="{{ Auth::user() }}"></mainapps>
        @else
            <mainapps :user="false"></mainapps>
        @endif
    </div>
</body>
    
    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>

    <script src='{{ ("$pF/js/app.js") }}'></script>

    <script src="{{ ("$pF/dash/assets/js/lib/jquery.min.js") }}"></script>

    <script src="{{ ("$pF/dash/assets/js/lib/jquery.nanoscroller.min.js") }}"></script>

    <script src="{{ ("$pF/dash/assets/js/lib/menubar/sidebar.js") }}"></script>

    <script src="{{ ("$pF/dash/assets/js/lib/bootstrap.min.js") }}"></script>

    <script src="{{ ("$pF/dash/assets/js/lib/circle-progress/circle-progress.min.js") }}"></script>
    <script src="{{ ("$pF/dash/assets/js/lib/circle-progress/circle-progress-init.js") }}"></script>
    <script src="{{ ("$pF/dash/assets/js/lib/sparklinechart/jquery.sparkline.min.js") }}"></script>
    <script src="{{ ("$pF/dash/assets/js/lib/sparklinechart/sparkline.init.js") }}"></script>
    <script src="{{ ("$pF/dash/assets/js/scripts.js") }}"></script>
</html>
