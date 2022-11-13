@section('title' , ' | ' . translate('Edit settings'))
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
                            <li class="breadcrumb-item"><a class="btn " href="#"> {{translate('Edit settings')}}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1> {{translate('Edit settings')}}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel" action="{{ route('setting.update' , [ $setting->id ]) }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}


                    <div class="row one">
                        <label for="title" class=" col-12 control-label text-right">{{ translate('Title') }} </label>
                        <div class=" col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ $setting->title  }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="key" class=" col-12 control-label text-right">{{translate('Key to English')}} </label>
                        <div class=" col-12">
                            <input type="text" name="key" class="form-control" id="key"
                                   value="{{ $setting->key  }}" placeholder="{{translate('Key to English')}} ">
                        </div>
                    </div>


                    @include('site.admin.blocks.language' , [ 'model' =>  $setting])

                    <div class="row one">
                        <label for="active" class="col-12 col-form-label text-right">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" id="">
                                <option value="0" {{ $setting->active == 0 ? 'selected' : '' }}>{{ translate('Inactive') }} </option>
                                <option value="1" {{  $setting->active == 1 ? 'selected' : '' }}> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="type" class="control-label">{{ translate('type') }}</label>
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="text" {{ $setting->type == "text" ? 'selected' : '' }}>{{ translate('Text') }}</option>
                                <option value="file" {{ $setting->type == "file" ? 'selected' : '' }}>{{ translate('file') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="file col-12 row one">


                    </div>

                    <div class="row  col-12 one justify-content-end ">

                        <button type="submit" class="btn btn-primary ">
                            {{ translate('submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/select2.min.js') }}"></script>

    <script>

        $('#tags').select2({
            tags: true,
            // tokenSeparators: [",", " "],
            createSearchChoice: function (term, data) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                    return {
                        id: term,
                        text: term
                    };
                }
            },
            multiple: true,
            language: "fa",
            dir: "rtl",
        });

        $('#type').change(function () {
            var type = $(this).val();
            // alert(residencyType);
            var value = ' <?php echo $setting->value;  ?> ';
            // alert(residencyType);
            if (type == "file") {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('file') }} </label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div>' +
                    '<img src="'+value+'" width="150" alt=""></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="value" id="value" >'+value+'</textarea> </div></div> ');
            }
        });

        $(function () {
            var type = $('#type').find('option:selected').val();
            var value = '<?php echo $setting->value;  ?> ';
            if (type == "file") {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('file') }} </label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div>' +
                    '<img src="'+value+'" width="150" alt=""></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="value" id="value" >'+value+'</textarea> </div></div> ');
            }
        });
    </script>
@endsection
