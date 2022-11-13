@section('title' , ' |  ' . translate('Login to account'))
@section('description' , '')

@extends('auth.layouts')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center login_register_page">
            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">

                        <div class="row justify-content-center">
                            <a href="/" title="{{ translate('name_website') }}">
                                <img src="<?php
                                $setting = \App\Model\Setting::where('key', 'logo')
                                    ->lang()->where('active', 1)->first();

                                if (isset($setting)) {
                                    echo $value = "/images/logo.png";
                                } else {
                                    echo $value = "/images/logo.png";
                                }
                                ?>" alt="{{ translate('name_website') }}"
                                     class="img-fluid logo_login_register">
                            </a>
                        </div>
                        <h3 class="title_login_register_page">{{ translate('Login to account') }}</h3>
                        @include('site.layout.message')
                        <form method="POST" action="{{ route('loginPost') }}" class="form_login_register">
                            @csrf
                            <?php $email = request('email');?>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="text" class="form-control " name="identity"
                                           value="{{ isset($email) ? $email : old('identity') }}"
                                           required autocomplete="identity"
                                           placeholder="{{translate('email')}}" autofocus>
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>

                            <div class=" row">

                                <div class=" col-12">
                                    <input type="password" class="form-control " name="password"
                                           required autocomplete="current-password" placeholder="{{translate('password')}}">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class=" col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                        class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label"
                                               for="customCheck1">  {{ translate('Password reminder') }}</label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class=" col-12">
                                    <button type="submit" class="btn btn_login_register">
                                        {{ translate('come in') }}
                                    </button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
