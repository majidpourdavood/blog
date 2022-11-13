
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <title> {{config('app.name')}} @yield('title')</title>
    <meta name="description" content="@yield('description')">

    <meta name="handheldfriendly" content="true"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge, chrome=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    {{--    <link rel="manifest" href="/manifest.json">--}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">

    <?php
    if (isset($versionCss)) {
        $versionCss = $versionCss->value;
    } else {
        $versionCss = '1.56';
    }
    ?>

    @if(app()->getLocale() == "en")
        <link rel="stylesheet" href="/css/app-en.css?v=<?php echo $versionCss;?>">
        <link rel="stylesheet" href="/css/custom-en.css?v=<?php echo $versionCss;?>">
    @else
        <link rel="stylesheet" href="/css/app.css?v=<?php echo $versionCss;?>">

    @endif

    <link rel="stylesheet" href="{{asset('css/css-font/fontawesome-all.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')
    @yield('css')

    <?php
    if (isset($enamad)) {
        echo $value = $enamad->value;
    } else {
        echo $value = '';
    }
    ?>

    <meta name="google-site-verification" content="<?php

    if (isset($googleSiteVerification)) {
        echo $value = $googleSiteVerification->value;
    } else {
        echo $value = '';
    }
    ?>"/>

    <meta name="msvalidate.01" content="<?php
    if (isset($bingSiteVerification)) {
        echo $value = $bingSiteVerification->value;
    } else {
        echo $value = '';
    }
    ?>"/>

    <?php
    if (isset($googletagmanager)) {
        echo $value = $googletagmanager->value;
    } else {
        echo $value = "";
    }
    ?>
    <?php
    if (isset($scriptHead)) {
        echo $value = $scriptHead->value;
    } else {
        echo $value = '';
    }
    ?>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>

    @if(app()->getLocale() == "fa")
    <script src='https://www.google.com/recaptcha/api.js?hl=fa' async defer></script>
    @else
        <script src='https://www.google.com/recaptcha/api.js?hl=en' async defer></script>
    @endif

</head>
