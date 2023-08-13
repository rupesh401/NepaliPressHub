<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content>
    <meta name="author" content>

    <title> {{ $appTitle }} | @yield('title')</title>

    <link href='{{ "$pF/news/assets/css/bootstrap.min.css" }}' rel="stylesheet">
    <link href='{{ "$pF/news/assets/css/font-awesome.min.css" }}' rel="stylesheet">
    <link href='{{ "$pF/news/assets/css/magnific-popup.css" }}' rel="stylesheet">
    <link href='{{ "$pF/news/assets/css/owl.carousel.css" }}' rel="stylesheet">
    <link href='{{ "$pF/news/assets/css/subscribe-better.css" }}' rel="stylesheet">
    <link href='{{ "$pF/news/assets/css/main.css" }}' rel="stylesheet">
    <link id="preset" rel="stylesheet" type="text/css" href='{{ "$pF/news/assets/css/presets/preset1.css" }}'>
    <link href='{{ "$pF/news/assets/css/responsive.css" }}' rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700" rel="stylesheet"
        type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href='{{ ("$pF/news/assets/images/ico/favicon.ico") }}'>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href='{{ ("$pF/news/assets/images/ico/apple-touch-icon-144-precomposed.png") }}'>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href='{{ ("$pF/news/assets/images/ico/apple-touch-icon-114-precomposed.png") }}'>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href='{{ ("$pF/news/assets/images/ico/apple-touch-icon-72-precomposed.png") }}'>
    <link rel="apple-touch-icon-precomposed" href='{{ ("$pF/news/assets/images/ico/apple-touch-icon-57-precomposed.png") }}'>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</head>