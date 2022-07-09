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
                                    <img src="{{$deposit->gateway_currency()->methodImage()}}"
                                         class="card-img-top w-100" alt="..">
                                </div>
                                <div class="col-md-8 text-center">
                                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST"
                                          class="text-center">
                                        @csrf
                                        <h3 class="mt-4">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                        <h3 class="my-3">@lang('To Get') {{getAmount($deposit->amount)}}  {{trans($general->cur_text)}}</h3>

                                        <button type="button" class=" mt-4 btn btn-success  btn-lg"
                                                id="btn-confirm">@lang('Pay Now')</button>

                                        <script
                                                src="//js.paystack.co/v1/inline.js"
                                                data-key="{{ $data->key }}"
                                                data-email="{{ $data->email }}"
                                                data-amount="{{$data->amount}}"
                                                data-currency="{{$data->currency}}"
                                                data-ref="{{ $data->ref }}"
                                                data-custom-button="btn-confirm"
                                        >
                                        </script>
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
