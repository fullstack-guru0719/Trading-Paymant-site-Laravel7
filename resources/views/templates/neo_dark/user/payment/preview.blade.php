@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">
        <div class="container">
            <div class="row  justify-content-center">
                <div class="col-md-8">

                    <div class="card card-bg text-center">

                        <div class="dashboard__header mb-4">
                            <div class="left">
                                <h3>{{trans($page_title)}}</h3>
                            </div>
                        </div>

                        <div class="card-body">

                            <ul class="list-group withdraw-list text-center mb-4">

                                <li class="list-group-item">
                                    <img src="{{ $data->gateway_currency()->methodImage() }}" class="gateway-preview"/>
                                </li>

                                <li class="list-group-item">
                                    @lang('Amount'):
                                    <strong>{{getAmount($data->amount)}} </strong> {{trans($general->cur_text)}}
                                </li>
                                <li class="list-group-item">
                                    @lang('Charge'):
                                    <strong>{{getAmount($data->charge)}}</strong> {{trans($general->cur_text)}}
                                </li>

                                <li class="list-group-item">
                                    @lang('Payable'):
                                    <strong> {{getAmount($data->amount + $data->charge)}}</strong> {{trans($general->cur_text)}}
                                </li>

                                <li class="list-group-item">
                                    @lang('Conversion Rate'): <strong>1 {{$general->cur_text}}
                                        = {{getAmount($data->rate)}}  {{$data->baseCurrency()}}</strong>
                                </li>

                                <li class="list-group-item">
                                    @lang('In') {{$data->baseCurrency()}}:
                                    <strong>{{getAmount($data->final_amo)}}</strong>
                                </li>

                                @if($data->gateway->crypto==1)
                                    <li class="list-group-item">
                                        @lang('Conversion with')
                                        <b> {{ $data->method_currency }}</b> @lang('and final value will Show on next step')
                                    </li>
                                @endif
                            </ul>

                            @if(1000 >$data->method_code)
                                <a href="{{route('user.deposit.confirm')}}" class="btn btn-primary btn-block w-100 font-weight-bold">@lang('Confirm')</a>
                            @else
                                <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn-primary btn-block w-100 font-weight-bold">@lang('Confirm')</a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop


