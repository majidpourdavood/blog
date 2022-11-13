<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('site.layout.head')

<body>

@include('site.layout.header')
@include('sweet::alert')

<section class="section_content">
    @yield('content')
</section>

@include('site.layout.footer')
@include('site.layout.script')
@yield('script')

<style>

    .h_iframe-aparat_embed_frame {
        position: relative;
    }

    .h_iframe-aparat_embed_frame .ratio {
        display: block;
        width: 100%;
        height: auto;
    }

    .h_iframe-aparat_embed_frame iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .h_iframe-aparat_embed_frame >span {
        display: block;padding-top: 57%
    }

</style>


</body>

<div class="modal fade bd-example-modal-lg" id="imagePermissions" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{translate('License')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-12 parent-image-permissions">
                    <img class="img-fluid" src="" alt="">

                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


</html>


