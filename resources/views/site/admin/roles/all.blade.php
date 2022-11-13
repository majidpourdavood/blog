@section('title' , ' |  ' . translate('Roles'))
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
                                <a class="btn" href="{{route('roles.create')}}">

                                    <i class="fa fa-plus"></i>
                                    {{ translate('Create a role') }}</a>
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
                            <?php $i = ($roles->perPage() * ($roles->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th>{{ translate('name') }} </th>
                            <th>{{ translate('Name in English') }}</th>
                            <th>{{ translate('Description') }}</th>
                            <th>{{ translate('Settings') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>   {{$i++}}</td>

                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->body }}</td>
                                <td>
                                    <form action="{{ route('roles.destroy'  , [ $role->id]) }}" method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="btn_group ">
                                            <a href="{{ route('roles.edit' , [ $role->id]) }}"
                                               title="{{ translate('Edit') }}" class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i></a>
                                            <button type="submit" class="btn  btn-outline-danger"
                                                    onclick="return  confirm('{{translate('Do you want to delete the role?')}}')"
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="text-align: center">
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

