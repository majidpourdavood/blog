@if(isset($blogs) && count($blogs) > 0)

        @foreach($blogs as $blog)
            <div class="card">
                <div class="row no-gutters ">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 parent-image-blog">
                        <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                           title="{{$blog->title}}">

                                @if(\request()->ajax())
                                    <img src="<?php
                                    $thumbnail_small = $blog->files()->where('type', 4)->first();
                                    if (isset($thumbnail_small)) {
                                        echo $thumbnail_small->file;
                                    } else {
                                        echo "/images/placeholder.jpg";
                                    }
                                    ?>" class="img-fluid card-img-top " alt="{{$blog->title}}">
                                @else
                                    <img data-src="<?php
                                    $thumbnail_small = $blog->files()->where('type', 4)->first();
                                    if (isset($thumbnail_small)) {
                                        echo $thumbnail_small->file;
                                    } else {
                                        echo "/images/placeholder.jpg";
                                    }
                                    ?>"
                                         class="img-fluid card-img-top lazy" alt="{{$blog->title}}">
                                @endif

                        </a>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="card-body">
                            <h4 class="category-blog">
                                {{isset($blog->category)? $blog->category->title : ""}}
                            </h4>

                            <h5 class="card-title">
                                <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                                   title="{{$blog->title}}">
                                    {{$blog->title}}
                                </a>
                            </h5>
                            <div class="card-text">
                                {{--{!! words($blog->body, 40, '...') !!}--}}
                                <?php echo strip_tags(words($blog->body, 40, '...'));?>
                            </div>


                            <ul class=" row col-12 list-blog-index-bottom">
                                <li class=" row col-12 ">
                                    <ul class=" row col-12 ">
                                        <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            @if(count($blog->ratings) > 0)
                                                @include('site.layout.rating' , ['ratings' => array_sum($blog->ratings->pluck('rating')->toArray())/count($blog->ratings->pluck('rating')->toArray())  , 'subject' => $blog])
                                            @else
                                                @include('site.layout.rating' , ['ratings' => 0  , 'subject' => $blog])
                                            @endif
                                        </li>
                                        <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <a href="{{pathUrl(route('blog', ['slug' => $blog->slug]))}}"
                                               title="{{$blog->title}}" class="btn btn-show-blog-index">{{translate('view')}}</a>

                                        </li>

                                    </ul>
                                </li>

                                <li class=" row col-12 ">
                                    <ul class=" row col-12 ">
                                        <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <?php
                                            $userBlog = isset($blog->user) ? $blog->user->name . " " . $blog->user->lastName : translate('Admin');
                                            echo $userBlog;
                                            ?>
                                        </li>

                                        <li class=" col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            @if(app()->getLocale() == "fa")
                                                {{jdate($blog->created_at)->format('%d %B %Y')}}
                                            @else
                                                {{ $blog->created_at->isoFormat(' dddd OD MMMM, GGGG')}}
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            </ul>


                        </div>

                    </div>
                </div>

            </div>
        @endforeach



    @if ($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="row col-12 justify-content-center align-items-center">
            {{ $blogs->links() }}
        </div>
    @endif

@elseif(isset($blog))
    <div class="item col-12 col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <a href="{{route('blog', ['slug' => $blog->slug])}}"
               title="{{$blog->title}}">
                @if(\request()->ajax())
                    <img
                        src="<?php
                        $thumbnail_small = $blog->files()->where('type', 4)->first();

                        if (isset($thumbnail_small)) {
                            echo $thumbnail_small->file;
                        } else {
                            echo "/images/placeholder.jpg";
                        }
                        ?>" class="img-fluid card-img-top " alt="{{$blog->title}}">
                @else
                    <img
                        data-src="<?php
                        $thumbnail_small = $blog->files()->where('type', 4)->first();

                        if (isset($thumbnail_small)) {
                            echo $thumbnail_small->file;
                        } else {
                            echo "/images/placeholder.jpg";
                        }
                        ?>" class="img-fluid card-img-top lazy" alt="{{$blog->title}}">
                @endif


            </a>
            <div class="card-body">
                <a href="{{route('blog', ['slug' => $blog->slug])}}"
                   title="{{$blog->title}}">
                    <h4 class="card-title"><?php echo strip_tags(words($blog->title, 12, ' ...'));?></h4>
                </a>

            </div>
        </div>
    </div>
@else
    <div class="row col-12 justify-content-center align-items-center p-5">
        <h3>{{translate('There are no items to display.')}}</h3>
    </div>
@endif
