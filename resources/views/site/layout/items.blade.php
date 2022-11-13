<div class="items-model">
    @if(isset($models))
        @foreach($models as $key => $model)

            <button class="btn {{isset($key) && $key == 0 ? "" : "collapsed"}}" type="button" data-toggle="collapse" data-target="#collapse-{{$model->id}}"
                    aria-expanded="{{isset($key) && $key == 0 ? "true" : "false"}}" aria-controls="collapse-{{$model->id}}">
                {{ $model->title }}
                <i class="fa icon_down_up"></i>
            </button>

            <div class="collapse {{isset($key) && $key == 0 ? "show" : "collapsed"}}" id="collapse-{{$model->id}}">
                <div class="card card-body">
                    {!! $model->description !!}
                </div>
            </div>

        @endforeach
    @endif
</div>
