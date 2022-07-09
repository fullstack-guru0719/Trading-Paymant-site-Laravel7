@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top w-100" alt="..">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group text-center">
                                    <li class="list-group-item">
                                        @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                    </li>
                                    <li class="list-group-item">
                                        @lang('You will get: '){{getAmount($deposit->amount)}}  {{$deposit->method_currency}}
                                    </li>
                                    <li class="list-group-item">
                                        <button type="button" class="btn cmn-btn w-100" id="btn-confirm">@lang('Pay Now')</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@push('script')

    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        closedFunction = function () {
        }
        successFunction = function (transaction_id) {
            window.location.href = '{{ route('user.deposit') }}';
        }
        failedFunction = function (transaction_id) {
            window.location.href = '{{ route('user.deposit') }}';
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo: "{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id: "{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed: closedFunction,
                success: successFunction,
                failed: failedFunction
            });
        }

        $(document).ready(function () {
            "use strict";
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush
