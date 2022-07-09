@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.user-breadcrumb')
<div class="pt-120 pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 pl-lg-5 mt-lg-0 mt-5">
            <div class="row mb-none-30">
              <div class="col-md-12 mb-4">
                <label>@lang('Referral Link')</label>
                <div class="input-group">
                  <input type="text" name="text" class="form-control" id="referralURL"
                  value="{{route('user.refer.register',[Auth::user()->username])}}" disabled>
                  <div class="input-group-append">
                    <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Deposit Wallet Balance')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->deposit_wallet) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-dollar-sign"></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Interest Wallet Balance')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->interest_wallet) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-wallet"></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Total Invest')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->invests->sum('amount')) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-cubes "></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Total Deposit')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->deposits->sum('amount')) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-credit-card"></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget  d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Total Withdraw')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->withdrawals->sum('amount')) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-cloud-download-alt"></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
              <div class="col-xl-4 col-sm-6 mb-30">
                <div class="d-widget  d-flex flex-wrap">
                  <div class="col-8">
                    <span class="caption">@lang('Referral Earnings')</span>
                    <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->commissions->sum('commission_amount')) }}</h4>
                  </div>
                  <div class="col-4">
                    <div class="icon ml-auto">
                      <i class="las la-user-friends"></i>
                    </div>
                  </div>
                </div><!-- d-widget-two end -->
              </div>
            </div><!-- row end -->
            <div class="row mt-50">
              <div class="col-lg-12">
                <div class="table-responsive--md">
                  <table class="table style--two">
                    <thead>
                      <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Transaction ID')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Wallet')</th>
                        <th>@lang('Details')</th>
                        <th>@lang('Post Balance')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($transactions as $trx)
                      <tr>
                        <td data-label="@lang('Date')">{{ showDatetime($trx->created_at,'d/m/Y') }}</td>
                        <td data-label="@lang('Transaction ID')"><span class="text-primary">{{ $trx->trx }}</span></td>

                        <td data-label="@lang('Amount')">
                          @if($trx->trx_type == '+')
                          <span class="text-success">+ {{ __($general->cur_sym) }}{{ getAmount($trx->amount) }}</span>
                          @else
                          <span class="text-danger">- {{ __($general->cur_sym) }}{{ getAmount($trx->amount) }}</span>
                          @endif
                        </td>
                        <td data-label="@lang('Wallet')">
                          @if($trx->wallet_type == 'deposit_wallet')
                          <span class="badge badge-info">@lang('Deposit Wallet')</span>
                          @else
                          <span class="badge badge-primary">@lang('Interest Wallet')</span>
                          @endif
                        </td>
                        <td data-label="@lang('Details')">{{$trx->details}}</td>
                        <td data-label="@lang('Post Balance')"><span> {{ __($general->cur_sym) }}{{ getAmount($trx->post_balance) }}</span></td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="100%" class="text-center">{{ __('No Transaction Found') }}</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- row end -->
          </div>
        </div>
      </div>
    </div>
@endsection
@push('style')
<style type="text/css">
  #copyBoard{
    cursor: pointer;
  }
</style>
@endpush
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