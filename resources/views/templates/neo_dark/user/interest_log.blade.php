@extends($activeTemplate.'layouts.master')

@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <script>
        "use strict"
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function () {
                var distance = tms * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                tms--;
            }, 1000);
        }
    </script>



    <section class="feature-section pt-150 pb-150">

        <div class="container">

            <div class="row justify-content-center mt-2">
                <div class="col-md-12">
                    <div class="text-right mb-5">
                        <a href="{{ route('user.plan') }}" class="btn btn-primary">@lang('Investment Plan')</a>
                    </div>
                </div>
                <div class="col-md-12">


                    <div class="table-responsive--sm neu--table">

                        <table class="table text-white">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Plan')</th>
                                <th scope="col">@lang('Return')</th>
                                <th scope="col">@lang('Received')</th>
                                <th scope="col">@lang('Next payment')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $k=>$data)
                                <tr>
                                    <td data-label="@lang('Plan')">{{trans(optional($data->plan)->name)}} <br> {{getAmount($data->amount)}}  {{__($general->cur_text)}} </td>
                                    <td data-label="@lang('Return')">
                                        {{getAmount($data->interest)}} {{__($general->cur_text)}} every {{$data->time_name}}
                                       <br> 
                                       for
                                            @if($data->period == '-1')
                                                @lang('Lifetime')
                                            @else {{$data->period}} 
                                                {{$data->time_name}}
                                            @endif

                                        @if($data->capital_status == '1') + @lang('Capital')
                                            @endif

                                    </td>
                                    <td data-label="@lang('Received')">  {{$data->return_rec_time}}x{{ $data->interest }} =  {{$data->return_rec_time*$data->interest }} {{__($general->cur_text)}} </td>
                             


                                    <td data-label="@lang('Next payment')" scope="row" class="font-weight-bold">
                                        @if($data->status == '1')
                                            <p id="counter{{$data->id}}" class="demo countdown timess2 "></p>

                                              @php
                                            if($data->last_time){
                                               $start = $data->last_time;
                                            }else{
                                               $start = $data->created_at;
                                            }
                                        @endphp
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                 style="width: {{diffDatePercent($start, $data->next_time)}}"
                                                 aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>

                                        @else 
                                            <span class="badge badge-success">@lang('Completed')</span>
                                         @endif
                                    </td>

                                    <script>createCountDown('counter<?php echo $data->id ?>', {{\Carbon\Carbon::parse($data->next_time)->diffInSeconds()}});</script>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8">{{trans($empty_message)}}</td>
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


@push('script')

@endpush

