@section('title') | {{$blog->title}} @stop
@section('description')  {{mb_substr(strip_tags($blog->body), 0,165)}}@stop

@section('meta')

    <?php
    $thumbnail_medium = $blog->files()->where('type', 5)->first();
    if (isset($thumbnail_medium)) {
        $image = $thumbnail_medium->file;
    } else {
        $image = "/images/placeholder.jpg";
    }
    ?>

    <meta property="og:title" content="{{$blog->title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{ url('/').$image }}"/>
    <meta property="og:url" content="{{route('blog', ['slug' => $blog->slug])}}"/>
    <meta property="og:description" content="{{mb_substr(strip_tags($blog->body), 0,165)}}"/>
    <meta property="og:locale" content="it_IT"/>
    <meta property="og:site_name" content="{{config('app.name')}}"/>

    <link rel="canonical" href="{{route('blog', ['slug' => $blog->slug])}}">

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{ translate('id twitter')  }}"/>
    <meta name="twitter:title" content="{{$blog->title}}"/>
    <meta name="twitter:description" content="{{mb_substr(strip_tags($blog->body), 0,165)}}"/>
    <meta name="twitter:image" content="{{ url('/').$image }}"/>
    <script src="{{asset('highlight/highlight.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('highlight/qtcreator-dark.min.css')}}">

@stop


@extends('site.master')

@section('content')
    <div class="bg-layout-top">
        <div class="row col-12 site-title-header ">

        </div>
    </div>
    <div class="container">
        <div class="row col-12 content-layout">
            <div class="row col-12 parent-blog-single">

                <div class="col-12 col-sm-12 col-md-12 col-lg-9 item">

                    <div class=" col-12 right">

                        <div class="col-12 parent-image-blog-single">
                            <a class="col-12 d-block" href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                               title="{{$blog->title}}">
                                <img src="{{ url('/').$image }}"
                                     class="img-fluid img-blog-single" alt="{{$blog->title}}">
                            </a>

                            <div class="footer-image-blog">
                                <div class="content">

                                    <ul class="list-inline">

                                        <li class="list-inline-item">
                                            <img class="img-fluid" src="/images/new/category.svg"
                                                 alt="{{isset($blog->category)? $blog->category->title : ""}}">
                                            {{isset($blog->category)? $blog->category->title : ""}}
                                        </li>

                                        <li class="list-inline-item">
                                            <img class="img-fluid" src="/images/new/time.svg"
                                                 alt="">
                                            @if(app()->getLocale() == "fa")
                                                {{ jdate($blog->created_at)->format('Y-m-d')}}
                                            @else
                                                {{ $blog->created_at->format('Y-m-d')}}
                                            @endif

                                        </li>

                                        <li class="list-inline-item">
                                            <img class="img-fluid" src="/images/new/view.svg"
                                                 alt="">
                                            <span>{{$blog->viewCount}}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <img class="img-fluid" src="/images/new/comment.svg"
                                                 alt="">
                                            <span>{{count($blog->comments()->where('approved', '=', 1)->get())}}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row col-12">
                            <div class="parent-h1-single-blog">
                                <h1>{{$blog->title}}</h1>

                            </div>
                        </div>


                        <div class="description">
                            {!! $blog->body !!}
                        </div>

                        @if($blog->user)
                            <div class="author-blog">
                                <div class="row col-12">
                                    <div class="col">
                                        <span>{{translate('author')}} : </span>
                                    </div>
                                    <div class="col">
                                    <img src="<?php
                                        if (isset($blog->user->image)) {
                                            echo $blog->user->image;
                                        } else {
                                            echo '/images/default_avatar.png';
                                        }
                                        ?>" class="img-fluid  image-author-blog" alt="{{$blog->user->name}} {{$blog->user->lastName}}">

                                    </div>
                                    <div class="col">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                {{$blog->user->name}} {{$blog->user->lastName}}
                                            </li>
                                            <li class="list-group-item">
                                                {!! strip_tags( words($blog->user->body, 100, '...'))!!}
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                            </div>
                        @endif

                        <?php $items = $blog->items()->where('active', 1)->where('type', 0)->orderBy('sort', 'asc')->get();?>
                        @if(isset($items))
                            @include('site.layout.items' , ['models' => $items ])
                        @endif


                        <?php $files = $blog->files()->where('type', 2)->get();?>
                        @if(isset($files))
                            @include('site.layout.files' , ['models' => $files ])
                        @endif


                        @if(isset($blog->tags))
                            <div class="post_blog_tags">
                                <ul>
                                    @foreach($blog->tags as $tag)
                                        <li><a href="javascript:void(0)" title="{{$tag}}">{{$tag}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row no-gutters">


                            <div class="card-footer col-12 row">


                                <div class="row col-12">

                                    <div class=" col-12 row align-items-center link-short">
                                        <div class="row col-12 col-md-7 item justify-content-start align-items-center">
                                <span class="text-link-short">
                                {{translate('short link')}} :</span>
                                            <div class="form-group parent-link-short">
                                                <input type="text" class="form-control "
                                                       value="{{route('blogLink', $blog->id)}}">
                                                <i class="fa fa-copy" aria-hidden="true"
                                                   id="rrrrrr"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{ translate('Click to copy the link.') }}"
                                                ></i>
                                            </div>

                                        </div>

                                        <div class="row col-12 col-md-5 item justify-content-end align-items-center">
                                <span>
                                {{translate('share it')}} :</span>


                                            <?php $titr = $blog->title; ?>
                                            <?php

                                            $lead = strip_tags(words($blog->description, 30, '...'));
                                            ?>
                                            <?php $url = route('blogLink', $blog->id); ?>
                                            <?php $yaremohajer = translate('join us') . " : ";
                                            $shareurl =  translate('share url')  ;
                                            $text = urlencode("\n $yaremohajer \n $shareurl ");
                                            ?>
                                            <?php $icon = "&#128308; "; ?>
                                            <?php $iconId = "&#127380; "; ?>
                                            <?php $iconUrl = "&#127760; "; ?>
                                            <?php $iconLink = "&#x1F517; "; ?>
                                            <?php $urltwitter = route('blogLink', $blog->id); ?>
                                            <?php $Link = translate('Explained in the blog') . " "; ?>

                                            <?php $txt = urlencode("$titr \n \n $lead") . urlencode("\n\n") . $iconLink . urlencode("$Link") . urlencode("\n\n") . "$url"; ?>


                                            <?php
                                            $tags_item_twitter = "";
                                            if (is_array($blog->tags)):
                                                foreach ($blog->tags as $tag):
                                                    $tags_item_twitter .= ',' . $tag . "\n";
                                                endforeach;
                                            endif;
                                            $hashtags = urlencode("\n,$tags_item_twitter");

                                            $txt_twitter = urlencode("$titr\n \n $Link : \n"); ?>

                                            <ul class="list-inline list-share-social">
                                                <li class="list-inline-item">

                                                    <a title="{{translate('Share on Telegram')}}"
                                                       href="https://telegram.me/share/url?text=<?php echo urlencode("\n") . $iconId . urlencode("$shareurl "); ?>&url=<?php echo $icon . $txt ?>"
                                                       class="telegram"> <i class="fab fa-telegram"></i> </a>
                                                </li>


                                                <li class="list-inline-item">
                                                    <a title="{{translate('Share on Twitter')}}"
                                                       href="http://twitter.com/intent/tweet?hashtags=&text=<?php echo $txt_twitter . $iconUrl . $urltwitter . urlencode("\n\n") . $iconId . urlencode("$shareurl "); ?>"
                                                       class="twitter"> <i class="fab fa-twitter"></i> </a>
                                                </li>

                                                <li class="list-inline-item">
                                                    <a title="{{translate('Share on WhatsApp')}}"
                                                       href="whatsapp://send?text=<?php echo $icon . $txt . urlencode("\n\n") . $iconId . urlencode("$shareurl ") ?>&images=<?php echo $image?>"
                                                       data-action="share/whatsapp/share" class="whatsapp"> <i
                                                            class="fab fa-whatsapp"></i> </a>

                                                </li>

                                                <li class="list-inline-item">
                                                    <a title="{{translate('Share on LinkedIn')}}"
                                                       href="https://www.linkedin.com/sharing/share-offsite?url=<?php echo route('blog', $blog->slug); ?>&amp;title=<?php echo $blog->title; ?>"
                                                       class="linkedin"> <i class="fab fa-linkedin"></i> </a>

                                                </li>
                                            </ul>


                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                        @include('site.layout.comment' , ['comments' => $comments , 'subject' => $blog])


                    </div>

                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-3  item">
                    <div class="card blog-related">
                        <div class="row col-12">

                            <div class="parent-h3-related">
                                <h3>
                                    {{translate('Related posts')}}
                                </h3>
                            </div>
                        </div>


                        <div class="card-body">

                            <ul class="list-group list-group-flush list-related-blog">
                                @foreach($blogRelateds as $blogRelated)
                                    <li class="list-group-item item">
                                        <a href="{{pathUrl(route('blog', ['slug' => $blogRelated->slug]))}}"
                                           title="{{$blogRelated->title}}">
                                            <?php

                                            $thumbnail_medium_related = $blogRelated->files()->where('type', 5)->first();

                                            if (isset($thumbnail_medium_related)) {
                                                $image_related = $thumbnail_medium_related->file;
                                            } else {
                                                $image_related = "/images/placeholder.jpg";
                                            }
                                            ?>

                                            <ul class="row col-12">

                                                <li class="col">
                                                    <img
                                                        src="{{ url('/') . $image_related}}"
                                                        class="img-fluid img-blog-related"
                                                        alt="{{$blogRelated->title}}">

                                                </li>

                                                <li class="col">
                                                    <ul class="list-group list-group-flush list-related-blog">

                                                        <li class="list-group-item title-blog-related">
                                                            {{$blogRelated->title}}

                                                        </li>

                                                        <li class="list-group-item parent-time-related">
                                                            <img class="img-fluid image-time"
                                                                 src="/images/new/time.svg"
                                                                 alt="">

                                                            @if(app()->getLocale() == "fa")
                                                                {{ jdate($blogRelated->created_at)->format('Y-m-d')}}

                                                                {{ jdate($blogRelated->created_at)->format('H:i:s')}}
                                                            @else
                                                                {{ $blogRelated->created_at->format('Y-m-d')}}

                                                                {{ $blogRelated->created_at->format('H:i:s')}}
                                                            @endif


                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>


                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.css') }}">

    <script src="{{ asset('js/jquery.rateyo.js') }}"></script>

    <script>
        hljs.initHighlightingOnLoad();
    </script>

    <script>

        $(document).on('click', ".list-files-blog a", function (event) {
            console.log($(this).attr('id'));

            var describedby = $(this).attr('id');

            var image = $(this).data('image');
            var title = $(this).data('title');

            var oModalEdit = $('#imagePermissions');
            oModalEdit.find('.modal-title').text(title);
            oModalEdit.find('img').attr('src', image);
            oModalEdit.modal();

        });


        function addRating(obj, id) {
            $('.ratingModel #tutorial-' + id + ' .rateYo').click(function (e) {
                $('#tutorial-' + id + ' .ratingName').val(rating);

                $.ajax({
                    url: '/ratings',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "rating": $('#tutorial-' + id + ' .ratingName').val(),
                        "ratingable_id": $('#tutorial-' + id + ' .ratingable_id').val(),
                        "ratingable_type": $('#tutorial-' + id + ' .ratingable_type').val()
                    },
                    type: "POST",
                })
                    .done(function (data) {
                        $('#parent-' + id + ' .message-rating').text(data.data);
                        $('#parent-' + id + ' .message-rating').show();
                        // alert(data.data);
                    }).fail(function (data) {

                });
            });

        }

        $(function () {
            $('.rateYo').each(function () {
                var code = $(this).attr('code');
                $(this).rateYo({
                    rating: $('#rating' + code).val(),
                    precision: 2,
                    normalFill: "#A0A0A0",
                    ratedFill: "#f4b30a",
                    rtl: true,
                    starWidth: "25px"
                }).on("rateyo.set", function (e, data) {
                    rating = data.rating;
                });

            });
        });
    </script>


    <?php $countItems = count($blog->items()->where('active', 1)->where('type', 0)->get());?>
    @if(count($blog->items()->where('active', 1)->where('type', 0)->get()) > 0)
        <script type="application/ld+json">{
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
    @foreach($blog->items()->where('active', 1)->where('type', 0)->orderBy('sort', 'asc')->get() as $key  => $model)
                { "@type": "Question",
                   "name": "{{ $model->title }}",
                   "acceptedAnswer": {
                     "@type": "Answer",
                     "text": "{!! $model->description !!}"
                   }
                 }<?php echo $countItems != $key + 1 ? "," : ""?>
            @endforeach ]
    }

        </script>
    @endif



    <script type="application/ld+json">{
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{route('blogLink', $blog->id)}}"
      },
      "headline": "{{$blog->title}}",
      "image": [
        "{{url('/'). $image}}"
      ],
      "datePublished": "<?php
        $createdAt = \Carbon\Carbon::parse($blog->created_at);
        $t = "T";
        $date = $createdAt->format('Y-m-d');
        $time = $createdAt->format('H:i:sT');
        echo $date . $t . $time;
        ?>",
      "dateModified": "<?php
        $updated_at = \Carbon\Carbon::parse($blog->updated_at);
        $tUpdated = "T";
        $dateUpdated = $updated_at->format('Y-m-d');
        $timeUpdated = $updated_at->format('H:i:sT');
        echo $dateUpdated . $tUpdated . $timeUpdated;
        ?>",
      "author": {
        "@type": "Person",
        "name": "<?php
        $userBlog = isset($blog->user) ? $blog->user->name . " " . $blog->user->lastName : config('app.name');
        echo $userBlog;
        ?>"
      },
      "publisher": {
        "@type": "Organization",
        "name": "{{config('app.name')}}",
        "logo": {
          "@type": "ImageObject",
          "url": "<?php
        $setting = \App\Model\Setting::where('key', 'logo')
            ->lang()->where('active', 1)->first();
        if (isset($setting)) {
            echo $imageLogo = url('/') . $setting->value;
        } else {
            echo $imageLogo = url('/') . "/images/logo.png";
        }
        ?>"}}}

</script>
    <script>


        $(".parent-link-short .fa").click(function () {
            var input = $(this).parent().find('input').select();
            document.execCommand("Copy");
        });


        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

        });
    </script>
@endsection
