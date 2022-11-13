@section('title' , ' | ' . translate('Categories'))
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
                                <a href="{{ route('category.create') }}" class="btn btn_create" title="اضافه کردن دسته">
                                    <i class="fas fa-plus"></i> {{ translate('Category') }}</a>
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
                            <?php $i = ($categories->perPage() * ($categories->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th width="15%">{{ translate('Title') }}</th>
                            <th width="15%">{{translate('type')}}</th>
                            <th width="15%">{{ translate('status') }}</th>
                            <th width="10%">{{translate('language')}}</th>
                            <th width="15%">{{ translate('the date of creation') }}</th>
                            <th width="25%">{{ translate('Settings') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>   {{$i++}}</td>

                                <td>{{ $category->title }}</td>
                                <td>
                                    @if($category->type == 0)
                                        {{translate('blog')}}
                                    @elseif($category->type == 1)
                                        {{translate('Company')}}
                                    @else
                                        {{translate('blog')}}
                                    @endif
                                </td>

                                <td>
                                    @if ($category->active == 0)
                                        {{translate('Inactive')}}
                                    @elseif ($category->active == 1)
                                        {{translate('active')}}
                                    @endif
                                </td>
                                <td>{{ $category->lang }}</td>

                                <td>{{ $category->created_at }}</td>

                                <td>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <form action="{{ route('category.destroy'  , [ $category->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="btn_group ">
                                                    <a href="{{ route('category.edit' , [ $category->id]) }}"
                                                       class="btn btn-outline-warning" title="{{ translate('Edit') }}">
                                                        <i class="fas fa-edit"></i></a>
                                                    <button type="submit" class="btn  btn-outline-danger"
                                                            onclick="return  confirm('{{translate('Do you want to delete the category?')}}')">
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
                    {!! $categories->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
