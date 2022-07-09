@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-header">
                    @if(request()->routeIs('admin.users.transactions'))
                        <form action="" method="GET" class="form-inline float-sm-right bg--white">
                            <div class="input-group has_append">
                                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                            <div class="input-group has_append">
                                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Trx')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $trx->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $trx->user_id) }}"><span>@</span>{{ $trx->user->username }}</a> </span>
                                </td>

                                <td data-label="@lang('Trx')">
                                    <strong>{{ $trx->trx }}</strong>
                                </td>

                                <td data-label="@lang('Transacted')">
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>

                                <td data-label="@lang('Amount')" class="budget">
                                    <span class="font-weight-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                        {{ $trx->trx_type }} {{getAmount($trx->amount)}} {{ $general->cur_text }}
                                    </span>
                                </td>

                                <td data-label="@lang('Post Balance')" class="budget">
                                   {{ getAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                               </td>


                               <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ trans($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $transactions->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>



@endsection


@push('breadcrumb-plugins')
    <a href="

    @if(request()->routeIs('admin.report.transaction.deposit'))
    javascript:void(0)
    @else
    {{ route('admin.report.transaction.deposit') }}
    @endif

    " class="btn btn--primary mb-2
    @if(request()->routeIs('admin.report.transaction.deposit'))
    btn-disabled
    @endif
    ">@lang('Deposit Wallet Transaction')</a>


    <a href="

    @if(request()->routeIs('admin.report.transaction.interest'))
    javascript:void(0)
    @else
    {{ route('admin.report.transaction.interest') }}
    @endif

    " class="btn btn--primary mr-lg-2 mr-0 mb-2

    @if(request()->routeIs('admin.report.transaction.interest'))
    btn-disabled
    @endif

    ">@lang('Interest Wallet Transactions')</a>
@endpush


