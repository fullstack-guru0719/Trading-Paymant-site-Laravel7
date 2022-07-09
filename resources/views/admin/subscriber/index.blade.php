@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Joined')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subscribers as $subscriber)
                                <tr>
                                    <td data-label="@lang('Email')">{{ $subscriber->email }}</td>
                                    <td data-label="@lang('Joined')">{{ showDateTime($subscriber->created_at) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)"
                                           data-id="{{ $subscriber->id }}"
                                           data-email="{{ $subscriber->email }}"
                                           class="icon-btn ml-1 removeModalBtn" data-toggle="tooltip" title=""
                                           data-original-title="@lang('Remove')">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ trans($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $subscribers->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>





    {{-- Remove Subscriber MODAL --}}
    <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Are you sure want to remove?')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.subscriber.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="subscriber">
                        <p><span class="font-weight-bold subscriber-email"></span> @lang('will be removed.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.subscriber.sendEmail') }}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-fw fa-paper-plane"></i>@lang('Send Email')</a>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            "use strict";
            $('.removeModalBtn').on('click', function () {
                $('#removeModal').find('input[name=subscriber]').val($(this).data('id'));
                $('#removeModal').find('.subscriber-email').text($(this).data('email'));
                $('#removeModal').modal('show');
            });
        });

    </script>
@endpush
