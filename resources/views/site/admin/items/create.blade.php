@section('title' , ' | ' . translate('item creation'))
@section('description' , '')
@extends('site.admin.panel')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

@endsection
@section('content')

    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="btn " href="#">{{ translate('item creation') }}</a></li>
                        </ol>
                    </nav>
                </li>
                @include('site.layout.clock-time')
            </ul>
        </div>

        <div class="row col-12 content_panel_layout">
            <div class=" col-12">
                @if(isset($model->items) && count($model->items) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover auto-index" id="myTable">
                            <thead class="thead-light">
                            <tr>
                                <?php $i = 1;  ?>
                                <th width="5%">{{ translate('Row') }}</th>
                                <th width="15%">{{ translate('Title') }}</th>
                                <th width="15%">{{ translate('Short description') }}</th>
                                <th width="10%">{{ translate('status') }}</th>
                                <th width="10%">{{ translate('type') }}</th>
                                <th width="10%">{{ translate('the date of creation') }}</th>
                                <th width="35%">{{ translate('Settings') }}</th>
                            </tr>
                            </thead>
                            <tbody class="row_position">
                            @foreach($model->items()->orderBy('sort', 'asc')->get() as $model)
                                <tr id="<?php echo $model->id ?>">
                                    <td>   {{$i++}}</td>
                                    <td>{{ $model->title }}</td>
                                    <td><?php echo strip_tags(words($model->description, 20, '...'));?></td>

                                    <td>
                                        @if ($model->active == 0)
                                            {{ translate('Inactive') }}
                                        @elseif ($model->active == 1)
                                            {{ translate('active') }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($model->type == 0)
                                        {{translate('Question')}}
                                        @elseif ($model->type == 1)
                                            {{translate('Text')}}
                                        @endif
                                    </td>
                                    <td>{{ $model->created_at }}</td>
                                    <td>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <form action="{{ route('deleteItem'  , [ $model->id]) }}"
                                                      method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <div class="btn_group ">
                                                        <a href="{{ route('editItem' , [ $model->id]) }}"
                                                           title="{{ translate('Edit') }}" class="btn btn-outline-warning">
                                                            <i class="fas fa-edit"></i></a>

                                                        <button type="submit" class="btn  btn-outline-danger"
                                                                onclick="return  confirm('{{translate('Do you want to delete the item?')}}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif

                <h1>{{ translate('item creation') }}</h1>
                @include('site.layout.flash-message')

                <form class="form-horizontal form_panel"
                      action="{{ route('storeItem') }}" method="post"
                      enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}

                    <input type="hidden" name="itemable_id" class="form-control" id="itemable_id"
                           value="{{ request('itemable_id') }}" placeholder="">

                    <input type="hidden" name="itemable_type" class="form-control" id="itemable_type"
                           value="{{ request('itemable_type') }}" placeholder="">

                    <div class=" row one">
                        <label for="title" class="col-12 control-label text-right">{{ translate('Title') }} </label>
                        <div class="col-12">
                            <input type="text" name="title" class="form-control" id="title"
                                   value="{{ old('title') }}" placeholder="{{ translate('Title') }} ">
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="type" class="col-12 control-label text-right">{{ translate('type') }}</label>
                        <div class="col-12">
                            <select name="type" class="form-control" value="{{ old('type') }}" id="type">
                                <option value="1">{{ translate('Text') }}</option>
                                <option value="0">{{ translate('Question') }}</option>
                            </select>
                        </div>
                    </div>


                    <div class=" row one parent-body-admin">
                        <label for="bodyAdmin" class="col-12 control-label text-right">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="bodyAdmin" class="form-control" id="bodyAdmin" rows="7"
                              placeholder="{{ translate('Short description') }} ">{{ old('bodyAdmin') }}</textarea>
                        </div>
                    </div>

                    <div class=" row one parent-body-description">
                        <label for="description" class="col-12 control-label text-right">
                            {{ translate('Short description') }}</label>
                        <div class="col-12">
                    <textarea type="text" name="description" class="form-control" id="description" rows="7"
                              placeholder="{{ translate('Short description') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>


                    <div class=" row one">
                        <label for="active" class="col-12 col-form-label text-md-right">{{ translate('status') }}</label>
                        <div class="col-12">
                            <select name="active" class="form-control" value="{{ old('active') }}" id="">
                                <option value="1"> {{ translate('active') }}</option>
                                <option value="0">{{ translate('Inactive') }}</option>
                            </select>
                        </div>
                    </div>


                    <div class=" row one">
                        <label class="col-12 control-label text-right"></label>
                        <div class="col-12">

                            <button type="submit" class="btn btn-primary">
                                {{ translate('Store') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/select2.min.js') }}"></script>
    <script src=" {{ asset('js/jquery.validate.min.js') }}"></script>

    <script>


        $('#type').change(function () {
            var type = $(this).val();
            // alert(residencyType);
            if (type == 1) {
                $('.parent-body-admin').show();
                $('.parent-body-description').hide();

            } else {
                $('.parent-body-admin').hide();
                $('.parent-body-description').show();
            }
        });

        $(function () {
            // $('#residencyType').change(function () {
            var type = $('#type').find('option:selected').val();

            // alert(residencyType);
            if (type == 1) {
                $('.parent-body-admin').show();
                $('.parent-body-description').hide();

            } else {
                $('.parent-body-admin').hide();
                $('.parent-body-description').show();  }
            // });
        });


        $(".row_position").sortable({
            delay: 150,
            stop: function () {
                var selectedData = new Array();
                $('.row_position>tr').each(function () {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });


        function updateOrder(data) {
            $.ajax({
                url: "{{ route('sortableItem') }}",
                type: "POST",
                data: {sort: data, "_token": "{{ csrf_token() }}"}
            }).done(function (data) {
                console.log(data)
            }).fail(function (data) {
                console.log(data)
            });
        }




    </script>
@endsection
