@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive table-responsive--sm">
                        <table class="default-data-table table ">

                            <thead>
                            <tr>
                                <th scope="col">@lang('Plugin')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($plugins as $plugin)
                                <tr>
                                    <td data-label="@lang('Plugin')">
                                        <div class="user">
                                            <div class="thumb"><img
                                                        src="{{ getImage(imagePath()['plugin']['path'] .'/'. $plugin->image) }}"
                                                        alt="{{ $plugin->name }}" class="plugin_bg"></div>
                                            <span class="name">{{ trans($plugin->name) }}</span>
                                        </div>
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @if($plugin->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Disabled')</span>
                                        @endif

                                    </td>

                                    <td data-label="@lang('Action')">

                                        <button type="button"
                                                class="icon-btn ml-1 editBtn"
                                                data-name="{{ trans($plugin->name) }}"
                                                data-shortcode="{{ json_encode($plugin->shortcode) }}"
                                                data-action="{{ route('admin.plugin.update', $plugin->id) }}"
                                                data-original-title="@lang('Configure')">
                                            <i class="la la-cogs"></i>
                                        </button>

                                        <button type="button"
                                                class="icon-btn btn--dark ml-1 helpBtn"
                                                data-description="{{ $plugin->description }}"
                                                data-support="{{ $plugin->support }}"
                                                data-original-title="@lang('Help')">
                                            <i class="la la-question"></i>
                                        </button>


                                        @if($plugin->status == 0)
                                            <button type="button"
                                                    class="icon-btn btn--success ml-1 activateBtn"
                                                    data-toggle="modal" data-target="#activateModal"
                                                    data-id="{{ $plugin->id }}" data-name="{{trans($plugin->name )}}"
                                                    data-original-title="@lang('Enable')">
                                                <i class="la la-eye"></i>
                                            </button>

                                        @else
                                            <button type="button"
                                                    class="icon-btn btn--danger ml-1 deactivateBtn"
                                                    data-toggle="modal" data-target="#deactivateModal"
                                                    data-id="{{ $plugin->id }}" data-name="{{trans($plugin->name)}}"
                                                    data-original-title="@lang('Disable')">
                                                <i class="la la-eye-slash"></i>
                                            </button>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>



    {{-- EDIT METHOD MODAL --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Plugin:') <span class="plugin-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12 control-label font-weight-bold">@lang('Script') <span
                                        class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <textarea name="script" class="form-control" rows="8"
                                          placeholder="Paste your script with proper key"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary" id="editBtn">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Plugin Activation Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.plugin.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span
                                    class="font-weight-bold plugin-name"></span> @lang('plugin')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Plugin Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.plugin.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span
                                    class="font-weight-bold plugin-name"></span> @lang('plugin?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- HELP METHOD MODAL --}}
    <div id="helpModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Need Help?')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function () {
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.plugin-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.plugin-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var shortcode = $(this).data('shortcode');

                modal.find('.plugin-name').text($(this).data('name'));
                modal.find('form').attr('action', $(this).data('action'));
                var html = '';
                $.each(shortcode, function (key, item) {
                    html += `<div class="form-group">
                        <label class="col-md-12 control-label font-weight-bold">${item.title}<span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input name="${key}" class="form-control" placeholder="--" value="${item.value}" required>
                        </div>
                    </div>`;
                })
                modal.find('.modal-body').html(html);
                modal.modal('show');
            });

            $('.helpBtn').on('click', function () {
                var modal = $('#helpModal');
                var path = "{{ asset(imagePath()['plugin']['path']) }}";
                modal.find('.modal-body').html(`<div class="mb-2">${$(this).data('description')}</div>`);
                if ($(this).data('support') != 'na') {
                    modal.find('.modal-body').append(`<img src="${path}/${$(this).data('support')}"></img>`);
                }
                modal.modal('show');
            });


        });
    </script>
@endpush
