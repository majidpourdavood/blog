@section('title' , ' |  ' . translate('Comments'))
@section('description' , '')
@extends('site.admin.panel')

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{translate('Comments')}}</a></li>
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
                    <?php $i = ($comments->perPage() * ($comments->currentPage() - 1)) + 1;  ?>
                    <th width="5%">{{ translate('Row') }}</th>
                    <th>{{translate('user name')}}</th>
                  <th>{{ translate('status') }}</th>
                    <th>{{translate('Related post')}}</th>
                    <th>{{ translate('Settings') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>   {{$i++}}</td>

                        <td>{{$comment->name}} </td>

                        <td>{{ $comment->comment }}</td>

                        <td>
                            @if($comment->approved == 0)
                            {{translate('not confirmed')}}
                                @else
                                {{translate('confirmed')}}
                                @endif

                        </td>

                        <td>
                            @if($comment->commentable)
                                {{  $comment->commentable->title }}
                            @endif

                        </td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <form action="{{ route('comment.destroy'  , [ $comment->id]) }}"
                                          method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="btn-group btn-group-xs">
                                            <button type="submit" class="btn  btn-outline-danger"
                                                    onclick="return  confirm('{{translate('Do you want the comment to be deleted?')}}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </form>
                                </li>
                                @if($comment->approved == 0)
                                    <li class="list-inline-item">
                                        <form style="margin-right: 5px"
                                              action="{{ route('approve.comment'  , [ $comment->id]) }}"
                                              method="post">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="fas fa-check"></i></button>
                                        </form>
                                    </li>
                                @else
                                @endif


                                <li class="list-inline-item">
                                    <a href="{{route('getReplyCommentAdmin', [ $comment->id])}}"
                                       class="btn btn-outline-info" title="{{translate('Response')}}">
                                        {{translate('Response')}}
                                    </a>
                                </li>
                            </ul>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $comments->render() !!}
        </div>
            </div>
        </div>
    </div>
@endsection
