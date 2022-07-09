@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-bg text-center">

                        <div class="dashboard__header mb-4">
                            <div class="left">
                                <h3>{{trans('Payment Preview')}}</h3>
                            </div>
                        </div>

                        <div class="card-body text-center">
                            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span
                                    class="text-success"> {{ $data->amount }}</span> {{$data->currency}}</h4>
                            <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                            <img src="{{$data->img}}" alt="..">
                            <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
