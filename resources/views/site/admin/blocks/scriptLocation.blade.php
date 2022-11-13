<div class="modal fade bd-example-modal-lg" id="location" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{translate('Select province/city')}}</h5>
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
                            id="btnLocationSubmit">
                        {{translate('be saved')}}
                    </button>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@if(isset($model) && $model != null && $model != '')
    <script>


        $(function () {
            $(document).on('change', '.select-location', function () {
                var id = $(this).val();
                var children = $(this).find('option:selected').data('children');
                $(this).parent().parent().parent().nextAll('.item').remove();

                console.log(id);
                console.log(children);
                if (children == "1") {
                    $.ajax({
                        url: '/getLocationAjax/' + id,
                        method: 'GET',
                    })
                        .done(function (data) {

                            console.log(data);
                            var xxxx = '';
                            var oModalEdit = $('#location');
                            var level = oModalEdit.find(".item").length;
                            var position = "";
                            switch (level) {
                                case 0:
                                    position = "{{translate('province')}}";
                                    break;
                                case 1:
                                    position = "{{translate('city')}}";
                                    break;
                                case 2:
                                    position = "{{translate('city')}}";
                                    break;
                                default:
                                    position = "{{translate('city')}}";
                            }

                            console.log(level);
                            console.log(data.children);


                            // oModalEdit.find('.list-location').html("");
                            var table = '';
                            $.each(data.locations, function (idx, obj) {
                                table += (
                                    '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                                );
                            });
                            xxxx += ('<div class="row col-12 justify-content-center item ">' +
                                '<div class="form-group col-7 pb-3 row">' +
                                '<label for="location_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                                '<div class="col-12">' +
                                '<select  class="form-control select-location"  name="location_id"  id="location_id">' +
                                '<option value="0" data-children="0">{{translate("Select")}} </option>' +
                                table +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            xxxx += '';
                            oModalEdit.find('.list-location').append(xxxx);

                            oModalEdit.modal();

                        })
                        .fail(function (data) {
                            console.log(data);
                        });
                }
                // else{
                //     alert(children);
                // }
            });
        });
        $(document).on('hidden.bs.modal', '#location', function () {

            var html = "";
            var input = "";

            var values = $(this).find('.list-location .item select option:selected').each(function (i, e) {

                if (e.value == 0) {
                    // html =  html + e.text;
                } else if (e.value != 0 && e.dataset.children == 1) {
                    html = html + e.text + ">";
                } else if (e.value != 0 && e.dataset.children == 0) {
                    html = html + e.text;
                    // $('.btn-modal-location').find('');
                    input = "<input type='hidden' name='location_id' value=" + e.value + ">";
                }

            });

            $('.btn-modal-location').html(input + html);

        });
        $(document).on('click', '.btn-modal-location', function (e) {
            e.preventDefault();

            var locationInput = $(this).find('input').val();
            var locationInputValue = $.isNumeric(locationInput);

            if (!locationInputValue) {
                $.ajax({
                    url: '/getLocationAjax/' + 0,
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var oModalEdit = $('#location');
                        oModalEdit.find('.list-location').html("");
                        var level = oModalEdit.find(".item").length;
                        var position = "";
                        switch (level) {
                            case 0:
                                position = "{{translate('province')}}";
                                break;
                            case 1:
                                position = "{{translate('city')}}";
                                break;
                            case 2:
                                position = "{{translate('city')}}";
                                break;
                            default:
                                position = "{{translate('city')}}";
                        }

                        console.log(level);

                        var table = '';
                        $.each(data.locations, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        oModalEdit.find('.list-location').html(xxxx);
                        oModalEdit.modal();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            } else {

                $.ajax({
                    url: '/getLocationAjax/' + locationInput,
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var xxxx2 = '';
                        var oModalEdit = $('#location');
                        oModalEdit.find('.list-location').html("");
                        var level = oModalEdit.find(".item").length;

                        var table = '';
                        $.each(data.locations, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> {{translate('province')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );


                        var table2 = '';
                        $.each(data.childes, function (idx, obj) {
                            table2 += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx2 += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> {{translate('city')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table2 +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );


                        xxxx += '';
                        xxxx2 += '';
                        oModalEdit.find('.list-location').html(xxxx  + xxxx2);
                        oModalEdit.modal();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });


            }

        });

    </script>
@else

    <script>

        $(function () {
            $(document).on('change', '.select-location', function () {
                var id = $(this).val();
                var children = $(this).find('option:selected').data('children');
                $(this).parent().parent().parent().nextAll('.item').remove();

                console.log(id);
                console.log(children);
                if (children == "1") {
                    $.ajax({
                        url: '/getLocationAjax/' + id,
                        method: 'GET',
                    })
                        .done(function (data) {

                            console.log(data);
                            var xxxx = '';
                            var oModalEdit = $('#location');
                            var level = oModalEdit.find(".item").length;
                            var position = "";
                            switch (level) {
                                case 0:
                                    position = "{{translate('province')}}";
                                    break;
                                case 1:
                                    position = "{{translate('city')}}";
                                    break;
                                case 2:
                                    position = "{{translate('city')}}";
                                    break;
                                default:
                                    position = "{{translate('city')}}";
                            }

                            console.log(level);
                            console.log(data.children);


                            // oModalEdit.find('.list-location').html("");
                            var table = '';
                            $.each(data.locations, function (idx, obj) {
                                table += (
                                    '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                                );
                            });
                            xxxx += ('<div class="row col-12 justify-content-center item ">' +
                                '<div class="form-group col-7 pb-3 row">' +
                                '<label for="location_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                                '<div class="col-12">' +
                                '<select  class="form-control select-location"  name="location_id"  id="location_id">' +
                                '<option value="0" data-children="0">{{translate("Select")}} </option>' +
                                table +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            xxxx += '';
                            oModalEdit.find('.list-location').append(xxxx);

                            oModalEdit.modal();

                        })
                        .fail(function (data) {
                            console.log(data);
                        });
                }
                // else{
                //     alert(children);
                // }
            });
        });
        $(document).on('hidden.bs.modal', '#location', function () {

            var html = "";
            var input = "";
            var values = $(this).find('.list-location .item select option:selected').each(function (i, e) {

                if (e.value == 0) {
                    // html =  html + e.text;
                } else if (e.value != 0 && e.dataset.children == 1) {
                    html = html + e.text + ">";
                } else if (e.value != 0 && e.dataset.children == 0) {
                    html = html + e.text;
                    input = "<input type='hidden' name='location_id' value=" + e.value + ">";
                }
            });



            $('.btn-modal-location').html(input + html);

        });
        $(document).on('click', '.btn-modal-location', function (e) {
            e.preventDefault();

            var locationInput = $(this).find('input').val();
            var locationInputValue = $.isNumeric(locationInput);

            if (!locationInputValue) {
                $.ajax({
                    url: '/getLocationAjax/' + 0,
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var oModalEdit = $('#location');
                        oModalEdit.find('.list-location').html("");
                        var level = oModalEdit.find(".item").length;
                        var position = "";
                        switch (level) {
                            case 0:
                                position = "{{translate('province')}}";
                                break;
                            case 1:
                                position = "{{translate('city')}}";
                                break;
                            case 2:
                                position = "{{translate('city')}}";
                                break;
                            default:
                                position = "{{translate('city')}}";
                        }

                        console.log(level);

                        var table = '';
                        $.each(data.locations, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        oModalEdit.find('.list-location').html(xxxx);
                        oModalEdit.modal();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            } else {

                $.ajax({
                    url: '/getLocationAjax/' + locationInput,
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var xxxx2 = '';
                        var xxxx3 = '';
                        var oModalEdit = $('#location');
                        oModalEdit.find('.list-location').html("");
                        var level = oModalEdit.find(".item").length;

                        var table = '';
                        $.each(data.locations, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> {{translate('province')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );





                        var table2 = '';
                        $.each(data.childes, function (idx, obj) {
                            table2 += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx2 += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="location_id" class="col-form-label text-md-right"> {{translate('city')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-location" onclick="" name="location_id"  id="location_id">' +
                            '<option value="0" onclick="">{{translate("Select")}} </option>' +
                            table2 +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );


                        xxxx += '';
                        xxxx2 += '';

                        oModalEdit.find('.list-location').html(xxxx + xxxx2 );
                        oModalEdit.modal();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });


            }

        });

    </script>
@endif
