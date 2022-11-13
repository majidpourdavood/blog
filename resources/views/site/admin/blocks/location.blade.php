@if(isset($model) && $model != null && $model != '')
    <button
        type="button" data-toggle="modal"
        data-target="#location"
        class="btn  btn-modal-location btn-primary btn-block"
    >
        @if(isset($model->location_id))
            <input id="location_id" type="hidden" name="location_id"
                   value="{{old('location_id',$model->location_id)}}">

            @if(isset( $model->location->parent))
                {{$model->location->parent->name}}
                >  {{$model->location->name}}
            @elseif(isset( $model->location))
                {{$model->location->name}}
            @else
--
            @endif
        @elseif(isset($model->parent_id))
            <input id="location_id" type="hidden" name="location_id"
                   value="{{old('location_id',$model->id)}}">

            @if(isset( $model->parent))
                {{$model->parent->name}}
                >  {{$model->name}}
            @elseif(isset( $model))
                {{$model->name}}
            @else
--            @endif
        @else
            <input type="hidden" name="location_id" value="{{old('location_id')}}" id="location_id">
            <span>{{translate('Select province/city')}}</span>
            <i class="fas fa-angle-left"></i>
        @endif

    </button>


@else

    <button
        type="button" data-toggle="modal"
        data-target="#location"
        class="btn  btn-modal-location btn-primary btn-block"
    >

        <input type="hidden" name="location_id" value="{{old('location_id')}}" id="location_id">
        <span>{{translate('Select province/city')}}</span>
        <i class="fas fa-angle-left"></i>


    </button>

@endif
