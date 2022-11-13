@section('title' , ' | ' . translate('Edit item') )
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
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('Edit item') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')

            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Edit item') }}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel" action="{{ route('updateItem' , [ $item->id ]) }}"
                      method="post" >
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="row one">
                        <label for="title" class="col-12 control-label text-right">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ $item->title  }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>



                    <div class=" row one">
                        <label for="type" class="col-12 control-label text-right">{{ translate('type') }}</label>
                        <div class="col-12">
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="0" {{ $item->type == 0 ? 'selected' : '' }}>{{ translate('Question') }}</option>
                                <option value="1" {{ $item->type == 1 ? 'selected' : '' }}> {{ translate('Text') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class=" row one parent-body-admin">
                        <label for="bodyAdmin" class="col-12 control-label text-right">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="bodyAdmin" class="form-control" id="bodyAdmin" rows="7"
                              placeholder="{{ translate('Short description') }}">{{ $item->description }}</textarea>
                        </div>
                    </div>

                    <div class=" row one parent-body-description">
                        <label for="description" class="col-12 control-label text-right">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="description" class="form-control" id="description" rows="7"
                              placeholder="{{ translate('Short description') }}">{{ $item->description }}</textarea>
                        </div>
                    </div>

                    <div class="row one">
                        <label for="active" class="col-12 col-form-label text-right">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" id="active">
                                <option value="0" {{ $item->active == 0 ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                                <option value="1" {{  $item->active == 1 ? 'selected' : '' }}> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>





                    <div class="row one">
                        <label class="col-12 control-label"></label>
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
            // alert(residencyType);
            if (type == 1) {
                $('.parent-body-admin').show();
                $('.parent-body-description').hide();

            } else {
                $('.parent-body-admin').hide();
                $('.parent-body-description').show();
            }
        });

        $(function () {
            // $('#residencyType').change(function () {
            var type = $('#type').find('option:selected').val();

            // alert(residencyType);
            if (type == 1) {
                $('.parent-body-admin').show();
                $('.parent-body-description').hide();

            } else {
                $('.parent-body-admin').hide();
                $('.parent-body-description').show();  }
            // });
        });

    </script>
@endsection
