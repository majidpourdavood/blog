<ul>
    @foreach($childa as $child)
        <li class="list-inline  " code="{{$child->id}}" id="list-{{$child->id}}" title="{{$child->name}}"
        >
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" name="parent_id"

                       value="{{$child->id}}" class="custom-control-input d-inline-block" id="parent_id-{{$child->id}}">
                <label class="custom-control-label d-inline-block" for="parent_id-{{$child->id}}"></label>
            </div>
            {{ $child->name }}

            <a class="btn btn-warning btnEditLocation" id="btnEditLocation-{{$child->id}}"
               href="{{ route('location.edit' , [ $child->id]) }}"
               data-toggle="tooltip" data-placement="top" title=" {{translate('Edit')}} {{$child->title}}"
            >{{translate('Edit')}}</a>


            @if(count($child->children)>0)
                @include('site.admin.blocks.manageChildLocation',['childa' => $child->children()->orderBy('name', 'ASC')->get()])
            @else
            @endif
        </li>
    @endforeach
</ul>



