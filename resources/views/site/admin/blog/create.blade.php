@section('title' , ' |  '  . translate('Create a blog') )
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/tree.css')}}">

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
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('Create a blog') }}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Create a blog') }}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('blog.store') }}" method="post"
                      enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}


                    <div class=" row col-12 one">
                        <label for="title" class="col-12">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title') }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="description" class="col-12">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="description" class="form-control" id="description" rows="7"
                              placeholder="{{ translate('Short description') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class=" row one">
                        <label for="body" class="col-12">{{ translate('main text') }} </label>
                        <div class="col-12">
                    <textarea type="text" name="body" class="form-control" id="bodyAdmin" rows="5"
                              placeholder="{{ translate('main text') }} ">{{ old('body') }}</textarea>
                        </div>
                    </div>


                    <div class=" row one">
                        <label class="col-12" for="tags">
                         {{translate('Keywords (type your keyword then click enter)')}}</label>
                        <div class="col-12"><select name="tags[]" value="" id="tags"
                                                    class="select2 form-control" multiple="multiple">
                                <option>{{translate('key words')}}</option>

                            </select>
                        </div>
                    </div>


                    <?php
                    $active = \App\Model\Property::where('key', 'active')
                        ->lang()
                        ->where('model', 'App\Model\Blog')->first();
                    ?>
                    @if(isset($active->optionProperties))
                        <div class="col-12  item p-1">
                            <label for="active"
                                   class="col-12 control-label text-right">
                                {{ translate('status') }}
                            </label>
                            <div class="col-12 ">
                                <select id="active" name="active"
                                        class="form-control ">
                                    @foreach($active->optionProperties as $optionProperty)
                                        <option value="{{$optionProperty->value}}"

                                        >{{$optionProperty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif



                    @include('site.admin.blocks.language' , [ 'model' =>  ''])

                    <div class=" row one mt-3">
                        @include('site.admin.blocks.category' , [ 'model' =>  ''])
                    </div>


                    @include('site.admin.blocks.file' , [ 'model' =>  ''])


                    <div class=" row one">
                        <label class="col-12"></label>
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


    @include('site.admin.blocks.scriptFile' , [
'model' =>  ''
])
    @include('site.admin.blocks.scriptCategory' , [
'model' =>  '', "type" => "0"
])
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

    </script>
@endsection
