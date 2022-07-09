@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-bg">
                        <div class="dashboard__header mb-4">
                            <div class="left">
                                <h3>{{trans($page_title)}}</h3>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top w-100"
                                         alt="..">
                                </div>
                                <div class="col-md-8 text-center">
                                    <h3 class="mt-4">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                    <h3 class="my-3">@lang('To Get') {{getAmount($deposit->amount)}}  {{trans($general->cur_text)}}</h3>

                                    <button type="button" class="btn btn-primary  btn-custom2 " id="btn-confirm"
                                            onClick="payWithRave()">@lang('Pay Now')</button>

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


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

