@if(isset($model) && $model != null && $model != '')
    <div class="row col-12 col-sm-12 col-md-2 col-lg-12 mt-2 mb-4 item">
        <div class="input-group ">

            <label for="created_at-text-label"
                   class="col-12 control-label text-right">
                {{translate('the date of creation')}}
                <span class="color-required">*</span>
            </label>
            <div class="input-group-prepend">
            <span class="input-group-text cursor-pointer created_at-text-label">
{{translate('the date of creation')}}
            </span>
            </div>
            <input type="text" class="form-control created_at-text-label"
                   placeholder="" id="created_at-text"
                   value="{{ old('created_at',convert(jdate($model->created_at)->format('Y-m-d H:i:s')))  }}"
            >
            <input type="hidden" id="created_at-date"
                   class="form-control {{ $errors->has('created_at') ? ' is-invalid' : '' }}"
                   placeholder=""
                   name="created_at"
                   value="{{ old('created_at' ,$model->created_at)  }}"
                   aria-label="created_at-date"
                   aria-describedby="created_at-date">
            @if ($errors->has('created_at'))
                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('created_at') }}</strong>
                                                         </span>
            @endif
        </div>
    </div>
@else
    <div class="row col-12 col-sm-12 col-md-2 col-lg-12 mt-2 mb-4 item">
        <div class="input-group ">

            <label for="created_at-text-label"
                   class="col-12 control-label text-right">
                {{translate('the date of creation')}}
                <span class="color-required">*</span>
            </label>
            <div class="input-group-prepend">
                                                    <span class="input-group-text cursor-pointer created_at-text-label"
                                                    >
{{translate('the date of creation')}}
                                                    </span>
            </div>
            <input type="text" class="form-control created_at-text-label"
                   placeholder="" id="created_at-text"
                   value="{{ old('created_at')  }}"
            >
            <input type="hidden" id="created_at-date"
                   class="form-control {{ $errors->has('created_at') ? ' is-invalid' : '' }}"
                   placeholder=""
                   name="created_at"
                   value="{{ old('created_at')  }}"
                   aria-label="created_at-date"
                   aria-describedby="created_at-date">
            @if ($errors->has('created_at'))
                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('created_at') }}</strong>
                                                         </span>
            @endif
        </div>
    </div>
@endif
