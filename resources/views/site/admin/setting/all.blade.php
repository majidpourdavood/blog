@section('title' , ' | ' .  translate('Settings') )
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
                                <a href="{{ route('setting.create') }}" class="btn "
                                   title="">
                                    <i class="fas fa-plus"></i> {{ translate('Settings') }}</a>
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
                            <?php $i = ($settings->perPage() * ($settings->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th width="15%">{{ translate('Title') }}</th>
                            <th width="15%">{{translate('value')}}</th>
                            <th width="10%">{{ translate('status') }}</th>
                            <th width="10%">{{translate('language')}}</th>
                            <th width="10%">{{ translate('the date of creation') }}</th>
                            <th width="35%">{{ translate('Settings') }}</th>
                        </tr>
                        </thead>
                        <tbody class="row_position">
                        @foreach($settings as $setting)
                            <tr id="<?php echo $setting->id ?>">
                                <td>   {{$i++}}</td>

                                <td>{{ $setting->title }}</td>
                                <td>{{ $setting->value }}</td>

                                <td>
                                    @if ($setting->active == 0)
                                        {{ translate('Inactive') }}
                                    @elseif ($setting->active == 1)
                                        {{ translate('active') }}
                                    @endif
                                </td>
                                <td>{{ $setting->lang }}</td>

                                <td>{{ $setting->created_at }}</td>
                                <td>
                                    <ul class="list-inline">

                                        <li class="list-inline-item">
                                            <form action="{{ route('setting.destroy'  , [ $setting->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="btn_group ">
                                                    <a href="{{ route('setting.edit' , [ $setting->id]) }}"
                                                       title="{{ translate('Edit') }}" class="btn btn-outline-warning">
                                                        <i class="fas fa-edit"></i></a>

                                                    <button type="submit" class="btn  btn-outline-danger"
                                                            onclick="return  confirm('{{translate('Do you want to delete the setting?')}}')">
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
                <div class="row col-12 justify-content-center">
                    {!! $settings->render() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
