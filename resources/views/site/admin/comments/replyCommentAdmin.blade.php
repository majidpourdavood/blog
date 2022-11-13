@section('title' , ' |  ' . translate('Reply to the comment'))
@section('description' , '')
@extends('site.admin.panel')

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#"> {{translate('Reply to the comment')}}</a></li>

                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')

            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12 content_panel_layout">
                <h1>{{translate('Reply to the comment')}}</h1>
                @include('site.layout.flash-message')
                <form class="col-12 form_register_comment mt-4"
                      action="{{route('postReplyCommentAdmin', [ $comment->id ])}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="parent_id" value="{{$comment->id}}">
                    <input type="hidden" name="commentable_id" value="{{ $comment->commentable_id }}">
                    <input type="hidden" name="commentable_type" value="{{ $comment->commentable_type}}">

                    <div class="form-group">
                  <textarea class="form-control" placeholder="{{translate('Write your comment here...')}}"
                            id="body_comment" name="comment" rows="7">{{ old('comment')}}</textarea>
                    </div>

                    <div class="row justify-content-end register_score_order ">
                        <button class="btn btn-success" type="submit">{{translate('Register a comment')}}</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection


@section('script')


@endsection
