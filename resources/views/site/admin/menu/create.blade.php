@section('title' , ' |  ' . translate('Create a menu') )
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
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('Create a menu') }}</a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Create a menu') }}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('menu.store') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row one">
                        <label for="title" class="col-12">{{ translate('Title') }} *</label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title') }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>
                    <div class="row one">
                        <label for="link" class="col-12">{{ translate('link') }} *</label>
                        <div class="col-12">
                            <input type="text" name="link" class="form-control" id="link"
                                   value="{{ old('link') }}" placeholder="{{ translate('link') }} ">
                        </div>
                    </div>

                    <div class="col-12 ">

                        <h3 class="list_vahed_sazemani_h3">
                            {{translate('Choose the menu above')}}
                            <span class="title_selected">
                                       <div class="custom-control  custom-checkbox d-inline-block ">
                                            <input type="checkbox" name="parent_id"
                                                   value="0" class="custom-control-input d-block hide_show_focus"
                                                   {{old('parent_id') == 0 ? 'checked' : '' }}    id="parent-0">
                                            <label class="custom-control-label d-block"
                                                   for="parent-0">
                                                {{translate('Select as the main menu')}}
                                            </label>
                                        </div>

                                </span>
                        </h3>
                        <ul id="tree1">
                            @foreach($menus as $menuParent)
                                <li class="list-inline " code="{{$menuParent->id}}" id="list-{{$menuParent->id}}"
                                    title="{{$menuParent->title}}">

                                    <div class="custom-control custom-checkbox d-inline-block ">
                                        <input type="checkbox" name="parent_id"
                                               value="{{$menuParent->id}}" class="custom-control-input d-block"
                                               id="parent-{{$menuParent->id}}">
                                        <label class="custom-control-label d-block"
                                               for="parent-{{$menuParent->id}}"></label>
                                    </div>

                                    {{ $menuParent->title }}


                                    <a class="btn btn-warning btnEditMenu"
                                       id="btnEditMenu-{{$menuParent->id}}"
                                       href="{{ route('menu.edit' ,  $menuParent->id) }}"
                                       data-toggle="tooltip" data-placement="top"
                                       title=" {{ translate('Edit') }} {{$menuParent->title}}"
                                    >{{ translate('Edit') }}</a>
                                    @if(count($menuParent->children))
                                        @include('site.admin.blocks.manageChildMenu',['childa' => $menuParent->children()->orderBy('title', 'ASC')->get()])
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
                                <option value="0">{{ translate('Main') }}</option>
                                <option value="1"> {{ translate('footer') }}</option>
                            </select>
                        </div>
                    </div>

                    @include('site.admin.blocks.language' , [ 'model' =>  ''])

                    <div class="row col-12 one">
                        <label for="active" class="col-12">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" value="{{ old('active') }}" id="active">
                                <option value="0">{{ translate('Inactive') }}</option>
                                <option value="1"> {{ translate('active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-12 one">
                        <label for="icon" class="col-12"> {{translate('icon')}} </label>
                        <div class="col-12">
                            <input type="file" name="icon" class="form-control" id="icon"
                                   value="{{ old('icon') }}" placeholder="{{translate('icon')}} ">
                        </div>
                    </div>



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
    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>

    <script>

        $('input[name ="parent_id"]').on('change', function() {
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
                ;

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

    </script>



@endsection
