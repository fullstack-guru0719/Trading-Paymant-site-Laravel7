@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
<section class="cmn-section">

    <div class="container">

        <div class="row mb-60-80 justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top w-100" alt="..">
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                            @csrf
                            <ul class="list-group text-center">
                                <li class="list-group-item">
                                    @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                </li>
                                <li class="list-group-item">
                                    @lang('You will get: '){{getAmount($deposit->amount)}}  {{$deposit->method_currency}}
                                </li>
                                <li class="list-group-item">
                                    <button type="button" class="cmn-btn btn-round w-100 custom-success text-center" id="btn-confirm">@lang('Pay Now')</button>
                                </li>
                            </ul>
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
