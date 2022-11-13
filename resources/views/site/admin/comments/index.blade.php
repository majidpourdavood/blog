@section('title' , ' |  ' . translate('Comments'))
@section('description' , '')
@extends('site.admin.panel')

@section('content')

    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#"> {{translate('Comments')}}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{translate('Comments')}} </h1>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="row col-12 parent-box-comment justify-content-center">

                                <div class="col-md-3 item justify-content-center">
                                    <a class=" btn btn-info btn-block" href="{{route('commentAll')}}">
                                        <i class="fa fa-comments "></i>
                                        <h3>
                                            <span>{{$commentCount}}</span>
                                            {{ translate('All comments') }}
                                        </h3>
                                    </a>
                                </div>
                                <div class="col-md-3 item justify-content-center">
                                    <a class=" btn btn-danger btn-block" href="{{route('commentUnSuccessFull')}}">

                                        <i class="fa fa-comments "></i>

                                        <h3><span>{{$commentUnSuccessFullCount}}</span>
                                            {{translate('Unverified comments')}}
                                        </h3>
                                    </a>
                                </div>
                                <div class="col-md-3 item">
                                    <a class=" btn btn-warning btn-block" href="{{route('commentSuccessFull')}}">
                                        <i class="fa fa-comments "></i>

                                        <h3><span>{{$commentSuccessFullCount}}</span>
                                            {{translate('Approved comments')}}
                                        </h3>

                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
