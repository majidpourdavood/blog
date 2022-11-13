@section('title' , ' |  '  .  translate('Create a role') )
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
                                <a class="btn" href="{{route('roles.index')}}">  {{ translate('Roles') }}</a>
                            </li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Create a role') }}</h1>


                @include('site.layout.flash-message')
                <form class="form-horizontal pt-4" action="{{ route('roles.store') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="name" class="col-12">{{ translate('name') }} </label>
                        <div class="col-12">

                            <input type="text" class="form-control" name="name" id="name" placeholder=""
                                   value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" name="all"
                               value="1"
                               class="custom-control-input"
                               id="all">
                        <label class="custom-control-label"
                               for="all"> {{ translate('permissions') }} </label>
                    </div>
                    <div class="form-group row col-12">
                        <div class="col-12 row">


                            @foreach(\App\Permission::latest()->get() as $permission)

                                <div class="col-12 col-md-4">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" name="permission_id[]"
                                               value="{{ $permission->id }}"
                                               class="custom-control-input"

                                               id="role-{{ $permission->id }}">
                                        <label class="custom-control-label"
                                               for="role-{{ $permission->id }}">
                                            {{ $permission->name}}


                                        </label>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>

                    <div class="form-group row col-12">
                        <label for="slug" class="col-12"> {{ translate('Name in English') }}</label>
                        <div class="col-12">

                            <input type="text" class="form-control" name="slug" id="slug" placeholder=""
                                   value="{{ old('slug') }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="body" class="col-12">{{ translate('Description') }} </label>
                        <div class="col-12">

                    <textarea rows="5" class="form-control" name="body" id="body"
                              placeholder="">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class=" justify-content-end col-12 row">
                        <button type="submit" class="btn btn-danger">{{ translate('submit') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $('#all').click(function (e) {
            if ($(this).prop("checked") == true) {
                $('input[name="permission_id[]"]').prop('checked', true); // Unchecks it
            }else{
                $('input[name="permission_id[]"]').prop('checked', false); // Unchecks it
            }
        });
    </script>
@endsection
