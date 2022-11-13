<div class="row col-12 list_comment">

    <div class="parent-title-comment">
        <h2>{{translate('Register a new comment')}}</h2>

    </div>

    <h3 class="count_comment_all">{{count($subject->comments()->where('approved', '=', 1)->get())}} {{translate('comment')}} </h3>
    @include('site.layout.flash-message')

    <h6 class="not-publish">{{translate('Your email address will not be published. Required sections are marked')}}
        *</h6>
    <div class="comment-insert row col-12">

        <form class=" row col-12 form_register_comment" action="/comments" method="post">
            <div class="row col-12 form-row">

                <?php $name = old('name'); ?>
                <div class="form-group col-md-6 ">
                    <label for="name" class="label-translate"
                    >{{ translate('name') }}</label> <input type="text"
                                                            class="form-control input-translate "
                                                            value="{{old('name')}}" autocomplete="off"
                                                            name="name" id="name"
                    >

                </div>


                <?php $email = old('email'); ?>
                <div class="form-group col-md-6 ">
                    <label for="email" class="label-translate"
                    >{{translate('Phone call or email')}}</label>
                    <input type="text"
                           class="form-control input-translate"
                           value="{{old('email')}}" autocomplete="off"
                           name="email" id="email"
                    >

                </div>


            </div>


            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="commentable_id" value="{{ $subject->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($subject) }}">


            <?php $comment = old('comment'); ?>
            <div class="form-group col-12 ">
                <label for="comment" class="label-translate"
                >{{ translate('Message') }}</label> <textarea class="form-control input-translate border-radius-1"
                                                              id="comment"
                                                              name="comment"
                                                              rows="3">{{old('comment')}}</textarea>

            </div>


            <div class="row col-12 ">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="row col-12 parent-recaptcha-comment">
                        <div class="g-recaptcha" data-sitekey="<?php
                        $setting = \App\Model\Setting::where('key', 'RECAPTCHA_KEY')
                            ->lang()
                            ->where('active', 1)->first();

                        if (isset($setting)) {
                            echo $value = $setting->value;
                        } else {
                            echo $value = "";
                        }
                        ?>"></div>
                    </div>
                </div>

                <div
                    class="col-12 col-sm-12 col-md-12 col-lg-6 row p-3 justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-end align-items-center">
                    @if(count($subject->ratings) > 0)
                        @include('site.layout.rating' , ['ratings' => array_sum($subject->ratings->pluck('rating')->toArray())/count($subject->ratings->pluck('rating')->toArray())  , 'subject' => $subject])
                    @else
                        @include('site.layout.rating' , ['ratings' => 0  , 'subject' => $subject])
                    @endif


                </div>
            </div>


            <div class="row col-12 justify-content-end  ">
                <button class="btn btn-send-comment" type="submit">{{translate('Register a comment')}}</button>
            </div>
        </form>


    </div>


    @foreach($comments as $comment)
        <ul class="row col-12 list-inline parent_comment_body_user">

            <li class="col-12 list-inline-item">
                <ul class="row col-12 list-inline parent_comment_user_date">
                    <li class="list-inline-item col"><span class="user_comment_all">
                        <img src="/images/default_avatar.png" class="img-fluid"
                             alt="{{isset($comment->name) ? $comment->name :  translate('Unknown') }}">
                                </span></li>


                    <li class="list-inline-item col">
                        <ul class=" list-group ">
                            <li class="list-group-item">
                                <ul class="list-inline-item">
                                    <li class="list-inline-item">
                                        <span
                                            class="name">{{isset($comment->name) ? $comment->name : translate('Unknown')}} </span>

                                    </li>
                                    <li class="list-inline-item">
 <span class="date_comment_all">
     @if(app()->getLocale() == "fa")
         {{ jdate($comment->created_at)->ago()}}
     @else
         {{ $comment->created_at}}
     @endif
                        </span></li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="list-inline-item col body_comment_all text-left">

                                    {!! $comment->comment !!} </p>
                            </li>
                        </ul>
                    </li>
                </ul>


                <ul class="row col-12 list-inline parent_comment_reply">
                    @include('site.layout.likeComment' , [ 'subject' => $comment])


                    <li class="list-inline-item">
                        <a class="btn reply_comment_all_btn " data-parent="{{$comment->id}}" href="javascript:void(0)">
                            <i class="fas fa-reply"></i>
                            {{ translate('Response') }}</a>
                    </li>
                </ul>


                <div class="comment_post_repl_input comment-insert" id="replay_comment{{$comment->id}}">

                    <form class=" row col-12 form_register_comment" action="/comments" method="post">
                        <div class="row col-12 form-row">

                            <?php $name = old('name'); ?>
                            <div class="form-group col-md-6 ">
                                <label for="name" class="label-translate"
                                >{{ translate('name') }}</label> <input type="text"
                                                                        class="form-control input-translate "
                                                                        value="{{old('name')}}" autocomplete="off"
                                                                        name="name" id="name"
                                >

                            </div>


                            <?php $email = old('email'); ?>
                            <div class="form-group col-md-6 ">
                                <label for="email" class="label-translate"
                                >{{ translate('Phone call or email') }}</label> <input type="text"
                                                                                       class="form-control input-translate"
                                                                                       value="{{old('email')}}"
                                                                                       autocomplete="off"
                                                                                       name="email" id="email"
                                >

                            </div>


                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="parent_id" value="0">
                        <input type="hidden" name="commentable_id" value="{{ $subject->id }}">
                        <input type="hidden" name="commentable_type" value="{{ get_class($subject) }}">

                        <div class="form-group col-12 ">
                            <label for="comment" class="label-translate"> {{ translate('Message') }} </label>
                            <textarea class="form-control input-translate border-radius-1"
                                      id="comment"
                                      name="comment"
                                      rows="3">{{old('comment')}}</textarea>

                        </div>
                        <div class="row col-12 parent-recaptcha-comment">
                            <div class="g-recaptcha" data-sitekey="<?php
                            $setting = \App\Model\Setting::where('key', 'RECAPTCHA_KEY')
                                ->lang()->where('active', 1)->first();

                            if (isset($setting)) {
                                echo $value = $setting->value;
                            } else {
                                echo $value = "";
                            }
                            ?>"></div>
                        </div>


                        <div class="row col-12 justify-content-end  ">
                            <button class="btn btn-info" type="submit">{{translate('Register a comment')}}</button>
                        </div>
                    </form>

                </div>

            </li>


            @if(isset($comment) && count($comment->comments))
                @foreach($comment->comments as $childComment)
                    <li class=" list-inline-item comment_reply ">
                        <ul class="row col-12 list-inline parent_comment_user_date">
                            <li class="list-inline-item col"><span class="user_comment_all">
                        <img src="/images/default_avatar.png" class="img-fluid"
                             alt="{{isset($childComment->name) ? $childComment->name : translate('Unknown')}}">
                                </span></li>

                            <li class="list-inline-item col">
                                <ul class=" list-group ">
                                    <li class="list-group-item">
                                        <ul class="list-inline-item">
                                            <li class="list-inline-item">
                                                <span
                                                    class="name">{{isset($childComment->name) ? $childComment->name : translate('Unknown')}}</span>

                                            </li>
                                            <li class="list-inline-item">
 <span class="date_comment_all">
     @if(app()->getLocale() == "fa")
         {{ jdate($childComment->created_at)->ago()}}
     @else
         {{ $childComment->created_at}}
     @endif
                        </span></li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="list-inline-item col body_comment_all text-left">
                                            {!! $childComment->comment !!}
                                        </p>
                                    </li>
                                </ul>
                            </li>
                        </ul>


                        <ul class="row col-12 list-inline parent_comment_reply">
                            @include('site.layout.likeComment' , [ 'subject' => $childComment])

                        </ul>


                    </li>


                @endforeach
            @endif
        </ul>
    @endforeach
</div>



