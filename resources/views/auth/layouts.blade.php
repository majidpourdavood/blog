<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <title> {{ translate('name_website') }} @yield('title')</title>
    <meta name="description" content="@yield('description')"/>
    <meta name="author" content="{{ translate('name_website') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    if (isset($versionCss)) {
        $versionCss = $versionCss->value;
    } else {
        $versionCss = '1.56';
    }
    ?>

    <link rel="stylesheet" href="/css/app.css?v=<?php echo $versionCss;?>">
    <link rel="stylesheet" href="{{asset('css/css-font/fontawesome-all.css')}}">
    <link rel="stylesheet" href="/css/login.css?v=<?php echo $versionCss;?>">

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src=" {{ asset('js/sweetalert.min.js') }}"></script>

</head>

<body>
@include('sweet::alert')

<main class="content_login_register">
    @yield('content')
</main>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@yield('script')
</body>
</html>
