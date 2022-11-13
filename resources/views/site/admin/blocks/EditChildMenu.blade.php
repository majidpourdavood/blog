<ul>
    @foreach($childa as $child)
        <li class="list-inline  {{ ($child->id == $menu->id) || ($child->id == $menu->parent_id)|| ((isset($menu->parent->parent))&& $child->id == $menu->parent->parent->id )|| ((isset($menu->parent->parent->parent))&& $child->id == $menu->parent->parent->parent->id )|| ((isset($menu->parent->parent->parent->parent))&& $child->id == $menu->parent->parent->parent->parent->id ) ? ' dc-show ' : ''}}" code="{{$child->id}}" id="list-{{$child->id}}" title="{{$child->title}}"
        >
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" name="parent_id"
                       {{ ($child->id == $menu->parent_id)  ? 'checked' : ''}}
                       value="{{$child->id}}" class="custom-control-input d-inline-block" id="parent_id-{{$child->id}}">
                <label class="custom-control-label d-inline-block" for="parent_id-{{$child->id}}"></label>
            </div>
            {{ $child->title }}

            @if(count($child->children)>0)
                @include('site.admin.blocks.EditChildMenu',['childa' => $child->children()->orderBy('title', 'ASC')->get()])
            @else
            @endif
        </li>
    @endforeach
</ul>
