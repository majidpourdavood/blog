<?php
$setting = \App\Model\Setting::where('key', 'indexDescription')
    ->lang()->where('active', 1)->first();

if (isset($setting)) {
    $indexDescription = $setting->value;
} else {
    $indexDescription = ' ';
}
?>
@section('title' , ' | ' . translate('contact us'))
@section('description')  {{$indexDescription}}@stop
@section('meta')
    <meta property="og:title" content="{{translate('contact us')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description"
          content="{{$indexDescription}}"/>
    <meta property="og:image" content="{{asset('/images/yaremohajer.png')}}"/>
    <meta property="og:url" content="{{route('contactUs')}}"/>
    <meta property="og:site_name" content="{{config('app.name')}}"/>
    <meta property="og:title" content="{{translate('contact us')}}"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{ translate('id twitter')  }}"/>
    <meta name="twitter:title" content="{{translate('contact us')}}"/>

    <link rel="canonical" href="{{route('contactUs')}}">

    <meta name="twitter:description"
          content="{{$indexDescription}}"/>
    <meta name="twitter:image"
          content="{{asset('/images/yaremohajer.png')}}"/>
@stop


@extends('site.master')

@section('content')

    <div class="bg-layout-top">
        <div class="row col-12 site-title-header ">
            <h1 class="h1-layout">
                {{translate('contact us')}}
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center content-layout content">


            <div class="row col-12 list-contact-page justify-content-center">

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 item">
                    <div class="card">
                        <div class="icon">
                            <img src="<?php
                            $setting = \App\Model\Setting::where('key', 'icon_phone_contact')
                                ->where('active', 1)->lang()->first();

                            if (isset($setting)) {
                                echo $value = $setting->value;
                            } else {
                                echo $value = "/images/new/phone-contact.svg";
                            }
                            ?>" alt="">
                        </div>
                        <h3>

                            <?php
                            if (isset($phone)) {
                                echo $value = $phone->value;
                            } else {
                                echo $value = "";
                            }
                            ?>
                        </h3>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 item">
                    <div class="card">
                        <div class="icon">
                            <img src="<?php
                            $setting = \App\Model\Setting::where('key', 'icon_email_contact')
                                ->where('active', 1)->lang()->first();

                            if (isset($setting)) {
                                echo $value = $setting->value;
                            } else {
                                echo $value = "/images/new/email-contact.svg";
                            }
                            ?>" alt="">
                        </div>
                        <h3>

                            <?php
                            $setting = \App\Model\Setting::where('key', 'email')
                                ->where('active', 1)->lang()->first();

                            if (isset($setting)) {
                                echo $value = $setting->value;
                            } else {
                                echo $value = "";
                            }
                            ?>
                        </h3>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection


