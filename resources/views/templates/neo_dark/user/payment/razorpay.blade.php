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

                                    <form action="{{$data->url}}" method="{{$data->method}}">

                                        <h3 class="mt-4 text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                        <h3 class="my-3 text-center">@lang('To Get') {{getAmount($deposit->amount)}}  {{trans($general->cur_text)}}</h3>


                                        <script src="{{$data->checkout_js}}"
                                                @foreach($data->val as $key=>$value)
                                                data-{{$key}}="{{$value}}"
                                                @endforeach >

                                        </script>

                                        <input type="hidden" custom="{{$data->custom}}" name="hidden">

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
            $('input[type="submit"]').addClass("ml-4 mt-4 btn btn-primary btn-custom2 text-center btn-lg");
        })
    </script>
@endpush
