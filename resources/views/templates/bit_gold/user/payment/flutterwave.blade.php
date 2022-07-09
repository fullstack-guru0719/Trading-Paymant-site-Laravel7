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
                            <div class="col-md-8 text-center">
                                <ul class="list-group text-center">
                                    <li class="list-group-item">
                                        @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                    </li>
                                    <li class="list-group-item">
                                        @lang('You will get: '){{getAmount($deposit->amount)}}  {{$deposit->method_currency}}
                                    </li>
                                    <li class="list-group-item">
                                        <button type="button" class="btn btn-default cmn-btn w-100" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                                        <script
                                            src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                        <script>
                                            "use strict";
                                            var btn = document.querySelector("#btn-confirm");
                                            btn.setAttribute("type", "button");
                                            const API_publicKey = "{{$data->API_publicKey}}";

                                            function payWithRave() {
                                                var x = getpaidSetup({
                                                    PBFPubKey: API_publicKey,
                                                    customer_email: "{{$data->customer_email}}",
                                                    amount: "{{$data->amount }}",
                                                    customer_phone: "{{$data->customer_phone}}",
                                                    currency: "{{$data->currency}}",
                                                    txref: "{{$data->txref}}",
                                                    onclose: function () {
                                                    },
                                                    callback: function (response) {
                                                        var txref = response.tx.txRef;
                                                        var status = response.tx.status;
                                                        var chargeResponse = response.tx.chargeResponseCode;
                                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                        } else {
                                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                        }
                                                        // x.close(); // use this to close the modal immediately after payment.
                                                    }
                                                });
                                            }
                                        </script>
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

