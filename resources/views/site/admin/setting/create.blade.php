@section('title' , ' | ' . translate('Create a setting'))
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
                            <li class="breadcrumb-item"><a class="btn " href="#"> {{translate('Create a setting')}}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1> {{ translate('Create a setting')  }}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('setting.store') }}" method="post"
                      enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}

                    <div class=" row one">
                        <label for="title" class=" col-12 control-label text-right">{{ translate('Title') }} </label>
                        <div class=" col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title') }}" placeholder="{{ translate('Title') }}">
                        </div>
                    </div>

                    <div class=" row one">
                        <label for="key" class=" col-12 control-label text-right">{{translate('Key to English')}} </label>
                        <div class=" col-12">
                            <input type="text" name="key" class="form-control" id="key"
                                   value="{{ old('key') }}" placeholder="{{translate('Key to English')}} ">
                        </div>
                    </div>


                    @include('site.admin.blocks.language' , [ 'model' =>  ''])

                    <div class=" row one">
                        <label for="active" class="col-12 col-form-label text-md-right">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" value="{{ old('active') }}" id="">
                                <option value="0"> {{ translate('Inactive') }}</option>
                                <option value="1"> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="type" class="control-label">{{ translate('type') }}</label>
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="text">{{ translate('Text') }}</option>
                                <option value="file">{{ translate('file') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="file col-12 row one">


                    </div>

                    <div class="row  col-12 one justify-content-end ">
                        <button type="submit" class="btn btn-primary ">
                            {{ translate('Store') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

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
            if (type == "file") {

                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('file') }} </label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8" name="value" id="value" ></textarea> </div></div> ');
            }
        });

        $(function () {
            var type = $('#type').find('option:selected').val();

            if (type == "file") {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label"> {{ translate('file') }}</label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="value" id="value" ></textarea> </div></div> ');
            }
        });
    </script>
@endsection

