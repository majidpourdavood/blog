@section('title' , ' | ' . translate('Create a translation'))
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
                            <li class="breadcrumb-item"><a class="btn " href="#">{{translate('Create a translation')}}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{translate('Create a translation')}}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('translation.store') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row one">
                        <label for="name" class="col-12">{{ translate('name') }} *</label>
                        <div class="col-12">
                            <input type="text" name="name" class="form-control" id="name"
                                   value="{{ old('name') }}" placeholder="{{ translate('name') }} ">
                        </div>
                    </div>
                    <div class="row one">
                        <label for="key" class="col-12">{{ translate('Key') }} *</label>
                        <div class="col-12">
                            <input type="text" name="key" class="form-control" id="key"
                                   value="{{ old('key') }}" placeholder="{{ translate('Key') }} ">
                        </div>
                    </div>
                    <div class="row one">
                        <label for="value" class="col-12">{{ translate('value') }} *</label>
                        <div class="col-12">
                            <input type="text" name="value" class="form-control" id="value"
                                   value="{{ old('value') }}" placeholder="{{ translate('value') }} ">
                        </div>
                    </div>

                    @include('site.admin.blocks.language' , [ 'model' =>  ''])


                    <div class="row col-12 one justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ translate('Store') }}
                            </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
