@if(isset($model) && $model != null && $model != '')
    <div class="row col-12 col-sm-12 col-md-2 col-lg-12 mt-2 mb-4 item">
        <div class="input-group ">

            <label for="year-text-label"
                   class="col-12 control-label text-right">
                {{translate('Date of the year')}}
                <span class="color-required">*</span>
            </label>
            <div class="input-group-prepend">
            <span class="input-group-text cursor-pointer year-text-label" >
{{translate('Date of the year')}}
            </span>
            </div>
            <input type="text" class="form-control year-text-label"
                   placeholder="" id="year-text"
                   value="{{ old('year',convert(jdate($model->year)->format('Y')))  }}"
            >
            <input type="hidden" id="year-date"
                   class="form-control {{ $errors->has('year') ? ' is-invalid' : '' }}"
                   placeholder=""
                   name="year"
                   value="{{ old('year' ,$model->year)  }}"
                   aria-label="year-date"
                   aria-describedby="year-date">
            @if ($errors->has('year'))
                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('year') }}</strong>
                                                         </span>
            @endif
        </div>
    </div>
@else
    <div class="row col-12 col-sm-12 col-md-2 col-lg-12 mt-2 mb-4 item">
        <div class="input-group ">

            <label for="year-text-label"
                   class="col-12 control-label text-right">
                {{translate('Date of the year')}}
                <span class="color-required">*</span>
            </label>
            <div class="input-group-prepend">
                                                    <span class="input-group-text cursor-pointer year-text-label"
                                                    >
{{translate('Date of the year')}}
                                                    </span>
            </div>
            <input type="text" class="form-control year-text-label"
                   placeholder="" id="year-text"
                   value="{{ old('year')  }}"
            >
            <input type="hidden" id="year-date"
                   class="form-control {{ $errors->has('year') ? ' is-invalid' : '' }}"
                   placeholder=""
                   name="year"
                   value="{{ old('year')  }}"
                   aria-label="year-date"
                   aria-describedby="year-date">
            @if ($errors->has('year'))
                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('year') }}</strong>
                                                         </span>
            @endif
        </div>
    </div>
@endif
