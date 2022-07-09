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
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Supported Currency')</th>
                                <th scope="col">@lang('Enabled Currency')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways as $k=>$gateway)
                                <tr>
                                    <td data-label="Gateway">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ getImage(imagePath()['gateway']['path'].'/'. $gateway->image,'800x800')}}" alt="image"></div>
                                            <span class="name">{{$gateway->name}}</span>
                                        </div>
                                    </td>


                                    <td data-label="Supported Currency">
                                        {{ count(json_decode($gateway->supported_currencies,true)) }}
                                    </td>
                                    <td data-label="Enabled Currency">
                                        {{ $gateway->currencies->count() }}
                                    </td>


                                    <td data-label="Status">
                                        @if($gateway->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Disabled')</span>
                                        @endif

                                    </td>
                                    <td data-label="Action">
                                        <a href="{{ route('admin.deposit.gateway.edit', $gateway->alias) }}"
                                           class="icon-btn editGatewayBtn" data-toggle="tooltip" title="" data-original-title="Edit">
                                            <i class="la la-pencil"></i>
                                        </a>


                                        @if($gateway->status == 0)
                                            <button data-toggle="modal" data-target="#activateModal"
                                                    class="icon-btn bg--success ml-1 activateBtn"
                                                    data-code="{{$gateway->code}}"
                                                    data-name="{{$gateway->name}}" data-original-title="Enable">
                                                <i class="la la-eye"></i>
                                            </button>
                                        @else
                                            <button data-toggle="modal" data-target="#deactivateModal"
                                                    class="icon-btn bg--danger ml-1 deactivateBtn"
                                                    data-code="{{$gateway->code}}"
                                                    data-name="{{$gateway->name}}" data-original-title="Disable">
                                                <i class="la la-eye-slash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>


    </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Activation Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.gateway.activate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="font-weight-bold method-name"></span> @lang('method?')</p>
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
                    <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.deposit.gateway.deactivate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="font-weight-bold method-name"></span> @lang('method?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
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
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });
        });
    </script>
@endpush
