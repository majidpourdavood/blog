@section('title' , ' | ' . translate('users'))
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <style>
        .parentReasonRegistrationText {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="btn" href="{{route('users.create')}}">

                                    <i class="fa fa-plus"></i>
                                    {{translate('Create a user')}}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>


        <div class="row col-12 content_panel_layout">
            <div class="col-12 ">

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <?php $i = ($users->perPage() * ($users->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th>{{ translate('name') }} </th>
                            <th>{{ translate('Roles') }}</th>
                            <th>{{ translate('email') }}</th>
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('the date of creation') }} </th>
                            <th>{{ translate('status') }}</th>
                            <th width="27%">{{ translate('Settings') }}</th>

                        </tr>
                        </thead>
                        <tbody class="row_position">
                        @foreach($users as $user)
                            <tr id="<?php echo $user->id ?>">
                                <td>   {{$i++}}</td>

                                <td>
                                    @if(isset($user->name))
                                        {{ $user->name }} {{ $user->lastName }}
                                    @else
--                                    @endif
                                </td>

                                <td>
                                    @if(count($user->roles) > 0)
                                        @foreach($user->roles as $role)
                                            {{ $role->name }} --
                                        @endforeach
                                    @else
--                                    @endif
                                </td>

                                <td>
                                    @if(isset($user->email))
                                        {{ $user->email }}
                                    @else
--                                    @endif
                                </td>


                                <td class="image-user-admin">
                                    <img src="<?php
                                    if (isset($user->image)) {
                                        echo $user->image;
                                    } else {
                                        echo '/images/default_avatar.png';
                                    }
                                    ?>" class="img-fluid  " alt="{{$user->name}} {{$user->lastName}}">


                                </td>

                                <td>{{ $user->created_at }}</td>

                                <td>
                                    @if ($user->active == 0)
                                        {{ translate('Inactive') }}
                                    @elseif ($user->active == 1)
                                        {{ translate('active') }}
                                    @endif
                                </td>


                                <td>
                                    <ul class="list-inline ">

                                        <li class="list-inline-item">
                                            <form action="{{ route('users.destroy'  , [ $user->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn  btn-outline-danger"
                                                        onclick="return  confirm('{{translate('Do you want to delete the user?')}}')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </li>

                                        <li class="list-inline-item">
                                            <a href="{{ route('users.edit' , [$user->id]) }}"
                                               title="{{ translate('Edit') }}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a></li>


                                        <li class="list-inline-item">
                                            <a href="{{ route('userPermissions' , [ $user->id]) }}"
                                               title="{{translate('Change permissions')}}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               class="btn btn-outline-success">
                                                <i class="fas fa-ban"></i>
                                            </a></li>


                                        <li class="list-inline-item">
                                            <a class="btn btn-outline-info"
                                               title="{{translate('change password')}}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               href="{{route('users.resetPassword' , [ $user->id])}}">
                                                <i class="fas fa-key"></i>
                                            </a>
                                        </li>

                                    </ul>


                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row col-12 justify-content-center">
                    {!! $users->render() !!}

                </div>

            </div>
        </div>
    </div>
@endsection


@section('script')

    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>

    <script type="text/javascript">

        $(document).on('change', '#reasonRegistration', function () {
            var code = $('#reasonRegistration option:selected').val();
            if (code == 0) {
                $('.parentReasonRegistrationText').show();
            } else {
                $('.parentReasonRegistrationText').hide();

            }
        });

        $(document).on('click', '.btnReasonRegistration', function () {
            var id = $(this).attr('data-id');
            var oModalEdit = $('#reasonRegistration');
            oModalEdit.find('#user_id').val(id);
            oModalEdit.modal();

        });

    </script>

@endsection

