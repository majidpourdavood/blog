@if(isset($model) && $model != null && $model != '')
    <button
        type="button" data-toggle="modal"
        data-target="#category"
        class="btn  btn-modal-category btn-info btn-block"
    >
        @if(isset($model->category_id))
            <input id="category_id" type="hidden" name="category_id"
                   value="{{old('category_id', $model->category_id)}}">

            @if(isset( $model->category->parent))
                {{$model->category->parent->title}}
                >  {{$model->category->title}}
            @elseif(isset( $model->category))
                 {{$model->category->title}}
            @else
               --
            @endif

        @else
            <span>{{translate('Select category')}}</span>
            <i class="fas fa-angle-left"></i>
            <input type="hidden" name="category_id" value="{{old('category_id')}}" id="category_id">
        @endif

    </button>


@else

    <button
        type="button" data-toggle="modal"
        data-target="#category"
        class="btn  btn-modal-category btn-info btn-block"
    >

        <span>{{translate('Select category')}}</span>
        <i class="fas fa-angle-left"></i>
        <input type="hidden" name="category_id" value="{{old('category_id')}}" id="category_id">


    </button>
@endif
