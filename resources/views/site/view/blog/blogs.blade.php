<?php
$setting = \App\Model\Setting::where('key', 'indexDescription')
    ->lang()->where('active', 1)->first();

if (isset($setting)) {
    $indexDescription = $setting->value;
} else {
    $indexDescription = ' ';
}
?>
@section('title' , ' |   ' . translate('magazine'))
@section('description')  {{$indexDescription}}@stop

@section('meta')
    <meta property="og:title" content="{{translate('magazine')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="{{$indexDescription}}"/>
    <meta property="og:image" content="{{asset('/images/logo.png')}}"/>
    <meta property="og:url" content="{{route('blogs')}}"/>
    <meta property="og:site_name" content="{{translate('magazine')}}"/>
    <meta property="og:title" content="{{translate('magazine')}}"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{ translate('id twitter')  }}"/>
    <meta name="twitter:title" content="{{translate('magazine')}}"/>
    <meta name="twitter:description" content="{{$indexDescription}}"/>
    <meta name="twitter:image" content="{{asset('/images/logo.png')}}"/>

    <link rel="canonical" href="{{route('blogs')}}">

@stop


@extends('site.master')

@section('content')


    <style>
        .content-layout {
            margin-top: -4rem;
        }

        @media (max-width: 767.98px) {
            .content-layout {
                margin-top: -4rem;
            }
        }
    </style>
    <div class="bg-layout-top">
        <div class="row col-12 site-title-header ">
            <h1 class="h1-layout">
                {{translate('magazine')}}
            </h1>
        </div>

        <div class="container">
            <div class=" row col-12 search-top-filter">
                <div class="row col-12 ">
                    <div class="row col-12">


                        <div class="col item">
                            <button
                                type="button" data-toggle="modal"
                                data-target="#category" data-type="0"
                                class="btn  btn-modal-category  btn-block"
                            >
                                <span>{{translate('Select category')}}</span>
                                <i class="fas fa-angle-left"></i>
                            </button>
                        </div>

                        <div class="col p-2 parent-input-search">
                            <div class="form-group">
                                <input type="text" name="title" value="{{request('title')}}"
                                       placeholder="{{translate('Search by title and...')}}"
                                       class="form-control input-search-page">

                                <i class="fa fa-search"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row col-12">
                        <div class="col p-2">
                            <button class="btn btn-block btn-yaremohajer-secend btn-search h-100" type="button">
                                {{translate('Search')}}
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <div class="row col-12 content-layout content">
            <div class="list-filter">
                <?php

                echo view('site.view.data.dataFilter')->render();
                ?>
            </div>

            <div class="row col-12 parent-blog">

                <div class="col-12 col-sm-12 col-md-12 col-lg-12 right list-blogs-page articles">
                    @foreach($blogs as $blog)
                        <div class="card">
                            <div class="row no-gutters ">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 parent-image-blog">
                                    <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                                       title="{{$blog->title}}">
                                        <?php
                                        $thumbnail_medium = $blog->files()->where('type', 5)->first();
                                        if (isset($thumbnail_medium)) {
                                            $image = $thumbnail_medium->file;
                                        } else {
                                            $image = "/images/placeholder.jpg";
                                        }
                                        ?>
                                        <img
                                            src="{{ url('/') .$image }}"
                                            class="card-img" alt="{{$blog->title}}">
                                    </a>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="card-body">
                                        <h4 class="category-blog">
                                            {{isset($blog->category)? $blog->category->title : ""}}
                                        </h4>

                                        <h5 class="card-title">
                                            <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                                               title="{{$blog->title}}">
                                                {{$blog->title}}
                                            </a>
                                        </h5>
                                        <div class="card-text">
                                            <?php echo strip_tags(words($blog->body, 40, '...'));?>
                                        </div>


                                        <ul class=" row col-12 list-blog-index-bottom">
                                            <li class=" row col-12 ">
                                                <ul class=" row col-12 ">
                                                    <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        @if(count($blog->ratings) > 0)
                                                            @include('site.layout.rating' , ['ratings' => array_sum($blog->ratings->pluck('rating')->toArray())/count($blog->ratings->pluck('rating')->toArray())  , 'subject' => $blog])
                                                        @else
                                                            @include('site.layout.rating' , ['ratings' => 0  , 'subject' => $blog])
                                                        @endif
                                                    </li>
                                                    <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                                                           title="{{$blog->title}}" class="btn btn-show-blog-index">{{translate('view')}}</a>

                                                    </li>

                                                </ul>
                                            </li>

                                            <li class=" row col-12 ">
                                                <ul class=" row col-12 ">
                                                    <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <?php
                                                        $userBlog = isset($blog->user) ? $blog->user->name . " " . $blog->user->lastName : translate('Admin');
                                                        echo $userBlog;
                                                        ?>
                                                    </li>

                                                    <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        @if(app()->getLocale() == "fa")
                                                            {{jdate($blog->created_at)->format('%d %B %Y')}}
                                                        @else
                                                            {{ $blog->created_at->isoFormat(' dddd OD MMMM, GGGG')}}
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>


                                    </div>

                                </div>
                            </div>

                        </div>
                    @endforeach

                    <div class="row col-12 justify-content-center">
                        {!! $blogs->render() !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

<div class="modal fade bd-example-modal-lg" id="category" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{translate('Choose your desired category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="message text-center ">

                </div>

                <div class="row col-12 justify-content-center ">
                    <div class="row col-12 justify-content-center">
                        <div class="col-12 col-md-4 p-1">
                            <div class="form-group">
                                <label for="select-category">{{ translate('Select category') }}</label>
                                <select class="form-control" name="category_parent_id" id="select-category">

                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row col-12 parent-category">


                    </div>

                </div>


                <div class="row col-12 justify-content-center mt-3">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary"
                            id="btnLocationSubmit">{{ translate('Search') }}
                    </button>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script>

        $(function () {
            $(document).on('click', '.btn-search', function (e) {

                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);

                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);

            });
            $(document).on('click', '.fa-search', function (e) {
F
                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);

                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);

            });

        });


        $(function () {
            $(document).on('change', '#select-category', function () {
                var id = $(this).val();

                $.ajax({
                    url: '/getSubCategory/' + id,
                    type: "GET",
                    data: {
                        "category": '<?php  echo json_encode(request('category_id')); ?>'
                    }
                })
                    .done(function (data) {
                        console.log(data)
                        var oModalEdit = $('#category');

                        oModalEdit.find('.parent-category').html('');
                        oModalEdit.find('.parent-category').html(data);

                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                        var oModalEdit = $('#category');
                        oModalEdit.find('.parent-category').html('');
                        oModalEdit.find('.parent-category').html(data);
                    });
            });
        });

        $(document).on('click', '.btn-modal-category', function (e) {
            var type = $(this).data('type');

            e.preventDefault();
            $.ajax({
                url: '/getCategory/' + 0,
                data: {
                    "type": type
                },
                type: "GET",
                dataType: "json"
            })
                .done(function (data) {
                    console.log(data)
                    var oModalEdit = $('#category');

                    oModalEdit.find('#select-category').html('');
                    var table = '';
                    table += "<option value='' >{{translate('Select')}}</option>";
                    $.each(data, function (key, value) {
                        table += (
                            '<option value="' + key + '" > ' + value + '</option>'
                        );
                    });

                    oModalEdit.find('#select-category').append(table);

                    oModalEdit.modal();
                })
                .fail(function (data) {
                    console.log(data);
                });
        });

        $(document).on('click', '.btn-modal-location', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/getLocation/' + 0,
                type: "GET",
                dataType: "json"
            })
                .done(function (data) {
                    console.log(data)
                    var oModalEdit = $('#location');

                    oModalEdit.find('#select-country').html('');
                    var table = '';
                    table += "<option value='' >{{translate('Select')}}</option>";
                    $.each(data, function (key, value) {
                        table += (
                            '<option value="' + key + '" > ' + value + '</option>'
                        );
                    });

                    oModalEdit.find('#select-country').append(table);

                    oModalEdit.modal();
                })
                .fail(function (data) {
                    console.log(data);
                });
        });

        $(function () {
            $(document).on('change', '#select-country', function () {
                var id = $(this).val();

                $.ajax({
                    url: '/getLocation/' + id,
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data) {
                        console.log(data)
                        var oModalEdit = $('#location');

                        oModalEdit.find('#select-state').html('');
                        var table = '';
                        table += "<option value='' >{{translate('Select')}}</option>";
                        $.each(data, function (key, value) {
                            table += (
                                '<option value="' + key + '" > ' + value + '</option>'
                            );
                        });

                        oModalEdit.find('#select-state').append(table);

                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            });
        });

        $(function () {
            $(document).on('change', '#select-state', function () {
                var id = $(this).val();

                $.ajax({
                    url: '/getCity/' + id,
                    type: "GET",
                    data: {
                        "location": '<?php  echo json_encode(request('location_id')); ?>'
                    }
                })
                    .done(function (data) {
                        console.log(data)
                        var oModalEdit = $('#location');

                        oModalEdit.find('.parent-city').html('');
                        oModalEdit.find('.parent-city').html(data);

                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                        var oModalEdit = $('#location');
                        oModalEdit.find('.parent-city').html('');
                        oModalEdit.find('.parent-city').html(data);
                    });
            });
        });


        $(function () {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();

                $('#loading').show();
                $('.articles').addClass('blur');

                var url = $(this).attr('href');
                var url2 = new URL(url);
                var page = url2.searchParams.get("page");

                var urlParams = new URLSearchParams(window.location.search);
                var query = urlParams.toString();
                urlParams.set('page', page);


                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);

            });


        });

        $(function () {
            $(document).on('change', '.select-sort', function (e) {
                e.preventDefault();

                $('#loading').show();
                $('.articles').addClass('blur');

                var sort = $('.select-sort option:selected').val();

                var urlParams = new URLSearchParams(window.location.search);
                var sortExist = urlParams.has('sort');
                if (sortExist) {
                    urlParams.set('sort', sort);
                } else {
                    urlParams.append('sort', sort);
                }


                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);


            });


        });

        $(function () {
            $(document).on('keyup', 'input[type="text"]', function (e) {

                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);
                var index = $(this).attr('name');
                var val = $(this).val();


                if (val != "" || val != " " || val != undefined) {

                    var EexiestValue = urlParams.has(index);
                    if (EexiestValue) {
                        urlParams.set(index, val);
                    } else {
                        urlParams.append(index, val);
                    }
                } else {
                    urlParams.delete(index);
                }

                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                showFilters(fff, index);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);


            });


        });

        function getArticles(url) {
            $.ajax({
                url: url
            }).done(function (data) {
                $('.articles').html(data);
                $('.articles').removeClass('blur');
                $('#loading').hide();

            }).fail(function () {
                $('.articles').removeClass('blur');
                $('#loading').hide();

            });
        }

        $(function () {
            $(document).on('change', 'input[type="radio"]', function (e) {

                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);
                var index = $(this).attr('name');
                var val = $(this).val();


                if ($(this).is(':checked')) {

                    var EexiestValue = urlParams.has(index);
                    if (EexiestValue) {
                        urlParams.set(index, val);
                    } else {
                        urlParams.append(index, val);
                    }
                } else {
                    urlParams.delete(index);
                }

                var fff = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(fff);
                showFilters(fff, index);
                fff = decodeURIComponent(fff);
                window.history.pushState("", "", fff);


            });
        });

        $(function () {
            $(document).on('change', 'input[type="checkbox"]', function (e) {

                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);
                var index = $(this).attr('name');
                var val = $(this).val();

                if ($(this).is(':checked')) {
                    var EexiestValue = urlParams.has(index);
                    if (EexiestValue) {
                        urlParams.set(index, val);
                    } else {
                        urlParams.append(index, val);
                    }
                } else {
                    urlParams.delete(index);
                }


                var filters = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(filters);
                showFilters(filters, index);
                filters = decodeURIComponent(filters);
                window.history.pushState("", "", filters);


            });


        });


        function showFilters(url, index = 0) {
            $.ajax({
                url: url,
                data: {
                    "type_search": "filter"
                }
            }).done(function (data) {
                $('.list-filter').html(data);

            }).fail(function (data) {
                console.log(data);
            });
        }


        $(function () {
            $(document).on('click', '.remove-search', function (e) {
                // e.preventDefault();

                $('#loading').show();
                $('.articles').addClass('blur');
                var urlParams = new URLSearchParams(window.location.search);
                var index = $(this).find('input').attr('name');
                var val = $(this).find('input').val();

                urlParams.delete(index);

                var inputValue = $('input[name ="' + index + '"]');
                if (inputValue.is(':radio')) {

                    inputValue.prop('checked', false);
                    $('#location-0').prop('checked', true);

                } else if (inputValue.is(':text')) {
                    inputValue.val('');
                } else {
                    inputValue.prop('checked', false);
                }

                var filters = window.location.href.split('?')[0] + '?' + urlParams.toString();
                getArticles(filters);
                showFilters(filters);
                filters = decodeURIComponent(filters);
                window.history.pushState("", "", filters);

            });
        });

    </script>

    <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.css') }}">

    <script src="{{ asset('js/jquery.rateyo.js') }}"></script>

    <script>

        function addRating(obj, id) {
            $('.ratingModel #tutorial-' + id + ' .rateYo').click(function (e) {
                $('#tutorial-' + id + ' .ratingName').val(rating);

                $.ajax({
                    url: '/ratings',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "rating": $('#tutorial-' + id + ' .ratingName').val(),
                        "ratingable_id": $('#tutorial-' + id + ' .ratingable_id').val(),
                        "ratingable_type": $('#tutorial-' + id + ' .ratingable_type').val()
                    },
                    type: "POST",
                })
                    .done(function (data) {
                        $('#parent-' + id + ' .message-rating').text(data.data);
                        $('#parent-' + id + ' .message-rating').show();
                        // alert(data.data);
                    }).fail(function (data) {

                });
            });

        }

        $(function () {
            $('.rateYo').each(function () {
                var code = $(this).attr('code');
                $(this).rateYo({
                    rating: $('#rating' + code).val(),
                    precision: 2,
                    normalFill: "#A0A0A0",
                    ratedFill: "#f4b30a",
                    rtl: true,
                    starWidth: "25px"
                }).on("rateyo.set", function (e, data) {
                    rating = data.rating;
                });

            });
        });
    </script>
@endsection
