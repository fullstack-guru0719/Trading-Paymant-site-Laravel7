@extends('admin.layouts.app')

@section('panel')
<script>
    "use strict";
    function createCountDown(elementId, sec) {
        var tms = sec;
        var x = setInterval(function() {
            var distance = tms*1000;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
            }
            tms--;
        }, 1000);
    }
</script>


    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Plan - Interest')</th>
                                <th scope="col">@lang('Period - Received')</th>
                                <th scope="col">@lang('Invest')</th>
                                <th scope="col">@lang('Status - Capital Back')</th>
                                <th scope="col" class="width-20">@lang('Next payment')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $data)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $data->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->user_id) }}"><span>@</span>{{ $data->user->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Plan - Interest')">
                                        {{__($data->plan->name)}}
                                        <br>
                                        {{__($general->currency_sym)}} {{__($data->interest)}} / {{__($data->time_name)}}
                                    </td>
                                    <td data-label="@lang('Period - Received')">
                                        @if($data->period == '-1') <span class="badge badge--success">@lang('Life time')</span>
                                        @else <span class="font-weight-bold">{{__($data->period)}} @lang('times')</span>
                                        @endif
                                        <br>
                                        {{__($data->return_rec_time)}} @lang('times')
                                    </td>
                                    <td data-label="@lang('Trx - Invest')">  
                                        <span class="font-weight-bold">{{__($general->cur_sym)}}{{getAmount($data->amount)}}</span>
                                    </td>
                                    <td data-label="@lang('Status - Capital Back')">
                                        @if($data->capital_status == '1')
                                            <span class="badge badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('No')</span>
                                        @endif
                                        <br>
                                        @if($data->status == '1')
                                            <span class="badge badge--warning mt-2"><i class="fas fa-spinner fa-spin"></i> @lang('running')</span>
                                        @else
                                            <span class="badge badge--primary mt-2">@lang('complete')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Next payment')" scope="row" class="font-weight-bold">  @if($data->status == '1') <p id="counter{{$data->id}}" class="demo countdown timess2"></p> @else - @endif </td>
                                </tr>

                                <script>createCountDown('counter<?php echo $data->id ?>', {{\Carbon\Carbon::parse($data->next_time)->diffInSeconds()}});</script>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $logs->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>



@endsection


@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.plan'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else
        <form action="{{ route('admin.report.plan.search') }}" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush


