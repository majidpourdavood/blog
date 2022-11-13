@if(isset($blogs) && count($blogs) > 0)
    @foreach($blogs as $blog)
        <div class="item col-12 col-sm-12 col-md-6 col-lg-4 item">
            <div class="card">
                <a href="{{route('blog', ['slug' => $blog->slug])}}"
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
                <div class="card-body">
                    <a href="{{route('blog', ['slug' => $blog->slug])}}"
                       title="{{$blog->title}}">
                        <h4 class="card-title"><?php echo strip_tags(words($blog->title, 12, ' ...'));?></h4>
                    </a>

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
