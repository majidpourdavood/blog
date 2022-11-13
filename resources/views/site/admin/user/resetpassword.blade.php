@section('title' , ' | ' .  translate('change password') )
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
                            <li class="breadcrumb-item"><a class="btn" href="#">{{ translate('change password') }}  </a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('change password') }}  </h1>

                <form class="form_panel" method="POST" action="{{ route('users.updatePassword', [ $user->id]) }}"
                      aria-label="{{ __('Reset Password') }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}


                    <div class="form-group row">
                        <label for="password" class="col-md-2 col-form-label text-md-right">{{ translate('password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="text"
                                   class="form-control"
                                   name="password">

                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="password-confirm"
                               class="col-md-2 col-form-label text-md-right">{{ translate('Repeat password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="text" class="form-control"
                                   name="password_confirmation">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <button class="btn btn-info" type="button" onclick="generate();">
                            {{ translate('Create a password with high security') }}
                        </button>
                    </div>
                    <div class="col-12 row mt-4">
                        <button type="submit" class="btn btn-info btn-block mt-4">{{ translate('submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')


    <script>

        var arr = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

        function generate () {
            var randomLetter="";
            for (i = 0; i < 10; i++) {
                randomLetter += arr[Math.floor(arr.length * Math.random())];

                //console.log(randomLetter);
            }

            var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            // return retVal;

            $('#password').val(retVal);
            $('#password-confirm').val(retVal);

        }
    </script>
@endsection
