@section('title' , ' | ' . translate('Create file'))
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

@endsection
@section('content')

    <style>
        .error {
            color: red;
        }
    </style>
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#"> {{translate('Create file')}}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                @if( isset($model) && isset($model->files) && count($model->files) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover auto-index" id="myTable">
                            <thead class="thead-light">
                            <tr>
                                <?php $i = 1;  ?>
                                <th width="5%">{{ translate('Row') }}</th>
                                <th width="15%">{{ translate('Title') }}</th>
                                <th width="10%">{{translate('file')}}</th>
                                <th>{{ translate('the date of creation') }}</th>
                                <th width="35%">{{ translate('Settings') }}</th>
                            </tr>
                            </thead>
                            <tbody class="row_position">
                            @foreach($model->files as $model)
                                <tr id="<?php echo $model->id ?>">
                                    <td>   {{$i++}}</td>
                                    <td>{{ $model->title }}</td>

                                    <td>

                                        <a class="btn btn-danger" href="{{ $model->file}}" download>
                                            {{translate('Download')}}
                                        </a>

                                    </td>

                                    <td>{{ $model->created_at }}</td>
                                    <td>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <form action="{{ route('deleteFile'  , [ $model->id]) }}"
                                                      method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <div class="btn_group ">
                                                        <a href="{{ route('editFile' , [ $model->id]) }}"
                                                           title="{{ translate('Edit') }}" class="btn btn-outline-warning">
                                                            <i class="fas fa-edit"></i></a>

                                                        <button type="submit" class="btn  btn-outline-danger"
                                                                onclick="return  confirm('{{translate('Do you want to delete the file?')}}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif

                <h1>{{ translate('Create file') }}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('storeFile') }}" method="post"
                      enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}

                    <input type="hidden" name="fileable_id" class="form-control" id="fileable_id"
                           value="{{ request('fileable_id') }}" placeholder="">

                    <input type="hidden" name="fileable_type" class="form-control" id="fileable_type"
                           value="{{ request('fileable_type') }}" placeholder="">

                    <div class=" row one">
                        <label for="title" class="col-12 control-label text-right">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title') }}" placeholder="{{ translate('Title') }} ">
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
                                                {{--{{   $employment->active == $optionProperty->value ? 'selected' : '' }}--}}

                                        >{{$optionProperty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif



                    <div class=" row one">
                        <label for="type" class="col-12 control-label text-right">{{ translate('type') }}</label>
                        <div class="col-12">
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="0">{{translate('Main')}}</option>
                                <option value="1"> {{translate('back ground')}}</option>
                                <option value="2"> {{translate('Image gallery')}}</option>
                                <option value="3">{{translate('Video gallery')}}</option>
                                <option value="9" > {{translate('link')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="file col-12 row one">


                    </div>
                    <div class=" row one">
                        <label class="col-12 control-label text-right"></label>
                        <div class="col-12">

                            <button type="submit" class="btn btn-primary">
                                {{ translate('Store') }}
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
    <script src=" {{ asset('js/jquery.validate.min.js') }}"></script>

    <script>


        $('#type').change(function () {
            var type = $(this).val();
            var value = "";
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
            var value = "";
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
