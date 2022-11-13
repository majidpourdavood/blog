@section('title' , ' | ' . translate('Edit permission'))
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
                            <li class="breadcrumb-item">
                                <a class="btn" href="{{route('permissions.index')}}"> {{ translate('permissions') }}</a>
                            </li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1> {{ translate('Edit permission') }}</h1>

                @include('site.layout.flash-message')
                <form class="form-horizontal" action="{{ route('permissions.update' , [ $permission->id ]) }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="form-group row">
                        <label for="name" class="col-12">{{ translate('name') }} </label>
                        <div class="col-12">

                            <input type="text" class="form-control" name="name" id="name" placeholder=""
                                   value="{{old('name', $permission->name)  }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="slug" class="col-12">  {{translate('Name in English')}}</label>
                        <div class="col-12">

                            <input type="text" class="form-control" name="slug" id="slug" placeholder=""
                                   value="{{   old('slug', $permission->slug)  }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="body" class="col-12"> {{ translate('Short description') }}</label>
                        <div class="col-12">

                    <textarea rows="5" class="form-control" name="body" id="body"
                              placeholder="">{{ old('body', $permission->body)  }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 row col-12 justify-content-end">
                            <button type="submit" class="btn btn-danger mt-3">{{ translate('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
