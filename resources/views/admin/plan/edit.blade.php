@extends('admin.layouts.app')
@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="form-horizontal" action="{{route('admin.plan-update', $plan->id)}}">
                        @csrf
                        @method('put')

                        <div class="form-body">

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Plan Name')</label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="{{$plan->name}}" required>
                                </div>


                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Amount Type')</label>
                                    <input data-toggle="toggle" id="amount" class="amount" data-onstyle="-success"
                                           data-size="large"
                                           data-offstyle="-info" data-on="Fixed" data-off="Range" data-width="100%"
                                           type="checkbox" {{$plan->fixed_amount != 0 ? 'checked': ''}} name="amount_type">
                                </div>

                                <div class="form-group offman col-md-3">
                                    <label class="font-weight-bold">@lang('Minimum Amount')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg"
                                               value="{{$plan->minimum}}"
                                               name="minimum">
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{trans($general->cur_sym)}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group offman col-md-3">
                                    <label class="font-weight-bold">@lang('Maximum Amount')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg" value="{{$plan->maximum}}"
                                               name="maximum">
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{trans($general->cur_sym)}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group onman col-md-3 d-none">
                                    <label class="font-weight-bold"> @lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$plan->fixed_amount}}" name="amount">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{trans($general->cur_sym)}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Return /Interest')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg" name="interest"
                                               value="{{$plan->interest}}" required>
                                        <div class="input-group-append" style="height: 47px">
                                            <div class="input-group-text">
                                                <select name="interest_status" class="form-control"
                                                        style="height: 35px !important;">
                                                    <option {{$plan->interest_status == '1'? 'selected': ''}} value="%">
                                                        %
                                                    </option>
                                                    <option
                                                        {{$plan->interest_status == '0'? 'selected': ''}} value="{{$general->cur_sym}}">{{trans($general->cur_sym)}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Every')</label>
                                    <select class="form-control form-control-lg" name="times">
                                        @foreach($time as $data)
                                            <option
                                                {{$plan->times == $data->time? 'selected': ''}} value="{{$data->time}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Return For')</label>
                                    <input data-toggle="toggle" id="lifetime" class="lifetime" data-onstyle="-success"
                                           data-offstyle="-danger"
                                           data-size="large"
                                           data-on="Period" data-off="Lifetime" data-width="100%" type="checkbox"
                                           {{$plan->lifetime_status == 0? 'checked':''}} name="lifetime_status">
                                </div>


                                <div class="form-group return col-md-3 d-none">
                                    <label class="font-weight-bold">@lang('How Many Times')</label>
                                    <input type="text" class="form-control form-control-lg"
                                           value="{{$plan->repeat_time}}"
                                           name="repeat_time">

                                </div>

                                <div class="form-group col-md-3" id="capitalBack">
                                    <label class="font-weight-bold">@lang('Capital Back')</label>
                                    <input data-toggle="toggle" data-onstyle="-success" data-offstyle="-danger"
                                           {{$plan->capital_back_status == 1? 'checked':''}} data-size="large"
                                           data-on="Yes" data-off="No" data-width="100%" type="checkbox"
                                           name="capital_back_status">
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Status')</label>
                                    <input data-toggle="toggle" data-onstyle="-success" data-offstyle="-danger"
                                           data-size="large"
                                           {{$plan->status == 1? 'checked':''}}
                                           data-on="Active" data-off="Disable" data-width="100%" type="checkbox"
                                           name="status">
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="font-weight-bold">@lang('Featured')</label>
                                    <input data-toggle="toggle" data-onstyle="-success" data-offstyle="-danger"
                                           {{$plan->featured == 1? 'checked':''}} data-size="large"
                                           data-on="Yes" data-off="No" data-width="100%" type="checkbox"
                                           name="featured">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--primary btn-block">@lang('Update')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{route('admin.plan-setting')}}" class="btn  btn--primary box--shadow1 text--small"><i class="la la-eye"></i>@lang('Plan List')</a>
@endpush

@push('script')
    <script>
        $(function ($) {
            "use strict";

            $(document).ready(function () {

                if ($('#amount').prop('checked') == false) {
                    $('.offman').addClass('d-block');
                    $('.offman').removeClass('d-none');

                    $('.onman').addClass('d-none');
                    $('.onman').removeClass('d-block');
                } else {
                    $('.offman').addClass('d-none');
                    $('.offman').removeClass('d-block');

                    $('.onman').addClass('d-block');
                    $('.onman').removeClass('d-none');
                }

                if ($('#lifetime').prop('checked') == true) {
                    $('.return').addClass('d-block');
                    $('.return').removeClass('d-none');
                } else {
                    $('.return').addClass('d-none');
                    $('.return').removeClass('d-block');
                }


                $('#amount').on('change', function () {
                    var isCheck = $(this).prop('checked');
                    if (isCheck == false) {
                        $('.offman').addClass('d-block');
                        $('.offman').removeClass('d-none');

                        $('.onman').addClass('d-none');
                        $('.onman').removeClass('d-block');
                    } else {
                        $('.offman').addClass('d-none');
                        $('.offman').removeClass('d-block');

                        $('.onman').addClass('d-block');
                        $('.onman').removeClass('d-none');
                    }
                });

                $('#lifetime').on('change', function () {
                    var isCheck = $(this).prop('checked');
                    if (isCheck == true) {
                        $('.return').addClass('d-block');
                        $('.return').removeClass('d-none');
                    } else {
                        $('.return').addClass('d-none');

                        $('.return').removeClass('d-block');
                    }
                });
            })

        });
    </script>
@endpush
