<ul>
    @foreach($childa as $child)
        <li class="list-inline  {{ ($child->id == $location->id) || ($child->id == $location->parent_id)|| ((isset($location->parent->parent))&&$child->id == $location->parent->parent->id) ? 'd-inline-block   ' : ''}}" code="{{$child->id}}" id="list-{{$child->id}}" title="{{$child->name}}"
        >
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" name="parent_id"
                       {{ ($child->id == $location->parent_id)  ? 'checked' : ''}}
                       value="{{$child->id}}" class="custom-control-input d-inline-block" id="parent_id-{{$child->id}}">
                <label class="custom-control-label d-inline-block" for="parent_id-{{$child->id}}"></label>
            </div>
            {{ $child->name }}

            @if(count($child->children)>0)
                @include('site.admin.blocks.EditChildLocation',['childa' => $child->children()->orderBy('name', 'ASC')->get()])
            @else
            @endif
        </li>
    @endforeach
</ul>
