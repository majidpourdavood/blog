@if ($message = Session::get('success'))
    <div class="container">
        <div class="row m-0">
            <div class="col-xs-12 col-sm-12 p-0">
                <div class="alert alert-success alert-dismissible style_alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="container">
        <div class="row m-0">
            <div class="col-xs-12 col-sm-12 p-0">
                <div class="alert alert-danger alert-dismissible style_alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="container">
        <div class="row m-0">
            <div class="col-xs-12 col-sm-12 p-0">
                <div class="alert alert-warning alert-dismissible style_alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="container">
        <div class="row m-0">
            <div class="col-xs-12 col-sm-12 p-0">
                <div class="alert alert-info alert-dismissible style_alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@endif






@if ($errors->any())
    <div class="container">
        <div class="row m-0 ">
            <div class="col-xs-12 col-sm-12 p-0">
                <div class="alert alert-danger alert-dismissible fade show style_alert" role="alert">

                    @if(count($errors) > 0)
                        <ul class="list-unstyled list_unstyled_mesage">
                            @foreach($errors->all() as $error)
                                <li class="text-right ">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ $message }}
                </div>
            </div>
        </div>
    </div>
@endif