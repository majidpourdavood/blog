@section('title' , ' |  ' .  translate('File editing') )
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/last.css') }}">

@endsection
@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('File editing') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')

            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('File editing') }}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel" action="{{ route('updateFile' , [ $file->id ]) }}"
                      enctype="multipart/form-data"   method="post" >
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="row one">
                        <label for="title" class="col-12 control-label text-right">{{ translate('Title') }}</label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ $file->title  }}" placeholder="{{ translate('Title') }}">
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="type" class="col-12 control-label text-right">نوع</label>
                        <div class="col-12">
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="0" {{ $file->type == 0 ? 'selected' : '' }}>{{translate('Main')}}</option>
                                <option value="1" {{ $file->type == 1 ? 'selected' : '' }}> {{translate('back ground')}}</option>
                                <option value="2" {{ $file->type == 2 ? 'selected' : '' }}> {{translate('Image gallery')}}ر</option>
                                <option value="3" {{ $file->type == 3 ? 'selected' : '' }}> {{translate('Video gallery')}}</option>
                                <option value="9" {{ $file->type == 9 ? 'selected' : '' }}> {{translate('link')}}</option>
                            </select>
                        </div>
                    </div>

                    <?php
                    $active = \App\Model\Property::where('key', 'active')
                        ->lang()->where('model', 'App\Model\File')->first();
                    ?>
                    @if(isset($active->optionProperties))
                        <div class=" row one">
                            <label for="active"
                                   class="col-12 control-label text-right">
                                {{ translate('status') }}
                            </label>
                            <div class="col-12 ">
                                <select id="active" name="active"
                                        class="form-control ">
                                    @foreach($active->optionProperties as $optionProperty)
                                        <option value="{{$optionProperty->value}}"
                                                {{   $file->active == $optionProperty->value ? 'selected' : '' }}

                                        >{{$optionProperty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="file col-12 row one">


                    </div>



                    <div class="row one">
                        <label class="col-12 control-label text-right"></label>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                {{ translate('submit') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/select2.min.js') }}"></script>

    <script>


        $('#type').change(function () {
            var type = $(this).val();
            var value = "<?php echo $file->file;  ?>";
            if (type != 9) {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="file" class="control-label">فایل </label>\n' +
                    '<input type="file" class="form-control" name="file" id="file" value=""> </div>' +
                    '<img src="'+value+'" width="150" alt=""></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="file" class="control-label">توضیحات </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="file" id="file" >'+value+'</textarea> </div></div> ');
            }
        });

        $(function () {
            var type = $('#type').find('option:selected').val();
            var value = "<?php echo $file->file;  ?>";
            if (type != 9) {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="file" class="control-label">فایل </label>\n' +
                    '<input type="file" class="form-control" name="file" id="file" value=""> </div>' +
                    '<img src="'+value+'" width="150" alt=""></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="file" class="control-label">توضیحات </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="file" id="file" >'+value+'</textarea> </div></div> ');
            }
        });


    </script>
@endsection
