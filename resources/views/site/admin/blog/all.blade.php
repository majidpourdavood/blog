@section('title' , ' |  ' . translate('item'))
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
                                <a href="{{ route('blog.create') }}" class="btn "
                                   title="{{translate('Add item')}}">
                                    <i class="fas fa-plus"></i> {{translate('item')}}</a>
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
                            <?php $i = ($blogs->perPage() * ($blogs->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{translate('Row')}}</th>
                            <th width="15%">{{translate('Title')}}</th>
                            <th width="10%">{{translate('Image')}}</th>
                            <th width="10%">{{translate('status')}}</th>
                            <th width="10%">{{translate('viewCount')}}</th>
                            <th width="10%">{{translate('language')}}</th>
                            <th width="10%">  {{translate('the date of creation	')}}</th>
                            <th width="35%">{{translate('Settings')}}</th>
                        </tr>
                        </thead>
                        <tbody class="row_position">
                        @foreach($blogs as $blog)
                            <tr id="<?php echo $blog->id ?>">
                                <td>   {{$i++}}</td>

                                <td>{{ $blog->title }}</td>

                                <?php
                                $thumbnail_medium = $blog->files()->where('type', 5)->first();
                                if (isset($thumbnail_medium)) {
                                    $image = $thumbnail_medium->file;
                                } else {
                                    $image = "/images/placeholder.jpg";
                                }
                                ?>

                                <td><a target="_blank" href="{{ $image }}">
                                        <img width="90" height="90" src="{{ $image}}" alt="{{$blog->title}}"></a>
                                </td>

                                <td>

                                    <?php
                                    $active = \App\Model\Property::where('key', 'active')
                                        ->lang()  ->where('model', 'App\Model\Blog')->first();
                                    ?>
                                    @foreach($active->optionProperties as $optionProperty)
                                        @if( $blog->active == $optionProperty->value)
                                            {{$optionProperty->name}}
                                        @endif
                                    @endforeach

                                </td>
                                <td>{{ $blog->viewCount }}</td>
                                <td>{{ $blog->lang }}</td>
                                <td>{{ $blog->created_at }}</td>
                                <td>


                                    <ul class="list-inline">


                                        <li class="list-inline-item">
                                            <form action="{{ route('blog.destroy'  , [ $blog->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="btn_group ">
                                                    <a href="{{ route('blog.edit' , [ $blog->id]) }}"
                                                       title="{{ translate('Edit') }}" class="btn btn-outline-warning">
                                                        <i class="fas fa-edit"></i></a>

                                                    <button type="submit" class="btn  btn-outline-danger"
                                                            onclick="return  confirm('{{translate('Do you want the blog to be deleted?')}}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </li>


                                        <li class="list-inline-item">
                                            <a href="{{route('blog', ['slug' => $blog->slug])}}"
                                               title="{{ translate('Display on the site') }}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               target="_blank"
                                               class="btn btn-dark">
                                                <i class="fa fa-eye"></i>
                                            </a></li>

                                        <li class="list-inline-item">
                                            <a href="{{ route('createFile' , [        "fileable_id" => $blog->id,
            "fileable_type" => get_class($blog),
            ]) }}"
                                               title="{{ translate('Add file') }}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               class="btn btn-info">
                                                <i class="fas fa-plus"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ route('createItem' , [        "itemable_id" => $blog->id,
            "itemable_type" => get_class($blog),
            ]) }}"
                                               title="{{ translate('Add item for SEO') }}"

                                               data-toggle="tooltip"
                                               data-placement="top"
                                               class="btn btn-primary">
                                                <i class="fas fa-plus"></i></a>
                                        </li>
                                    </ul>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row col-12 justify-content-center">
                    {!! $blogs->render() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
