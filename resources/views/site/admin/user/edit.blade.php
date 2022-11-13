@section('title' , ' | ' .  translate('Edit user') )
@section('description' , '')
@extends('site.admin.panel')
@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="btn">{{ translate('Edit user') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Edit user') }}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel  "
                      action="{{ route('user.update' , [ $user->id ]) }}"
                      method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="row one">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="name">{{ translate('name') }}</label>
                                    <input type="text" id="name" name="name" value="{{$user->name}}"
                                           placeholder="" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="lastName">{{translate('last name')}}</label>
                                    <input type="text" id="lastName" name="lastName" value="{{$user->lastName}}"
                                           placeholder="" class="form-control"/>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="email">{{ translate('email') }}</label>
                                    <input type="email" id="email" name="email" value="{{$user->email}}"
                                           placeholder="" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="role_id" class="control-label">    {{ translate('Roles') }} </label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="0">{{translate('has_not')}}</option>
                                        @foreach(\App\Role::all() as $role)
                                            <option
                                                value="{{ $role->id }}" {{ $user->hasRole($role->slug) ? 'selected' : '' }}>{{ $role->name }}
                                                - {{ $role->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">

                            <div class="form-row">
                                <label for="active" class="">
                                    {{ translate('status') }}
                                </label>
                                <select name="active" class="form-control" id="active">
                                    <option value="0" {{$user->active == 0  ? 'selected' : '' }}> {{ translate('Inactive') }}</option>
                                    <option value="1" {{$user->active == 1  ? 'selected' : '' }}>  {{ translate('active') }}</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <label for="password" class="col-12">{{ translate('password') }}</label>

                            <div class="col-12">
                                <input id="password" type="text" placeholder="{{old('password')}}"
                                       value="" class="form-control"
                                       name="password">

                            </div>
                        </div>


                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                            <label class="col-12"></label>
                            <button class="btn btn-info" type="button" onclick="generate();">
                                {{translate('Create a password with high security')}}
                            </button>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 half ">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="image">{{ translate('Image') }}</label>

                                    <input type="file" id="image" name="image" value=""
                                           class="form-control "/>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4  item">
                          <div class="image-user-admin">
                            <img src="<?php
                            if (isset($user->image)) {
                                echo $user->image;
                            } else {
                                echo '/images/default_avatar.png';
                            }
                            ?>" class="img-fluid  " alt="{{$user->name}} {{$user->lastName}}">

                          </div>
                        </div>


                        <div class="form-group row col-12">
                            <label for="body" class="col-12">{{ translate('Description') }} </label>
                            <div class="col-12">
                           <textarea rows="5" class="form-control" name="body" id="bodyAdmin"
                                     placeholder="{{ translate('Description') }}">{{ old('body', $user->body)  }}</textarea>
                            </div>
                        </div>

                    </div>


                    <div class="col-12 row ">
                        <button type="submit" class="btn btn-info btn-block">{{ translate('submit') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        var arr = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

        function generate() {
            var randomLetter = "";
            for (i = 0; i < 10; i++) {
                randomLetter += arr[Math.floor(arr.length * Math.random())];
            }

            var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }

            $('#password').val(retVal);

        }


    </script>
@endsection
