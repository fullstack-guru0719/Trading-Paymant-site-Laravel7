@extends('admin.layouts.app')

@section('panel')


    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($team as $data)
                            <tr>
                                <td data-label="@lang('Name')">{{ $data->name }}</td>
                                <td data-label="@lang('Time')">{{ $data->time }} @lang('Hours')</td>
                                <td data-label="@lang('Action')">
                                     <a href="javascript:void(0)"
                                   data-id="{{$data->id}}"
                                   data-name="{{$data->name}}"
                                   data-time="{{$data->time}}"
                                   data-route="{{route('admin.time-update', $data->id)}}"
                                   data-toggle="modal" data-target="#editModal"
                                   class="icon-btn "><i class="las la-pen"></i></a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Data Not Found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>


    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> @lang('Add New Time')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form id="frmProducts" method="post" action="{{route('admin.time-store')}}" class="form-horizontal"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('Time Name:') </label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Time in Hours')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="time" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@lang('Hours')</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"> @lang('Close')</button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-send"></i> @lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> @lang('Edit Time')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form id="frmProducts" class="edit-route form-horizontal" method="post" action=""
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('Time Name:') </label>
                            <input type="text" class="form-control" value="" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Time in Hours')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="time" value="" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@lang('Hours')</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-send"></i> @lang('Update')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <button type="button" data-target="#myModal" data-toggle="modal"
            class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i>@lang('Add New')
    </button>
@endpush


@push('script')
    <script>
        $(function ($) {
            "use strict";

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                modal.find('.edit-route').attr('action', $(this).data('route'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=time]').val($(this).data('time'));
            });
        });
    </script>
@endpush
