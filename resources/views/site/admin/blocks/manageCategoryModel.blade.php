<ul>
    @foreach($childa as $child)
        <li class="list-inline  {{ ($child->id == $category->id) || ($child->id == $category->parent_id)|| ((isset($category->parent->parent))&& $child->id == $category->parent->parent->id )|| ((isset($category->parent->parent->parent))&& $child->id == $category->parent->parent->parent->id )|| ((isset($category->parent->parent->parent->parent))&& $child->id == $category->parent->parent->parent->parent->id ) ? ' dc-show ' : ''}}" code="{{$child->id}}" id="list-{{$child->id}}" title="{{$child->title}}"
        >
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" name="category_id"
                       {{ ($child->id == $category->id)  ? 'checked' : ''}}
                       value="{{$child->id}}" class="custom-control-input d-inline-block" id="category_id-{{$child->id}}">
                <label class="custom-control-label d-inline-block" for="category_id-{{$child->id}}"></label>
            </div>
            {{ $child->title }}

            @if(count($child->children)>0)
                @include('site.admin.blocks.manageCategoryModel',['childa' => $child->children()->orderBy('title', 'ASC')->get()])
            @else
            @endif
        </li>
    @endforeach
</ul>