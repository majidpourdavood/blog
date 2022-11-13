@if(isset($subCategories) && count($subCategories) > 0)

    @foreach($subCategories as $key => $category)
        <div class="item col-12 col-sm-12 col-md-6 col-lg-4 p-1">
            <div class="card p-0">
                <div class="custom-control custom-checkbox ">
                    <input type="checkbox" name="category_id[{{$category->id}}]"
                           value="{{$category->id}}"
                           class="custom-control-input select-category"
                           {{in_array($category->id, $selected_categories) ? "checked" : 'dd'}}
                           id="category-{{$category->id}}">
                    <label class="custom-control-label  p-3"
                           for="category-{{$category->id}}"> {{$category->title}}</label>
                </div>
            </div>
        </div>
    @endforeach

@else

    <div class="row col-12 justify-content-center align-items-center p-5">
        <h3>{{translate('There are no items to display.')}}</h3>
    </div>
@endif
