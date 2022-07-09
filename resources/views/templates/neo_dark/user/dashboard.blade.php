@extends($activeTemplate.'layouts.master')

@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')



    <!-- dashboard-section start -->
    <section class="dashboard-section pt-150 pb-150">
        <div class="container">
            <div class="row">

                <div class="col-md-12 mb-4">
                    <label>@lang('Referral Link')</label>
                    <div class="input-group">
                        <input type="text" name="text" class="form-control" id="referralURL"
                        value="{{route('user.refer.register',[Auth::user()->username])}}" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text copytext copyBoard" id="copyBoard"
                            onclick="myFunction()"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                </div>

                            
                <div class="col-lg-12">
                    <div class="dashboard-main">



                        <div class="dashboard__user">
                            <div class="single">
                                <div class="thumb"><img src="{{ getImage(imagePath()['profile']['path'].'/'. auth()->user()->image,'800x800')}}" alt="image">
                                </div>
                                <div class="content">
                                    <h5 class="caption">{{Auth::user()->username}}</h5>
                                    <span>{{Auth::user()->fullname}}</span>
                                </div>
                            </div><!-- single end -->
                            <div class="single">
                                <div class="content">
                                    <h5 class="caption">@lang('Registration Date')</h5>
                                    <span>{{showDateTime(Auth::user()->created_at, 'M d, Y')}}</span>
                                </div>
                            </div><!-- single end -->
                            <div class="single">
                                <div class="content">
                                    <h5 class="caption">@lang('Last Access')</h5>
                                    <span> {{showDateTime(Auth::user()->lastLogin->created_at, 'M - d - Y / h:i:s A')}}</span>
                                </div>
                            </div><!-- single end -->
                        </div>


                        <div class="row mt-30 mb-none-30">

                                <div class="col-lg-3 mb-30">
                                        <div class="stat-item">
                                            <i class="las la-piggy-bank base--color"></i>
                                            <h6 class="caption text-shadow">@lang('Deposit Wallet')</h6>
                                            <span
                                                    class="total__amount">{{trans($general->cur_sym)}}{{getAmount($user->deposit_wallet)}}</span>

                                            <div class="d-flex justify-content-center mt-3">
                                                <a href="{{route('user.deposit.history')}}"
                                                   class="btn btn-primary btn-small d-block text-center style--two">@lang('View report')</a>
                                            </div>

                                        </div>
                                </div>
                                <div class="col-lg-3 mb-30">
                                        <div class="stat-item">
                                            <i class="las la-piggy-bank base--color"></i>
                                            <h6 class="caption text-shadow">@lang('Interest Wallet')</h6>
                                            <span class="total__amount">{{trans($general->cur_sym)}}{{getAmount($user->interest_wallet)}}</span>

                                            <div class="d-flex justify-content-center mt-3">
                                                <a href="{{route('user.interest.log')}}"
                                                   class="btn btn-primary btn-small d-block text-center style--two">@lang('View report')</a>
                                            </div>

                                        </div>
                                </div>


                            <div class="col-lg-3 mb-30">
                                <div class="stat-item">

                                    <i class="las la-credit-card base--color"></i>
                                    <h6 class="caption text-shadow">@lang('Total Invest')</h6>
                                    <span class="total__amount">{{trans($general->cur_sym)}}{{getAmount($totalInvest)}}</span>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{route('user.interest.log')}}"
                                           class="btn btn-primary btn-small d-block text-center style--two">@lang('View report')</a>
                                    </div>
                                </div><!-- stat-item end -->
                            </div>
                            <div class="col-lg-3 mb-30">
                                <div class="stat-item">
                                    <i class="las la-ticket-alt base--color"></i>
                                    <h6 class="caption text-shadow">@lang('Total Ticket')</h6>
                                    <span
                                            class="total__amount">{{$totalTicket}} </span>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{route('ticket')}}"
                                           class="btn btn-primary btn-small d-block text-center style--two">@lang('View report')</a>
                                    </div>
                                </div><!-- stat-item end -->
                            </div>

                        </div>


                        <div class="row mt-100">
                            <div class="col-lg-6">
                                <div class="stat-wrapper deposit">
                                    <div class="stat__header">
                                        <div class="left">
                                            <div class="icon"><i class="las la-chart-area"></i></div>
                                            <h3 class="caption">@lang('Deposit')</h3>
                                        </div>
                                        <div class="right"><i class="flaticon-next"></i></div>
                                    </div>
                                    <div class="item-wrapper">
                                        <div class="stat-item-two box-shadow-two">
                                            <h5 class="caption text-shadow">@lang('Total Deposit')</h5>
                                            <span class="total__amount base--color">{{trans($general->cur_sym)}}{{getAmount($totalDeposit, currency()['fiat'])}}</span>
                                        </div><!-- stat-item-two end -->
                                        <div class="stat-item-two box-shadow-two">
                                            <h5 class="caption text-shadow">@lang('Last Deposit')</h5>
                                            <span class="total__amount base--color">{{trans($general->cur_sym)}}
                                                @if($lastDeposit)
                                                    {{getAmount($lastDeposit->amount, currency()['fiat'])}}
                                                @else
                                                    {{getAmount(0, currency()['fiat'])}}
                                                @endif </span>
                                        </div><!-- stat-item-two end -->

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mt-lg-0 mt-5">
                                <div class="stat-wrapper withdraw">
                                    <div class="stat__header">
                                        <div class="left">
                                            <div class="icon"><i class="las la-credit-card"></i></div>
                                            <h3 class="caption">@lang('Withdraw')</h3>
                                        </div>
                                        <div class="right"><i class="flaticon-next"></i></div>
                                    </div>
                                    <div class="item-wrapper">
                                        <div class="stat-item-two box-shadow-two">
                                            <h5 class="caption text-shadow">@lang('Total Withdraw')</h5>
                                            <span class="total__amount base--color">{{trans($general->cur_sym)}}{{getAmount($totalWithdraw, currency()['fiat'])}}</span>
                                        </div><!-- stat-item-two end -->
                                        <div class="stat-item-two box-shadow-two">
                                            <h5 class="caption text-shadow">@lang('Last Withdraw')</h5>
                                            <span class="total__amount base--color">{{trans($general->cur_sym)}}
                                                @if($lastWithdraw)
                                                    {{getAmount($lastWithdraw->amount, currency()['fiat'])}}
                                                @else
                                                    {{getAmount(0, currency()['fiat'])}}
                                                @endif
                                            </span>
                                        </div><!-- stat-item-two end -->

                                    </div><!-- item-wrapper end -->
                                </div>
                            </div>

                        </div>


                    </div><!-- dashboard-main end -->
                </div>


            </div>
        </div>
    </section>
    <!-- dashboard-section end -->
@endsection


@push('script')
    <script>
        $('.copyBoard').click(function(){
        "use strict";
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
      });
    </script>
@endpush
