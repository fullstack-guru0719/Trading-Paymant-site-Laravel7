@php
    use App\Models\Deposit;
    use App\Models\Frontend;
    use App\Models\Withdrawal;


    $ass =  Deposit::first();
    $latestDeposit = Deposit::with('user', 'gateway')->where('status', 1)->latest()->limit(10)->get() ;
    $fakeDeposit = Frontend::where('data_keys','transaction.element')->whereJsonContains('data_values->trx_type','deposit')->limit(10)->get();
    $deposits =  $latestDeposit->merge($fakeDeposit);
    $deposits = $deposits->sortByDesc('created_at')->take(10);


    $latestWithdraw = Withdrawal::with('user', 'method')->where('status', 1)->latest()->limit(10)->get();
    $fakeWithdraw = Frontend::where('data_keys','transaction.element')->whereJsonContains('data_values->trx_type','withdraw')->limit(10)->get();
    $withdrawals =  $latestWithdraw->merge($fakeWithdraw);
    $withdrawals = $withdrawals->sortByDesc('created_at')->take(10);


@endphp
<!-- latest-transaction-section start -->
<section class="latest-transaction-section pb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$transactionContent->data_values->heading)</h2>
                    <div class="header__divider">
                        <span class="left-dot"></span>
                        <span class="right-dot"></span>
                    </div>
                    <p>@lang(@$transactionContent->data_values->sub_heading)</p>
                </div><!-- section-header end -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active color-one" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">@lang('Latest Deposit')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-two" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">@lang('Latest Withdraw')</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive--sm neu--table">
                            <table class="table table-striped text-white">
                                <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Gateway')</th>
                                </tr>
                                </thead>
                                <tbody>
                               @foreach($deposits as $data)
                                  <tr>
                                    @if(@$data->data_values)
                                    <td data-label="@lang('Name')">
                                        {{__(@$data->data_values->name)}}
                                    </td>
                                    <td data-label="@lang('Date')">{{@$data->data_values->date}}</td>
                                    <td data-label="@lang('Amount')">{{__($general->cur_sym)}} {{@$data->data_values->amount}}</td>
                                    <td data-label="@lang('Gateway')">{{__(@$data->data_values->gateway)}}</td>
                                    @else
                                      <td data-label="@lang('Name')">
                                          @lang(@$data->user->fullname)
                                      </td>
                                      <td data-label="@lang('Date')">{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                      <td data-label="@lang('Amount')">{{__($general->cur_sym)}} {{getAmount($data->amount)}}</td>
                                      <td data-label="@lang('Gateway')">{{__($data->gateway->name)}}</td>
                                    @endif
                                  </tr>
                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive--sm neu--table">
                            <table class="table table-striped text-white">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Date')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Method')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($withdrawals as $data)
                                  <tr>
                                    @if(@$data->data_values)
                                    <td data-label="@lang('Name')">
                                        {{__(@$data->data_values->name)}}
                                    </td>
                                    <td data-label="@lang('Date')">{{@$data->data_values->date}}</td>
                                    <td data-label="@lang('Amount')">{{__($general->cur_sym)}} {{@$data->data_values->amount}}</td>
                                    <td data-label="@lang('Method')">{{__(@$data->data_values->gateway)}}</td>
                                    @else
                                      <td data-label="@lang('Name')">
                                          @lang(@$data->user->fullname)
                                      </td>
                                      <td data-label="@lang('Date')">{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                      <td data-label="@lang('Amount')">{{__($general->cur_sym)}} {{getAmount($data->amount)}}</td>
                                      <td data-label="@lang('Method')">{{__($data->method->name)}}</td>
                                    @endif
                                  </tr>
                                  @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

