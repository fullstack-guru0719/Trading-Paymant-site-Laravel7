@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                
                <div class="card-body">
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
                        <form action="{{ route('admin.report.commissions.search') }}" method="GET" class="form-inline float-sm-right bg--white mb-3">
                            <div class="input-group has_append">
                                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    @endif
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Type - Transaction')</th>
                                <th scope="col">@lang('Level - From')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $data->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->user->id) }}"><span>@</span>{{ $data->user->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Type - Transaction')">
                                        @if($data->type == 'deposit')
                                        <span class="badge badge--success">@lang('Deposit')</span>
                                        @elseif($data->type == 'interest')
                                        <span class="badge badge--info">@lang('Interest')</span>
                                        @else
                                        <span class="badge badge--primary">@lang('Invest')</span>
                                        @endif
                                        <br>
                                        {{__($data->trx)}}
                                    </td>
                                    <td data-label="@lang('Level - From')">
                                        <span class="font-weight-bold">{{__(ordinal($data->level))}}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->bywho->id) }}"><span>@</span>{{ $data->bywho->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <span class="font-weight-bold" data-toggle="tooltip" title="@lang('Transacted Amount') : {{__($general->cur_sym)}}{{getAmount($data->trx_amo)}}">{{__($general->cur_sym)}}{{getAmount($data->commission_amount)}}</span>
                                        <br>
                                        <span data-toggle="tooltip" title="@lang('Percent')" class="font-weight-bold">{{ getAmount($data->percent) }}%</span>
                                    </td>
                                    <td data-label="@lang('Description')">
                                        {{__($data->title)}}
                                    </td>
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
                    {{ $logs->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
<div class="mb-3">
    
    <a href="

    @if(request()->routeIs('admin.report.commissions.deposit'))
    javascript:void(0)
    @else
    {{ route('admin.report.commissions.deposit') }}
    @endif

    " class="btn btn--primary mb-2
    @if(request()->routeIs('admin.report.commissions.deposit'))
    btn-disabled
    @endif
    ">@lang('Deposit Commission')</a>


    <a href="

    @if(request()->routeIs('admin.report.commissions.interest'))
    javascript:void(0)
    @else
    {{ route('admin.report.commissions.interest') }}
    @endif

    " class="btn btn--primary mb-2

    @if(request()->routeIs('admin.report.commissions.interest'))
    btn-disabled
    @endif

    ">@lang('Interest Commission')</a>


    <a href="

    @if(request()->routeIs('admin.report.commissions.invest'))
    javascript:void(0)
    @else
    {{ route('admin.report.commissions.invest') }}
    @endif

    " class="btn btn--primary mb-2 mr-2

    @if(request()->routeIs('admin.report.commissions.invest'))
    btn-disabled
    @endif

    ">@lang('Invest Commission')</a>
</div>
<div>
    
</div>
@endpush