@if(isset($model) && $model != null && $model != '')
    <div class="row col-12 one">
        <label for="lang" class="col-12 col-form-label ">{{translate('language')}}</label>
        <div class="col-12">
            <select name="lang" class="form-control" id="lang">
                @foreach(\App\Model\Language::where('active', 1)->get() as $language)
                    <option value="{{$language->iso}}"
                    {{$model->lang == $language->iso ? "selected" : ""}}
                    > {{$language->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

@else

    <div class="row col-12 one">
        <label for="lang" class="col-12 col-form-label ">{{translate('language')}}</label>
        <div class="col-12">
            <select name="lang" class="form-control" id="lang">
                @foreach(\App\Model\Language::where('active', 1)->get() as $language)
                    <option value="{{$language->iso}}" > {{$language->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif
