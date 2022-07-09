@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Banner')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($tools as $tool)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ ($tool->currentPage-1) * $tool->perPage + $loop->iteration }}</td>

                                    <td data-label="@lang('Banner')">
                                        <div class="user d-flex justify-content-center">
                                            <div class="thumb">
                                                <img src="{{ getImage(imagePath()['promotions']['path'].  '/'. @$tool->banner) }}" alt="@lang('image')">
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Name')"> {{ $tool->name }} </td>

                                    <td data-label="@lang('Action')">
                                        <button type="button" data-id="{{ $tool->id }}" data-name="{{ $tool->name }}" data-image="{{ getImage(imagePath()['promotions']['path'].  '/'. @$tool->banner) }}" class="icon-btn edit-btn">
                                            @lang('Edit')
                                        </button>

                                        <button type="button" data-id="{{ $tool->id }}" class="icon-btn btn--danger delete-btn">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $tools->links() }}
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Banner Set')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.promotional.tool.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['image']['default']) }})">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" id="profilePicUpload2" accept="jpeg, jpg, png, gif" name="image_input" >
                                <label for="profilePicUpload2" class="bg--primary">@lang('Select Banner Image')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="name">@lang('Name')</label>
                      <input type="text" class="form-control" name="name" id="name">
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Add')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Banner Set')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['image']['default']) }})">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" id="profilePicUpload-1" accept="jpeg, jpg, png, gif" name="image_input" >
                                <label for="profilePicUpload-1" class="bg-primary">@lang('Select Banner Image')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name1">@lang('Name')</label>
                        <input type="text" class="form-control" name="name" id="name1">
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- REMOVE METHOD MODAL --}}

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" id="deletePostForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">@lang('Removal Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('Are you sure to delete this banner?')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--dark" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-sm btn--danger">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
    <button data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--success box--shadow1 text--small">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('#addModal, #editModal').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.edit-btn').on('click', function () {
                var modal       = $('#editModal');
                var form = document.getElementById('editForm');

                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('select[name=banner_set_id]').val($(this).data('banner_set_id'));
                modal.find('.profilePicPreview').css('background-image', `url(${$(this).data('image')})`);
                form.action = '{{ route('admin.promotional.tool.update', '') }}' + '/' + $(this).data('id');
                modal.modal('show');
            });

            $('.delete-btn').on('click', function ()
            {
                var modal   = $('#deleteModal');
                var id      = $(this).data('id');
                var form    = document.getElementById('deletePostForm');

                form.action = '{{ route('admin.promotional.tool.remove', '') }}' + '/' + id;
                modal.modal('show');
            });

        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .image-upload .thumb .profilePicUpload {
            display: none
        }
        .avatar-edit {
            padding: 15px 2px 0 ;
        }

        .image-upload .thumb .profilePicPreview {
            background-size: contain !important;
            background-position: center !important;
        }
    </style>
@endpush
