<?php
$setting = \App\Model\Setting::where('key', 'indexDescription')
    ->lang()->where('active', 1)->first();

if (isset($setting)) {
    $indexDescription = $setting->value;
} else {
    $indexDescription = ' ';
}
?>
@section('title' , ' | ' . translate('about us'))
@section('description')  {{$indexDescription}}@stop

@section('meta')
    <meta property="og:title" content="{{ translate('about us')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="{{$indexDescription}}"/>
    <meta property="og:image" content="{{asset('/images/logo.png')}}"/>
    <meta property="og:url" content="{{route('aboutUs')}}"/>
    <meta property="og:site_name" content="{{config('app.name')}}"/>
    <meta property="og:title" content="{{ translate('about us')}}"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{ translate('id twitter')  }}"/>
    <meta name="twitter:title" content="{{ translate('about us')}}"/>
    <meta name="twitter:description" content="{{$indexDescription}}"/>
    <meta name="twitter:image"
          content="{{asset('/images/logo.png')}}"/>

    <link rel="canonical" href="{{route('aboutUs')}}">

@stop

@extends('site.master')

@section('content')
    <div class="bg-layout-top" >
        <div class="row col-12 site-title-header ">
            <h1 class="h1-layout">
                {{ translate('about us')}}
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center content-layout content">

            <div class="row col-12 top-page-about">

                <?php
                $locale = app()->getLocale();
                $setting = \App\Model\Setting::where('key', 'about us')
                    ->where('active', 1)->lang()->first();

                if (isset($setting)) {
                     $value = $setting->value;
                } else {
                     $value = "";
                }
                ?>
{!! $value !!}

            </div>


        </div>

    </div>

@endsection


@section('script')
    <script>

    </script>
@endsection

