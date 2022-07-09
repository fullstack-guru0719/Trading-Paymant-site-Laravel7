@extends($activeTemplate.'layouts.master')
@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="text-md-right mb-5 text-center">
                        <a href="
                        @if(request()->routeIs('user.referral.commissions.deposit'))
                        javascript:void(0)
                        @else
                        {{ route('user.referral.commissions.deposit') }}
                        @endif" 
                        class="btn btn-primary mr-3 mb-3 w-auto
                        @if(request()->routeIs('user.referral.commissions.deposit'))
                        btn-active
                        @endif
                        ">@lang('Deposit Commission')</a>

                        <a href="
                        @if(request()->routeIs('user.referral.commissions.interest'))
                        javascript:void(0)
                        @else
                        {{ route('user.referral.commissions.interest') }}
                        @endif" 
                        class="btn btn-primary mr-3 mb-3 w-auto
                        @if(request()->routeIs('user.referral.commissions.interest'))
                        btn-active
                        @endif
                        ">@lang('Interest Commission')</a>

                        <a href="
                        @if(request()->routeIs('user.referral.commissions.invest'))
                        javascript:void(0)
                        @else
                        {{ route('user.referral.commissions.invest') }}
                        @endif" 
                        class="btn btn-primary w-auto mb-3
                        @if(request()->routeIs('user.referral.commissions.invest'))
                        btn-active
                        @endif
                        ">@lang('Interest Commission')</a>
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="table-responsive--sm neu--table">

                        <table class="table table-striped text-white">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('From')</th>
                                <th scope="col">@lang('Level')</th>
                                <th scope="col">@lang('Percent')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Type')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $data)
                                <tr @if($data->amount < 0) class="halka-golapi" @endif>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at,'d M, Y')}}</td>
                                    <td data-label="@lang('From')"><strong>{{@$data->bywho->username}}</strong></td>
                                    <td data-label="@lang('Level')">{{__(ordinal($data->level))}} @lang('Level')</td>
                                    <td data-label="@lang('Percent')">{{getAmount($data->percent)}} %</td>
                                    <td data-label="@lang('Amount')">{{__($general->cur_sym)}} {{getAmount($data->commission_amount)}}</td>
                                    <td data-label="@lang('Type')">{{__($data->type)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-right" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{$logs->links()}}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
