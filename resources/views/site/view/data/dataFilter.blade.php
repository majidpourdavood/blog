<?php
$categories = request('category_id');
$title = request('title');
?>

@if(isset($title) && $title)
    <button type="button" class="btn btn-primary btn-sm m-1 remove-search">
        <input type="hidden" name="title">
        <i class="fa fa-times"></i>
        {{translate('title') . ":" . $title}}
    </button>
@endif

@if(isset($categories) && count($categories) > 0)

    @foreach($categories as $key => $category)
        <button type="button" class="btn btn-primary btn-sm m-1 remove-search">
            <input type="hidden" name="category_id[{{$key}}]"
                   value="{{$category}}">
            <i class="fa fa-times"></i>
            {{\App\Category::findOrFail($category)->title}}
        </button>
    @endforeach

@endif
