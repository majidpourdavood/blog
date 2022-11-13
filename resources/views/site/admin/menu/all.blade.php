@section('title' , ' | ' . translate('Menus'))
@section('description' , '')
@extends('site.admin.panel')

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('menu.create') }}" class="btn btn_create"
                                   title="{{translate('Create a menu')}}">
                                    <i class="fas fa-plus"></i> {{ translate('Menus') }}</a>
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
                    <table class="table table-striped table-hover auto-index" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <?php $i = ($menus->perPage() * ($menus->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th width="15%">{{ translate('Title') }}</th>
                            <th width="15%">{{ translate('link') }}</th>
                            <th width="15%">{{translate('place')}}</th>
                            <th width="15%">{{ translate('status') }}</th>
                                <th width="10%">{{translate('language')}}</th>
                                <th width="15%">{{ translate('the date of creation') }}</th>
                            <th width="25%">{{ translate('Settings') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>   {{$i++}}</td>

                                <td>{{ $menu->title }}</td>
                                <td>{{ $menu->link }}</td>
                                <td>
                                    @if($menu->type == 0)
                                        {{ translate('Main') }}
                                    @elseif($menu->type == 1)
                                        {{translate('footer')}}
                                    @else
                                        {{ translate('Main') }}
                                    @endif
                                </td>

                                <td>
                                    @if ($menu->active == 0)
                                        {{ translate('Inactive') }}
                                    @elseif ($menu->active == 1)
                                        {{ translate('active') }}
                                    @endif
                                </td>
                                <td>{{ $menu->lang }}</td>
                                <td>
                                    {{ $menu->created_at }}
                                </td>


                                <td>


                                    <ul class="list-inline">

                                        <li class="list-inline-item">
                                            <form action="{{ route('menu.destroy'  , [ $menu->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="btn_group ">
                                                    <a href="{{ route('menu.edit' , [ $menu->id]) }}"
                                                       class="btn btn-outline-warning" title="{{ translate('Edit') }}">
                                                        <i class="fas fa-edit"></i></a>
                                                    <button type="submit" class="btn  btn-outline-danger"
                                                            onclick="return  confirm('{{translate('Do you want the menu to be removed?')}}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center ">
                    {!! $menus->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
