@section('title' , ' | ' . translate('site management'))
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

@endsection
@section('content')

    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{translate('site management')}}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                @include('site.layout.flash-message')

                <form class="form-horizontal "
                      action="{{ route('manageSite') }}" method="post"
                      enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}

                    <div class="row col-12">

                        <div class="alert alert-info col-12 p-2" role="alert">
                            <strong> {{translate('System management')}} </strong>
                        </div>

                        @foreach($managers as $manager)

                            @if($manager->type == "text")
                                <div class="form-group col-12 col-md-6 col-lg-6 p-1">
                                    <div class="col-sm-12"><label for="{{$manager->key}}"
                                                                  class="control-label">{{$manager->title}} </label>
                                        <textarea type="text" class="form-control" rows="1" name="{{$manager->key}}"
                                                  id="{{$manager->key}}">{{$manager->value}}</textarea></div>
                                </div>
                            @elseif($manager->type == "file")
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="{{$manager->key}}"
                                           class="col-12 control-label text-right"> {{$manager->title}}  </label>
                                    <div class="col-md-7 col-xs-12">
                                        <input type="file" name="{{$manager->key}}" class="form-control"
                                               id="{{$manager->key}}"
                                               value="{{ $manager->value }}">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <img src="{{$manager->value}}" class="img-fluid img-rounded" width="150" alt="">
                                    </div>


                                </div>

                            @endif
                        @endforeach

                    </div>

                    <div class="row col-12">

                        <div class="alert alert-info col-12 p-2" role="alert">
                            <strong>{{translate('Management of social networks')}}</strong>
                        </div>

                        @foreach($socials as $social)

                            @if($social->type == "text")
                                <div class="form-group col-12 col-md-6 col-lg-6 p-1">
                                    <div class="col-sm-12"><label for="{{$social->key}}"
                                                                  class="control-label">{{$social->title}} </label>
                                        <textarea type="text" class="form-control" rows="1" name="{{$social->key}}"
                                                  id="{{$social->key}}">{{$social->value}}</textarea></div>
                                </div>
                            @elseif($social->type == "file")
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="{{$social->key}}"
                                           class="col-12 control-label text-right"> {{$social->title}}  </label>
                                    <div class="col-md-7 col-xs-12">
                                        <input type="file" name="{{$social->key}}" class="form-control"
                                               id="{{$social->key}}"
                                               value="{{ $social->value }}">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <img src="{{$social->value}}" class="img-fluid img-rounded" width="150" alt="">
                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>

                    <div class="row col-12">

                        <div class="alert alert-info col-12 p-2" role="alert">
                            <strong> {{translate('SEO management')}}  </strong>
                        </div>

                        @foreach($seo as $se)

                            @if($se->type == "text")
                                <div class="form-group col-12 col-md-6 col-lg-6 p-1">
                                    <div class="col-sm-12"><label for="{{$se->key}}"
                                                                  class="control-label">{{$se->title}} </label>
                                        <textarea type="text" class="form-control" rows="1" name="{{$se->key}}"
                                                  id="{{$se->key}}">{{$se->value}}</textarea></div>
                                </div>
                            @elseif($se->type == "file")
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="{{$se->key}}"
                                           class="col-12 control-label text-right"> {{$se->title}}  </label>
                                    <div class="col-md-7 col-xs-12">
                                        <input type="file" name="{{$se->key}}" class="form-control" id="{{$se->key}}"
                                               value="{{ $se->value }}">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <img src="{{$se->value}}" class="img-fluid img-rounded" width="150" alt="">
                                    </div>


                                </div>
                            @endif
                        @endforeach


                    </div>

                    <div class="row col-12">

                        <div class="alert alert-info col-12 p-2" role="alert">
                            <strong> {{translate('Manage contact us')}}</strong>
                        </div>

                        @foreach($contacts as $contact)

                            @if($contact->type == "text")
                                <div class="form-group col-12 col-md-6 col-lg-6 p-1">
                                    <div class="col-sm-12"><label for="{{$contact->key}}"
                                                                  class="control-label">{{$contact->title}} </label>
                                        <textarea type="text" class="form-control" rows="1" name="{{$contact->key}}"
                                                  id="{{$contact->key}}">{{$contact->value}}</textarea></div>
                                </div>
                            @elseif($contact->type == "file")
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <label for="{{$contact->key}}"
                                           class="col-12 control-label text-right"> {{$contact->title}}  </label>
                                    <div class="col-md-7 col-xs-12">
                                        <input type="file" name="{{$contact->key}}" class="form-control"
                                               id="{{$contact->key}}"
                                               value="{{ $contact->value }}">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <img src="{{$contact->value}}" class="img-fluid img-rounded" width="150" alt="">
                                    </div>


                                </div>

                            @endif
                        @endforeach


                    </div>

                    <div class="row  col-12 one justify-content-end ">

                        <button type="submit" class="btn btn-primary ">
                            {{ translate('submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/select2.min.js') }}"></script>

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

                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('file') }}  </label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8" name="value" id="value" ></textarea> </div></div> ');
            }
        });

        $(function () {
            var type = $('#type').find('option:selected').val();

            // alert(residencyType);
            if (type == "file") {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('file') }}  </label>\n' +
                    '<input type="file" class="form-control" name="value" id="value" value=""> </div></div> ');
            } else {
                $('.file').html('<div class="form-group col-12"><div class="col-sm-12"><label for="value" class="control-label">{{ translate('Description') }} </label>\n' +
                    '<textarea type="text" class="form-control" rows="8"  name="value" id="value" ></textarea> </div></div> ');
            }
        });
    </script>
@endsection

