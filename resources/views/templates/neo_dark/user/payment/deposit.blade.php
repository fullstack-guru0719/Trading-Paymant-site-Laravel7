@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">

        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="text-right mb-5">
                        <a href="{{ route('user.deposit.history') }}" class="btn btn-primary">@lang('Deposit History')</a>
                    </div>
                </div>

                @foreach($gatewayCurrency as $data)
                    <div class="col-lg-3 col-md-3 mb-4">
                        <div class="card card-bg">
                            <h5 class="card-header text-center">{{trans($data->name)}}
                            </h5>
                            <div class="card-body card-body-deposit">
                                <img src="{{$data->methodImage()}}" class="card-img-top deposit-logo" alt="{{$data->name}}">
                            </div>
                            <div class="card-footer">
                                <a href="javascript:void(0)" data-id="{{$data->id}}" data-resource="{{$data}}"
                                   data-min_amount="{{getAmount($data->min_amount)}}"
                                   data-max_amount="{{getAmount($data->max_amount)}}"
                                   data-base_symbol="{{$data->baseSymbol()}}"
                                   data-fix_charge="{{getAmount($data->fixed_charge)}}"
                                   data-percent_charge="{{getAmount($data->percent_charge)}}"
                                   class=" btn  btn-primary w-100  deposit" data-toggle="modal"
                                   data-target="#exampleModal">
                                    @lang($buttonText)</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-bg">
                <div class="modal-header">
                    <strong class="modal-title method-name text-white" id="exampleModalLabel"></strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post" class="register">
                    @csrf
                    <div class="modal-body">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                            @if(session()->get('amount') != null)
                                <input id="amount" type="hidden" class="form-control form-control-lg" name="amount" placeholder="0.00" required autocomplete="off" value="{{decrypt(session()->get('amount'))}}">
                                <h4 class="text-center">@lang('Please Confirm To Pay')</h4>
                             @else
                            <p class="text-danger depositLimit"></p>
                            <p class="text-danger depositCharge"></p>
                            <div class="form-group">
                                <label>@lang('Enter Amount'):</label>
                                <div class="input-group">
                                    <input id="amount" type="text" class="form-control form-control-lg" name="amount" placeholder="0.00" required autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text currency-addon addon-bg">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger action-btn" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary action-btn">@lang('Next')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop



@push('script')
    <script>
        $(document).ready(function(){
            "use strict";
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                $('.currency-addon').text(baseSymbol);

                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });
        });
    </script>
@endpush
