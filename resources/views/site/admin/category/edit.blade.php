@section('title' , ' |  ' .translate('Edit category') )
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/tree.css')}}">

@endsection
@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('Edit category') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Edit category') }}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel"
                      action="{{ route('category.update' , [ $category->id ]) }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}


                    <div class="row one">
                        <label for="title" class="col-12">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title', $category->title) }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>

                    <div class="col-12  item p-1">
                        <label for="parent_id"
                               class="col-12 control-label text-right">
                            {{ translate('Grouping') }}
                        </label>
                        <div class="col-12 ">
                            <select id="parent_id" name="parent_id"
                                    class="form-control ">
                                <option value="0"
                                    {{   $category->parent_id == 0 ? 'selected' : '' }}
                                >{{ translate('He has no father') }}</option>
                                @foreach($categories as $categoryA)
                                    <option value="{{$categoryA->id}}"
                                        {{   $category->parent_id == $categoryA->id ? 'selected' : '' }}
                                    >{{$categoryA->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @include('site.admin.blocks.language' , [ 'model' =>  $category])
                    <div class="row one">
                        <label for="active" class="col-12">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" id="active">
                                <option value="0" {{ $category->active == 0 ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                                <option value="1" {{  $category->active == 1 ? 'selected' : '' }}> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-12 one">
                        <label for="image" class="col-12"> {{ translate('Image') }} </label>
                        <div class="col-12">
                            <input type="file" name="image" class="form-control" id="image"
                                   value="{{ $category->image  }}" placeholder="{{ translate('Image') }}  ">
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <img src="/images/category/{{$category->image}}" class="img-fluid img-rounded"
                                 width="150" alt="{{$category->title}}">
                        </div>
                    </div>

                    <div class="row col-12 one">
                        <label for="type" class="col-12">{{ translate('type') }}</label>
                        <div class="col-12">
                            <select name="type" class="form-control"  id="type">
                                <option value="0" {{ $category->type == 0 ? 'selected' : '' }}>{{ translate('blog') }}</option>
                                <option value="1" {{ $category->type == 1 ? 'selected' : '' }}>  {{ translate('Company') }}</option>
                            </select>
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="description" class="col-12">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="description" class="form-control" id="description" rows="7"
                              placeholder="{{ translate('Short description') }}">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    <div class=" row one">
                        <label for="body" class="col-12">{{ translate('main text') }} </label>
                        <div class="col-12">
                    <textarea type="text" name="body" class="form-control" id="bodyAdmin" rows="5"
                              placeholder="{{ translate('main text') }} ">{{ old('body', $category->body) }}</textarea>
                        </div>
                    </div>


                    <div class="form-group row col-12 justify-content-end">

                        <button type="submit" class="btn btn-primary">
                            {{ translate('submit') }}
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>

    <script>

        $('input[name ="parent_id"]').on('change', function () {
            $('input[name ="parent_id"]').not(this).prop('checked', false);
        });

        var valueId;
        $.fn.extend({
            treed: function (o) {

                var openedClass = 'fa-minus';
                var closedClass = 'fa-plus';

                if (typeof o != 'undefined') {
                    if (typeof o.openedClass != 'undefined') {
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined') {
                        closedClass = o.closedClass;
                    }
                }

                //initialize each of the top levels
                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this); //li with children ul
                    branch.prepend("<i class='indicator fas " + closedClass + "'></i>");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle();

                            // $('#tree1 li').not($(this)).removeClass('active');
                            // $(this).toggleClass('active');


                        }


                    })
                    branch.children().children().toggle();

                });


                //fire event from the dynamically added icon
                tree.find('.branch .indicator').each(function () {
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                //fire event to open branch if the li contains an anchor instead of text
                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                //fire event to open branch if the li contains a button instead of text
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });


        $('#tree1').treed();



        $(function () {
            var openedClass = 'fa-minus';
            var closedClass = 'fa-plus';
            $.each($("input:checkbox:checked"), function () {
                var parent1 = $(this).parent().parent().hasClass('dc-show');
                if (parent1) {
                    //show district
                    var icon1 = $(this).parent().parent().children('i:first');
                    icon1.toggleClass(openedClass + " " + closedClass);
                    $(this).parent().parent().children().children().toggle();
               console.log(parent1)
                }

                var parent2 = $(this).parent().parent().parent().parent().hasClass('dc-show');
                if (parent2) {
                    //show district
                    var icon2 = $(this).parent().parent().parent().parent().children('i:first');
                    icon2.toggleClass(openedClass + " " + closedClass);
                    $(this).parent().parent().parent().parent().children().children().toggle();
                    console.log(parent2) }

                var parent3 = $(this).parent().parent().parent().parent().parent().parent().hasClass('dc-show');
                if (parent3) {
                    //show district
                    var icon3 = $(this).parent().parent().parent().parent().parent().parent().children('i:first');
                    icon3.toggleClass(openedClass + " " + closedClass);
                    $(this).parent().parent().parent().parent().parent().parent().children().children().toggle();
                    console.log(parent3)   }

                var parent4 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().hasClass('dc-show');
                if (parent4) {
                    //show district
                    console.log(parent4)
                    var icon4 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().children('i:first');
                    icon4.toggleClass(openedClass + " " + closedClass);
                    $(this).parent().parent().parent().parent().parent().parent().parent().parent().children().children().toggle();
                }


                var parent5 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().hasClass('dc-show');
                if (parent5) {
                    //show district
                    console.log(parent5)
                    var icon5 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children('i:first');
                    icon5.toggleClass(openedClass + " " + closedClass);
                    $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().toggle();
                }


            });

        });




        // });
        $('.hide_show_focus').click(function () {
            if ($(this).is(':checked')) {
                $('#tree1').hide();
            } else {
                $('#tree1').show();
            }
        });

        $('[id*="btnEditCategory"]').click(function (e) {
            if (this == e.target) {
                // alert('e.target');
                window.location.href = e.target.href;
            }
            e.preventDefault();
        });


    </script>
@endsection
