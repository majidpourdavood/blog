@if(isset($models) && count($models) > 0 && isset($type) &&  $type == "image" )
    <h3 class="h3-layout"> {{translate('Selected images')}}</h3>
    <div class="row col-12 mt-3 mb-3 list-files-blog">
        @foreach($models as $modelA)
            <a href="javascript:void(0)" title="{{ $modelA->title }}"
               class="col-12 col-sm-12 col-md-6 col-lg-4"
               data-title="{{ $modelA->title }}"
               data-image="{{ $modelA->file }}"
            >
                <img class="img-fluid img-files-blog" src="{{ $modelA->file }}" alt="{{ $modelA->title }}">

            </a>
        @endforeach
    </div>
@elseif(isset($models) && count($models) > 0 && isset($type) && $type == "video" )
    <h3 class="h3-layout">  {{translate('Videos')}}</h3>
    <hr> <div class="row col-12 mt-3 mb-3 list-videos">


        @foreach($models as $key => $modelA)

            <div class="row col-12 list-link">
                <div class="col-12 col-12 col-md-6 col-lg-6 item">
                    <h3 class="">
                        {{$key+ 1}} . {{ $modelA->title }}
                    </h3>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 item">
                    <a class="btn btn-page-layout" target="_blank" href="{{ $modelA->file }}">
                        {{ translate('Download') }}
                    </a>
                </div>
            </div>

        @endforeach
    </div>
@elseif(isset($models)  && count($models) > 0 && isset($type) && $type == "link" )
    <h3 class="h3-layout">   {{translate('Videos')}}</h3>
    <hr>  <div class="row col-12 mt-3 mb-3 list-videos">


        @foreach($models as $key => $modelA)

            <div class="row col-12 list-link">
                <div class="col-12 col-12 col-md-6 col-lg-6 item">
                    <h3 class="">
                        {{$key+ 1}} . {{ $modelA->title }}
                    </h3>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 item">
                    <a class="btn btn-page-layout" target="_blank" href="{{ $modelA->file }}">
                        {{ translate('Download') }}

                    </a>
                </div>
            </div>

        @endforeach
    </div>
@else
 <div class="row col-12 mt-3 mb-3 list-files-blog">
        @foreach($models as $modelA)
            <a href="javascript:void(0)" title="{{ $modelA->title }}"
               class="col-12 col-sm-12 col-md-6 col-lg-4"
               data-title="{{ $modelA->title }}"
               data-image="{{ $modelA->file }}" >
                <img class="img-fluid img-files-blog" src="{{ $modelA->file }}" alt="{{ $modelA->title }}">
            </a>
        @endforeach
    </div>
@endif
