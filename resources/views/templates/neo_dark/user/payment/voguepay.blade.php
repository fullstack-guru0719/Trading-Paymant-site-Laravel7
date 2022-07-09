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
                                    <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top w-100" alt="..">
                                </div>
                                <div class="col-md-8 text-center">
                                    <h3 class="mt-4">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                    <h3 class="my-3">@lang('To Get') {{getAmount($deposit->amount)}}  {{trans($general->cur_text)}}</h3>

                                    <button type="button" class="mt-4 btn btn-primary custom-success text-center btn-lg" id="btn-confirm">@lang('Pay Now')</button>
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
