@section('title' , ' | ' .  translate('Edit permission') )
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
                            <li class="breadcrumb-item"><a class="btn" href="#"> {{ translate('Edit permission') }} </a></li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                <h1>{{ translate('Edit permission') }}  </h1>
                <form class="form-horizontal text-right"
                      action="{{ route('updateUserPermissions' , [ $user->id ]) }}" method="post"
                >
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}



                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" name="all"
                               value="1"
                               class="custom-control-input"
                               id="all">
                        <label class="custom-control-label"
                               for="all"> {{ translate('permissions') }} </label>
                    </div>


                    <div class="form-group row">


                        <div class="col-12">
                            <div class="col-12 row">

                                @foreach(\App\Permission::latest()->get() as $permission)

                                    <div class="col-12 col-md-4">
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" name="permission_id[]"
                                                   value="{{ $permission->id }}"
                                                   class="custom-control-input"
                                                   {{ in_array(trim($permission->id) , $user->permissions->pluck('id')->toArray()) ? 'checked' : ''  }}
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
                    </div>


                    <div class="col-12 row ">
                        <button type="submit" class="btn btn-info btn-block">{{ translate('submit') }}</button>
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
