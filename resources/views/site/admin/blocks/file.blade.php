@if(isset($model) && $model != null && $model != '')
    <div class=" row one col-12">
    <?php
        $files = $model->files()->whereIn('type', [0,2])->get();
    ?>
    <div class="alert alert-info col-12 p-2" role="alert">
        <strong>{{translate('gallery')}}</strong>
    </div>

    <div class="form-group parent_input_file">
        @if(isset($files))
            @foreach($files as $fileA)

                <div class="upload-btn-wrapper">
                    <img class="img-fluid" src="{{$fileA->file}}" alt="">
                    <i class="fa fa-trash icon_trash_image"
                       data-id="{{$fileA->id}}"
                    ></i>
                </div>
            @endforeach
        @endif
        <div class="upload-btn-wrapper">
            <button class="btn" type="button"
                    onclick="document.getElementById('upload-file-1').click()">
                <i class="fas fa-plus"></i>
                <span class="span_btn_upload"> {{translate('Add photo')}}</span>

            </button>
            <input class="input_file" type="file" id="upload-file-1"
                   name="file"/>
        </div>

    </div>

    </div>

@else

    <div class=" row one col-12">
        <div class="alert alert-info col-12 p-2" role="alert">
            <strong>گالری</strong>
        </div>
        <div class="form-group parent_input_file">
            <div class="upload-btn-wrapper">
                <button class="btn" type="button"
                        onclick="document.getElementById('upload-file-1').click()">
                    <i class="fas fa-plus"></i>
                    <span class="span_btn_upload"> {{translate('Add photo')}}</span>

                </button>
                <input class="input_file" type="file" id="upload-file-1" />
            </div>

        </div>
        <input type="hidden" id="images" name="images" value="">
    </div>
@endif
