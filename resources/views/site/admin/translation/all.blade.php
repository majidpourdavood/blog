@section('title' , ' | ' . translate('Translations'))
@section('description' , '')
@extends('site.admin.panel')

@section('content')
    <div class="container">
        <div class="row col-12 parent_breadcrumb_panel_top">
            <ul class="list-inline row col-12">
                <li class="list-inline-item col">
                    <nav class="breadcrumb_panel_top" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('translation.create') }}" class="btn btn_create"
                                   title="{{translate('Add translation')}}">
                                    <i class="fas fa-plus"></i> {{translate('Translation')}}</a>
                            </li>
                        </ol>
                    </nav>
                </li>

                @include('site.layout.clock-time')


            </ul>
        </div>


        <div class="row col-12 content_panel_layout">
            <div class="col-12 ">

                <div class="table-responsive">
                    <table class="table table-striped table-hover auto-index" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <?php $i = ($translations->perPage() * ($translations->currentPage() - 1)) + 1;  ?>
                            <th width="5%">{{ translate('Row') }}</th>
                            <th width="15%">{{ translate('name') }}</th>
                            <th width="15%">{{translate('Key')}}</th>
                            <th width="15%">{{translate('value')}}</th>
                            <th width="10%">{{translate('translation')}}</th>
                            <th width="15%"> {{ translate('the date of creation') }}</th>
                            <th width="25%">{{ translate('Settings') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($translations as $translation)
                            <tr>
                                <td>   {{$i++}}</td>

                                <td>{{ $translation->name }}</td>
                                <td>{{ $translation->key }}</td>
                                <td>{{ $translation->value }}</td>

                                <td>{{ $translation->lang }}</td>
                                <td>{{ $translation->created_at }}</td>


                                <td>


                                    <ul class="list-inline">

                                        <li class="list-inline-item">
                                            <form action="{{ route('translation.destroy'  , [ $translation->id]) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="btn_group ">
                                                    <a href="{{ route('translation.edit' , [ $translation->id]) }}"
                                                       class="btn btn-outline-warning" title="{{ translate('Edit') }}">
                                                        <i class="fas fa-edit"></i></a>
                                                    <button type="submit" class="btn  btn-outline-danger"
                                                            onclick="return  confirm('{{translate('Do you want the translation to be removed?')}}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </li>

                                        <li class="list-inline-item">
                                            <div class="form-group parent-link-short">
                                                <input type="text" class="form-control "
                                                       value="<?php echo '{{ translate(' . "'$translation->key'" .') }}'; ?>">
                                                <i class="fa fa-copy" aria-hidden="true"
                                                   id="rrrrrr"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{translate('Click to copy the link.')}}"
                                                ></i>
                                            </div>
                                        </li>


                                    </ul>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center ">
                    {!! $translations->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>

        $(".parent-link-short .fa").click(function () {
            var input = $(this).parent().find('input').select();
            console.log(input);

            document.execCommand("Copy");
        });

    </script>
@endsection
