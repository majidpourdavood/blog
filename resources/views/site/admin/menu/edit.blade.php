@section('title' , ' |  ' .  translate('Edit menu') )
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
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('Edit menu') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Edit menu') }}</h1>
                @include('site.layout.flash-message')
                <form class="form-horizontal form_panel"
                      action="{{ route('menu.update' , [ $menu->id ]) }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}


                    <div class="row one">
                        <label for="title" class="col-12">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title', $menu->title) }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>


                    <div class="row one">
                        <label for="link" class="col-12">{{ translate('link') }} </label>
                        <div class="col-12">
                            <input type="text" name="link" class="form-control" id="link"
                                   value="{{ old('link', $menu->link) }}" placeholder="{{ translate('link') }} ">
                        </div>
                    </div>


                    <div class="col-12 ">

                        <h3 class="list_vahed_sazemani_h3">
                            {{translate('Choose the menu above')}}
                            <span class="title_selected">
                                       <div class="custom-control  custom-checkbox d-inline-block ">
                                            <input type="checkbox" name="parent_id"
                                                   value="0" class="custom-control-input d-block hide_show_focus"
                                                   {{$menu->parent_id == 0 ? 'checked' : '' }}    id="parent-0">
                                            <label class="custom-control-label d-block"
                                                   for="parent-0">
                                                {{translate('Select as the main menu')}}
                                            </label>
                                        </div>

                                </span>
                        </h3>
                        <ul id="tree1">
                            @foreach($menus as $menuParent)
                                <li class="list-inline dc-show  {{ ($menuParent->id == $menu->parent_id) || ((isset($menu->parent->parent))&&$menuParent->id == $menu->parent->parent->id) ? ' dc-show ' : ''}}"
                                    code="{{$menuParent->id}}" id="list-{{$menuParent->id}}"
                                    title="{{$menuParent->title}}">

                                    <div class="custom-control custom-checkbox d-inline-block ">
                                        <input type="checkbox" name="parent_id"
                                               value="{{$menuParent->id}}" class="custom-control-input d-block"
                                               {{ ($menuParent->id == $menu->parent_id)  ? 'checked' : ''}}  id="parent-{{$menuParent->id}}">
                                        <label class="custom-control-label d-block"
                                               for="parent-{{$menuParent->id}}"></label>
                                    </div>

                                    {{ $menuParent->title }}

                                    @if(count($menuParent->children))
                                        @include('site.admin.blocks.EditChildMenu',['childa' => $menuParent->children()->orderBy('title', 'ASC')->get()])
                                    @else
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="row col-12 one">
                        <label for="type" class="col-12">{{ translate('place') }}</label>
                        <div class="col-12">
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="0" {{ $menu->type == 0 ? 'selected' : '' }}>{{ translate('Main') }}</option>
                                <option value="1" {{ $menu->type == 1 ? 'selected' : '' }}> {{ translate('footer') }}</option>
                            </select>
                        </div>
                    </div>


                    @include('site.admin.blocks.language' , [ 'model' =>  $menu])

                    <div class="row one">
                        <label for="active" class="col-12">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" id="active">
                                <option value="0" {{ $menu->active == 0 ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                                <option value="1" {{  $menu->active == 1 ? 'selected' : '' }}> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-12 one">
                        <label for="icon" class="col-12">{{translate('icon')}}</label>
                        <div class="col-12">
                            <input type="file" name="icon" class="form-control" id="icon"
                                   value="{{ $menu->image  }}" placeholder="{{translate('icon')}}">
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <img src="{{$menu->image}}" class="img-fluid img-rounded"
                                 width="150" alt="{{$menu->title}}">
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




    </script>
@endsection
