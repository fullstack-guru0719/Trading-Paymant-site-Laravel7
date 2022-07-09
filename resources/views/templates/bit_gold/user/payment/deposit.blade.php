@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="pt-60 pb-150">

        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="right float-right mb-5">
                        <a href="{{ route('user.deposit.history') }}" class="btn cmn-btn">
                            @lang('Deposit History')                            
                        </a>
                    </div>
                </div>

                @foreach($gatewayCurrency as $data)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body b-primary">
                            <div class="row justify-content-center">
                                <div class="col-md-5 col-sm-12">
                                    <img src="{{$data->methodImage()}}" class="card-img-top w-100" alt="{{$data->name}}">
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <ul class="list-group text-center">


                                        <li class="list-group-item">
                                            {{__($data->name)}}</li>

                                        <li class="list-group-item">@lang('Limit')
                                            : {{getAmount($data->min_amount)}}
                                            - {{getAmount($data->max_amount)}} {{$general->cur_text}}</li>

                                        <li class="list-group-item"> @lang('Charge')
                                            - {{getAmount($data->fixed_charge)}} {{$general->cur_text}}
                                            + {{getAmount($data->percent_charge)}}%
                                        </li>

                                        <li class="list-group-item">
                                            <button type="button"  data-id="{{$data->id}}" data-resource="{{$data}}"
                                            data-base_symbol="{{$data->baseSymbol()}}"
                                            class=" btn deposit cmn-btn w-100" data-toggle="modal" data-target="#exampleModal">
                                        @lang('Deposit')</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                        </div>
                            @if(session()->get('amount') != null)
                                <input id="amount" type="hidden" class="form-control form-control-lg" name="amount" placeholder="0.00" required autocomplete="off" value="{{decrypt(session()->get('amount'))}}">
                                <h4 class="text-center">@lang('Please Confirm To Pay')</h4>
                             @else
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
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn-md cmn-btn">@lang('Next')</button>
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
