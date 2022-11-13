<div class="modal fade bd-example-modal-lg" id="category" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{translate('Select category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="message text-center ">

                </div>


                <div class="row col-12 justify-content-center list-category">


                </div>


                <div class="row col-12 justify-content-center">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary"
                            id="btnCategorySubmit">{{translate('be saved')}}
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
            $(document).on('change', '.select-category', function () {
                var id = $(this).val();
                var children = $(this).find('option:selected').data('children');
                $(this).parent().parent().parent().nextAll('.item').remove();

                console.log(id);
                console.log(children);
                if (children == "1") {
                    $.ajax({
                        url: '/getCategoryAjax/' + id + "?type=<?php echo $type; ?>",
                        method: 'GET',
                    })
                        .done(function (data) {


                            console.log(data);
                            var xxxx = '';
                            var oModalEdit = $('#category');
                            var level = oModalEdit.find(".item").length;
                            var position = "";
                            switch (level) {
                                case 0:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                case 1:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                case 2:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                default:
                                    position = "{{translate('Grouping')}}";
                            }

                            console.log(level);
                            console.log(data.children);


                            // oModalEdit.find('.list-category').html("");
                            var table = '';
                            $.each(data.categories, function (idx, obj) {
                                table += (
                                    '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                                );
                            });
                            xxxx += ('<div class="row col-12 justify-content-center item ">' +
                                '<div class="form-group col-7 pb-3 row">' +
                                '<label for="category_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                                '<div class="col-12">' +
                                '<select  class="form-control select-category"  name="category_id"  id="category_id">' +
                                '<option value="0" data-children="0">{{translate('Select')}} </option>' +
                                table +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            xxxx += '';
                            oModalEdit.find('.list-category').append(xxxx);
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
        $(document).on('hidden.bs.modal', '#category', function () {
            // e.preventDefault();
            var html = "";
            var input = "";

            var values = $(this).find('.list-category .item select option:selected').each(function (i, e) {
                console.log(i);
                console.log(e);
                console.log(e.text);
                console.log(e.dataset.children);

                if (e.value == 0) {
                    // html =  html + e.text;
                } else if (e.value != 0 && e.dataset.children == 1) {
                    html = html + e.text + ">";
                } else if (e.value != 0 && e.dataset.children == 0) {
                    html = html + e.text;
                    input = "<input type='hidden' name='category_id' value=" + e.value + ">";
                }
            });


            $('.btn-modal-category').html(input + html);

        });
        $(document).on('click', '.btn-modal-category', function (e) {
            e.preventDefault();

            var categoryInput = $(this).find('input').val();
            var categoryInputValue = $.isNumeric(categoryInput);

            if (!categoryInputValue) {
                $.ajax({
                    url: '/getCategoryAjax/' + 0 + "?type=<?php echo $type; ?>",
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var oModalEdit = $('#category');
                        oModalEdit.find('.list-category').html("");
                        var level = oModalEdit.find(".item").length;
                        var position = "";
                        switch (level) {
                            case 0:
                                position = "{{translate('Grouping')}}";
                                break;
                            case 1:
                                position = "{{translate('Grouping')}}";
                                break;
                            case 2:
                                position = "{{translate('Grouping')}}";
                                break;
                            default:
                                position = "{{translate('Grouping')}}";
                        }

                        console.log(level);


                        var table = '';
                        $.each(data.categories, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="category_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">{{translate('Select')}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        oModalEdit.find('.list-category').html(xxxx);

                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            } else {

                $.ajax({
                    url: '/getCategoryAjax/' + categoryInput + "?type=<?php echo $type; ?>",
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var xxxx2 = '';
                        var oModalEdit = $('#category');
                        oModalEdit.find('.list-category').html("");
                        var level = oModalEdit.find(".item").length;

                        var table = '';
                        $.each(data.categories, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="category_id" class="col-form-label text-md-right"> {{translate('Grouping')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">{{translate('Select')}} </option>' +
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
                            '<label for="category_id" class="col-form-label text-md-right"> {{translate('Grouping')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">{{translate('Select')}} </option>' +
                            table2 +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        xxxx2 += '';
                        oModalEdit.find('.list-category').html(xxxx + xxxx2);
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
            $(document).on('change', '.select-category', function () {
                var id = $(this).val();
                var children = $(this).find('option:selected').data('children');
                $(this).parent().parent().parent().nextAll('.item').remove();

                console.log(id);
                console.log(children);
                if (children == "1") {
                    $.ajax({
                        url: '/getCategoryAjax/' + id + "?type=<?php echo $type; ?>",
                        method: 'GET',
                    })
                        .done(function (data) {


                            console.log(data);
                            var xxxx = '';
                            var oModalEdit = $('#category');
                            var level = oModalEdit.find(".item").length;
                            var position = "";
                            switch (level) {
                                case 0:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                case 1:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                case 2:
                                    position = "{{translate('Grouping')}}";
                                    break;
                                default:
                                    position = "{{translate('Grouping')}}";
                            }

                            console.log(level);
                            console.log(data.children);


                            // oModalEdit.find('.list-category').html("");
                            var table = '';
                            $.each(data.categories, function (idx, obj) {
                                table += (
                                    '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                                );
                            });
                            xxxx += ('<div class="row col-12 justify-content-center item ">' +
                                '<div class="form-group col-7 pb-3 row">' +
                                '<label for="category_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                                '<div class="col-12">' +
                                '<select  class="form-control select-category"  name="category_id"  id="category_id">' +
                                '<option value="0" data-children="0">{{translate('Select')}} </option>' +
                                table +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            xxxx += '';
                            oModalEdit.find('.list-category').append(xxxx);
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
        $(document).on('hidden.bs.modal', '#category', function () {
            // e.preventDefault();
            var html = "";
            var input = "";

            var values = $(this).find('.list-category .item select option:selected').each(function (i, e) {

                if (e.value == 0) {
                    // html =  html + e.text;
                } else if (e.value != 0 && e.dataset.children == 1) {
                    html = html + e.text + ">";
                } else if (e.value != 0 && e.dataset.children == 0) {
                    html = html + e.text;
                    input = "<input type='hidden' name='category_id' value=" + e.value + ">";
                }
            });

            $('.btn-modal-category').html(input + html);

        });
        $(document).on('click', '.btn-modal-category', function (e) {
            e.preventDefault();

            var categoryInput = $(this).find('input').val();
            var categoryInputValue = $.isNumeric(categoryInput);

            if (!categoryInputValue) {
                $.ajax({
                    url: '/getCategoryAjax/' + 0 + "?type=<?php echo $type; ?>",
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var oModalEdit = $('#category');
                        oModalEdit.find('.list-category').html("");
                        var level = oModalEdit.find(".item").length;
                        var position = "";
                        switch (level) {
                            case 0:
                                position = "{{translate('Grouping')}}";
                                break;
                            case 1:
                                position = "{{translate('Grouping')}}";
                                break;
                            case 2:
                                position = "{{translate('Grouping')}}";
                                break;
                            default:
                                position = "{{translate('Grouping')}}";
                        }

                        console.log(level);


                        var table = '';
                        $.each(data.categories, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '"> ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="category_id" class="col-form-label text-md-right"> ' + position + ' </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">{{translate('Select')}} </option>' +
                            table +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        oModalEdit.find('.list-category').html(xxxx);

                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            } else {

                $.ajax({
                    url: '/getCategoryAjax/' + categoryInput + "?type=<?php echo $type; ?>",
                    method: 'GET',
                })
                    .done(function (data) {

                        console.log(data);
                        var xxxx = '';
                        var xxxx2 = '';
                        var oModalEdit = $('#category');
                        oModalEdit.find('.list-category').html("");
                        var level = oModalEdit.find(".item").length;

                        var table = '';
                        $.each(data.categories, function (idx, obj) {
                            table += (
                                '<option value="' + obj.id + '" data-children="' + obj.children + '" ' + obj.selected + ' > ' + obj.name + '</option>'
                            );
                        });
                        xxxx += ('<div class="row col-12 justify-content-center item ">' +
                            '<div class="form-group col-7 pb-3 row">' +
                            '<label for="category_id" class="col-form-label text-md-right"> {{translate('Grouping')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">{{translate('Select')}} </option>' +
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
                            '<label for="category_id" class="col-form-label text-md-right"> {{translate('Grouping')}} </label>' +
                            '<div class="col-12">' +
                            '<select  class="form-control select-category" onclick="" name="category_id"  id="category_id">' +
                            '<option value="0" onclick="">'+ {{translate('Select')}}+' </option>' +
                            table2 +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        xxxx += '';
                        xxxx2 += '';
                        oModalEdit.find('.list-category').html(xxxx + xxxx2);
                        oModalEdit.modal();
                    })
                    .fail(function (data) {
                        console.log(data);
                    });


            }

        });

    </script>
@endif
