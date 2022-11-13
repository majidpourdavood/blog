<ul>
    @foreach($childa as $child)
        <li class="list-inline  " code="{{$child->id}}" id="list-{{$child->id}}" title="{{$child->title}}"
        >
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" name="parent_id"

                       value="{{$child->id}}" class="custom-control-input d-inline-block" id="parent_id-{{$child->id}}">
                <label class="custom-control-label d-inline-block" for="parent_id-{{$child->id}}"></label>
            </div>
            {{ $child->title }}

            <a class="btn btn-warning btnEditmenu" id="btnEditmenu-{{$child->id}}"
               href="{{ route('menu.edit' ,  $child->id) }}"
               data-toggle="tooltip" data-placement="top" title=" {{translate('Edit')}} {{$child->title}}"
            >{{translate('Edit')}}</a>


            @if(count($child->children)>0)
                @include('site.admin.blocks.manageChildMenu',['childa' => $child->children()->orderBy('title', 'ASC')->get()])
            @else
            @endif
        </li>
    @endforeach
</ul>
