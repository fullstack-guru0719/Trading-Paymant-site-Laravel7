@extends($activeTemplate.'layouts.master')

@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

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
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <ul class="list-group text-center">
                                        <li class="list-group-item">
                                            @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                        </li>
                                        <li class="list-group-item">
                                            @lang('You will get: '){{getAmount($deposit->amount)}}  {{$deposit->method_currency}}
                                        </li>
                                        <li class="list-group-item">
                                            <script
                                                src="{{$data->src}}"
                                                class="stripe-button"
                                                @foreach($data->val as $key=> $value)
                                                data-{{$key}}="{{$value}}"
                                                @endforeach
                                            >
                                            </script>
                                        </li>
                                    </ul>
                                </form>
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
    <script>


        $(document).ready(function () {
            "use strict";
            $('button[type="submit"]').addClass(" btn-primary btn-round cmn-btn text-center btn-lg");
        })
    </script>
@endpush
