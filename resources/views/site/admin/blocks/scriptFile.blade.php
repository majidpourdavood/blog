@if(isset($model) && $model != null && $model != '')
    <script>


        var length = 0;
        var x = 2;

        length = $('.parent_input_file').find('.upload-btn-wrapper').length;

        $(document).on('click', '.icon_trash_image', function (e) {
            var id = $(this).data('id');
            // var str2 = $(this).parent().find('img').attr('src');

            let parent = $(this).parent();
            let _token = document.head.querySelector('meta[name="csrf-token"]').content;


            // alert(id);

            $.ajax({
                type: 'DELETE',
                url: '/delete-files/' + id,
                data: {
                    "_token": _token,
                    "id": id,
                },
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,

                success: function (data) {
                    console.log(data)
                    parent.remove();
                    // console.log(length);
                    length = length - 1;
                    // var myEle = document.getElementById("inputFileAdd");
                    if (length < 7 && $("[id^='upload-file']").length === 0) {
                        let id = "'upload-file-" + x + "'";
                        $('.parent_input_file').append('<div class="upload-btn-wrapper" id="inputFileAdd">' +
                            '<button class="btn" type="button"' +
                            'onclick="document.getElementById(' + id + ').click()">' +
                            '<i class="fas fa-plus"></i>' +
                            '<span class="span_btn_upload"> {{translate("Add photo")}}</span>' +
                            '</button>' +
                            '<input class="input_file" type="file" id="upload-file-' + x + '" name="file[]"/>' +
                            '</div>');
                        x++;
                        length--;
                    }
                    length = Math.abs(length);
                },
                error: function (data) {
                    console.log(data)

                    swal({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        button: data.button,
                        timer: 6000
                    });
                }
            });


        });
        $(document).on('change', '.parent_input_file .input_file', function (e) {

            console.log($(this)[0].files[0]);
            let wrapper = $(this);
            let _token = document.head.querySelector('meta[name="csrf-token"]').content;
            let file = $(this)[0].files[0];
            let formdata = new FormData();
            formdata.append('file', file);
            formdata.append('_token', _token);
            formdata.append('fileable_id', "{{$model->id}}");
            formdata.append('fileable_type', <?php echo json_encode(get_class($model)); ?>);
            $.ajax({
                method: 'post',
                url: "{{route('uploadFiles')}}",
                data: formdata,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
            })
                .done(function (data) {
                    console.log(data);

                    swal({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        button: data.button,
                        timer: 6000
                    });
                    wrapper.parent().html('<img class="img-fluid" src="' + data.file.file + '"/> <i class="fa fa-trash icon_trash_image" data-id="' + data.file.id + '"></i>');

                    if (length < 7 && $("[id^='upload-file']").length === 0) {
                        let id = "'upload-file-" + x + "'";
                        $('.parent_input_file').append('<div class="upload-btn-wrapper" id="inputFileAdd"> ' +
                            '<button class="btn" type="button"' +
                            'onclick="document.getElementById(' + id + ').click()">' +
                            '<i class="fas fa-plus"></i>' +
                            '<span class="span_btn_upload"> {{translate("Add photo")}}</span>' +
                            '</button>' +
                            '<input class="input_file" type="file" id="upload-file-' + x + '" name="file[]"/>' +
                            '</div>');
                        x++;
                        length++;
                    }

                    // console.log(imageContainer);

                }).fail(function (data) {
                console.log(data);
                swal({
                    title: data.title,
                    text: data.text,
                    icon: data.icon,
                    button: data.button,
                    timer: 6000
                });
            });
        })


    </script>
@else

    <script>


        let imageContainer = [];
        var length = 0;
        var x = 2;

        length = $('.parent_input_file').find('.upload-btn-wrapper').length;

        $(document).on('click', '.icon_trash_image', function (e) {
            var str1 = $('#images').val();
            var str2 = $(this).parent().find('img').attr('src');
            if (str1.indexOf(str2) != -1) {
                str1 = str1.replace(str2, '');
            }
            var str1 = $('#images').val(str1);
            $(this).parent().remove();
            imageContainer.pop(str1);

            // console.log(length);
            length = length - 1;
            // var myEle = document.getElementById("inputFileAdd");
            if (length < 7 && imageContainer.length < 4 && $("[id^='upload-file']").length === 0) {
                let id = "'upload-file-" + x + "'";
                $('.parent_input_file').append('<div class="upload-btn-wrapper" id="inputFileAdd">' +
                    '<button class="btn" type="button"' +
                    'onclick="document.getElementById(' + id + ').click()">' +
                    '<i class="fas fa-plus"></i>' +
                    '<span class="span_btn_upload"> {{translate("Add photo")}}</span>' +
                    '</button>' +
                    '<input class="input_file" type="file" id="upload-file-' + x + '" name="file[]"/>' +
                    '</div>');
                x++;
                length--;
            }
            length = Math.abs(length);
            console.log(document.getElementById("inputFileAdd"));
            console.log(imageContainer.length);
            console.log(length);
        });

        $(document).on('change', '.parent_input_file .input_file', function (e) {

            console.log($(this)[0].files[0]);
            let wrapper = $(this);
            let _token = document.head.querySelector('meta[name="csrf-token"]').content;
            let file = $(this)[0].files[0];
            let formdata = new FormData();
            formdata.append('file', file);
            formdata.append('_token', _token);
            console.log(formdata);
            console.log(file);
            $.ajax({
                method: 'post',
                url: "{{route('uploadFileAll')}}",
                data: formdata,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
            })
                .done(function (data) {
                    console.log(data);
                    wrapper.parent().html('<img class="img-fluid" src="' + data.filename + '"/> <i class="fa fa-trash icon_trash_image"></i>');
                    imageContainer.push(data.filename);
                    console.log(imageContainer);
                    $('#images').val(imageContainer);
                    // console.log($('.parent_input_file').find('.upload-btn-wrapper').length);
                    // console.log(length);
                    if (length < 7 && imageContainer.length < 4 && $("[id^='upload-file']").length === 0) {
                        let id = "'upload-file-" + x + "'";
                        $('.parent_input_file').append('<div class="upload-btn-wrapper" id="inputFileAdd"> ' +
                            '<button class="btn" type="button"' +
                            'onclick="document.getElementById(' + id + ').click()">' +
                            '<i class="fas fa-plus"></i>' +
                            '<span class="span_btn_upload"> {{translate("Add photo")}} </span>' +
                            '</button>' +
                            '<input class="input_file" type="file" id="upload-file-' + x + '" name="file[]"/>' +
                            '</div>');
                        x++;
                        length++;
                    }

                    // console.log(imageContainer);

                }).fail(function (data) {
                console.log(data);

            });
        })

    </script>
@endif
