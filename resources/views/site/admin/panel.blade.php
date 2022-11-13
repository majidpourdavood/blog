<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no"/>
    {{--<link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('/images/d12.png')}}">--}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

    <title> {{translate('User Panel')}}  @yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="geo.region" content="IR-07"/>
    <meta name="geo.placename" content="tehran"/>
    <meta name="geo.position" content="35.7192481,51.4226295"/>
    <meta name="ICBM" content="35.7192481,51.4226295"/>
    <?php
    $setting = \App\Model\Setting::where('key', 'versionCss')
        ->lang()->where('active', 1)->first();

    if (isset($setting)) {
        $versionCss = $setting->value;
    } else {
        $versionCss = '1.56';
    }
    ?>


    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if(app()->getLocale() == "en")
        <link rel="stylesheet" href="/css/app-en.css?v=<?php echo $versionCss;?>">
    @else
        <link rel="stylesheet" href="/css/app.css?v=<?php echo $versionCss;?>">
    @endif
    <link rel="stylesheet" href="/css/panel.css?v=<?php echo $versionCss;?>">
    <link rel="stylesheet" href="{{ asset('css/css-font/fontawesome-all.css?v=1.21') }}">
    <link href="/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('css/tree.css')}}">
    <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
    <link href="{{asset('css/jquery.md.bootstrap.datetimepicker.style.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/style_panel.css?v=<?php echo $versionCss;?>">

    @if(app()->getLocale() == "en")
        <link rel="stylesheet" href="/css/custom-en.css?v=<?php echo $versionCss;?>">
    @endif


    <script src=" {{ asset('js/sweetalert.min.js') }}"></script>
   @yield('css')

    <link href="/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css" rel="stylesheet">
    <script src="/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>

</head>
<body>


<div id='app'>
    @include('site.admin.sidebar')
    @include('sweet::alert')

</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>

<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{asset('js/jquery.md.bootstrap.datetimepicker.js')}}"></script>

<script>hljs.initHighlightingOnLoad();</script>

<script>



$('.created_at-text-label').MdPersianDateTimePicker({
        targetTextSelector: '#created_at-text',
        targetDateSelector: '#created_at-date',
        textFormat: 'yyyy-MM-dd HH:mm:ss',
        dateFormat: 'yyyy-MM-dd HH:mm:ss',
        isGregorian: false,
        enableTimePicker: true,
        calendarViewOnChange: function (date) {
            console.log(date);
        }
    });

    $('.year-text-label').MdPersianDateTimePicker({
        targetTextSelector: '#year-text',
        targetDateSelector: '#year-date',
        textFormat: 'yyyy-MM-dd',
        dateFormat: 'yyyy-MM-dd',
        isGregorian: false,
        enableTimePicker: true,
        calendarViewOnChange: function (date) {
            console.log(date);
        }
    });


    var english = {
        "sProcessing": "{{translate('Processing...')}}",
        "sEmptyTable": "{{translate('There is no data to display')}}",
        "sInfo": "{{translate('Display _START_ to _END_ of _TOTAL_ items')}}",
        "sInfoEmpty": "{{translate('Showing 0 to 0 of 0 items')}}",
        "sInfoFiltered": "(filtreret ud af _MAX_ rækker ialt)",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        "sLengthMenu": "{{translate('Display _MENU_ item')}}",
        "sLoadingRecords": "{{translate('Loading...')}}",
        "sSearch": "{{translate('Search :')}}",
        "sZeroRecords": "Ingen rækker matchede filter",
        "oPaginate": {
            "sFirst": "Første",
            "sLast": "Sidste",
            "sNext": "{{translate('next one')}}",
            "sPrevious": "{{translate('Previous')}}"
        },
        "oAria": {
            "sSortAscending": ": activate to sort column ascending",
            "sSortDescending": ": activate to sort column descending"
        }
    };

    $('#myTable').DataTable(
        {"oLanguage": english});

    CKEDITOR.replace('bodyAdmin', {
        autoParagraph: false,
        filebrowserUploadUrl: '/admin/upload-image?type=Images',
        filebrowserImageUploadUrl: '/admin/upload-image?type=Images',
        enterMode: CKEDITOR.ENTER_DIV,
        contentsLangDirection: "rtl",
        language: 'fa',
        // extraPlugins: ['video', 'pastecode', 'codesnippet'],
        // extraPlugins: 'codesnippet',
        extraPlugins: 'codesnippet',
        codeSnippet_theme : 'school_book',
        // shiftEnterMode: CKEDITOR.ENTER_P
    });

    CKEDITOR.replace('bodyAdmin2', {
        autoParagraph: false,
        filebrowserUploadUrl: '/admin/upload-image?type=Images',
        filebrowserImageUploadUrl: '/admin/upload-image?type=Images',
        enterMode: CKEDITOR.ENTER_DIV,
        contentsLangDirection: "rtl",
        language: 'fa'
        // shiftEnterMode: CKEDITOR.ENTER_P
    });


    $(".menu_panel_icon").click(function (e) {
        $(".sidenav").toggleClass("active");
        $(".main_content_panel").toggleClass("active");
        // $(".parent_logo_panel").toggleClass("active");
        $(".parent_menu_panel_icon").toggleClass("active");
        $(".parent_toggle_navbar").toggleClass("active");
        $("#accordion > li").toggleClass("active");
        $(".parent_profile_panel").toggleClass("display_none");
        $(this).toggleClass("active");
        e.preventDefault();

        if ($('.link_dropdown_panel').parent().find('ul').hasClass('show')) {
            $('.collapse').collapse('hide');
        }
    });

    $(".link_dropdown_panel ").click(function (e) {
        if ($('.sidenav').hasClass('active')) {
            $('[data-toggle=collapse]').prop('disabled', false);

            console.log("enabled");
        } else if (!$('.sidenav').hasClass('active')) {
            $('[data-toggle=collapse]').prop('disabled', true);
            console.log("disabled");
        }
        e.preventDefault();

    });

    (function ($) {

        $('#accordion >li').hover(function () {
            if (!$('.sidenav').hasClass('active')) {

                $(this).find('ul').addClass('hover_icon');
            }
        }, function () {
            if (!$('.sidenav').hasClass('active')) {
                $(this).find('ul').removeClass('hover_icon');
            }
        });

    })(jQuery);


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( ".menu_panel_icon" ).click();

    if ($(".collapse.show")) {
        $(".menu_panel_icon").click(function(e) {
            $('.collapse').collapse('hide');
            e.preventDefault();
        });
    }
</script>
@yield('script')

</body>




<div class="modal fade bd-example-modal-lg" id="location" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{ translate('Select province/city') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="message text-center ">

                </div>


                <div class="row col-12 justify-content-center list-location">


                </div>


                <div class="row col-12 justify-content-center">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary"
                            id="btnLocationSubmit">{{ translate('be saved') }}
                    </button>
                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<div class="modal  bd-example-modal-lg modal_upload_tarahi_anjam_shode uploadImageUserModal"
     id="uploadImageUserModal" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ShowFileDesignModalTitle">{{translate('Resize the image')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body parent_modal_image_user_upload">
                <div class="row parent_modal_image_user_upload">
                    <h2>{{translate('Adjust your image by dragging the scroll.')}}</h2>
                    <div id="image_demo"></div>

                </div>
                <div class="center_horizontal_vertical">
                    <button class="btn crop_image btn-success">{{ translate('upload') }}</button>

                </div>


            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/croppie.js') }}"></script>

<script>

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        enforceBoundary: false,
        enableResize: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        },

    });

    $('#upload_image_user').change(function (e) {

        var reader = new FileReader();
        reader.onload = function (event) {
            console.log(event);
            $image_crop.croppie('bind', {
                url: event.target.result,
                points: [77, 49, 680, 39],
                zoom: 900000
            }).then(function () {
                console.log('jQuery bind complete');

            });

        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadImageUserModal').modal('show');

    });

    $('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            console.log(response);

            $.ajax({
                url: "{{ action('View\ViewController@uploadImageUser') }}",
                type: "POST",
                data: {"image": response, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    console.log(data);
                    $('#uploadImageUserModal').modal('hide');
                    $('.image_user_panel_karbari img').attr("src", data.filename);
                    $('.parent_profile_panel_image img').attr("src", data.filename);

                }, error: function (err) {
                    console.log(err);
                }
            })
        });
    });


</script>


</html>
