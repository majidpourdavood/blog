@section('title' , ' | ' . translate('Dashboard'))
@extends('site.admin.panel')

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{translate('Dashboard')}}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1> {{translate('Dashboard')}}</h1>

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="row col-12 parent-box-dashboard">


                                    <div class="col-md-3 item justify-content-center">
                                        <a class=" btn btn-danger btn-block" href="{{route('users.index')}}">

                                            <i class="fas fa-users"></i>

                                            <h3><span>{{$users}}</span> {{ translate('users') }} </h3>
                                        </a>
                                    </div>
                                    <div class="col-md-3 item">
                                        <a class=" btn btn-warning btn-block" href="{{route('comment.index')}}">
                                            <i class="fas fa-comments"></i>

                                            <h3><span>{{$comments}}</span> {{ translate('Comments') }} </h3>

                                        </a>
                                    </div>
                                    <div class="col-md-3 item">
                                        <a class=" btn btn-primary btn-block" href="{{route('blog.index')}}">
                                            <i class="fab fa-blogger-b"></i>
                                            <h3><span>{{$blogs}}</span> {{ translate('blog') }} </h3>

                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


