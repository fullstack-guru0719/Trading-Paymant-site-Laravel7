@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway | Trx')</th>
                                    <th>@lang('Initiated')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($withdrawals as $withdraw)
                                @php
                                    $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                                @endphp
                                <tr>
                                <td data-label="@lang('Gateway | Trx')">
                                    <span class="font-weight-bold">{{ __(@$withdraw->method->name) }}</span>
                                    <br>
                                    <small>{{ $withdraw->trx }}</small>
                                </td>
                                <td data-label="@lang('Initiated')">
                                    {{ showDateTime($withdraw->created_at) }} <br>  {{ diffForHumans($withdraw->created_at) }}
                                </td>

                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $withdraw->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $withdraw->user_id) }}"><span>@</span>{{ $withdraw->user->username }}</a> </span>
                                </td>


                                <td data-label="@lang('Amount')">
                                   {{ __($general->cur_sym) }}{{ getAmount($withdraw->amount ) }} - <span class="text-danger" data-toggle="tooltip" data-original-title="@lang('charge')">{{ getAmount($withdraw->charge)}} </span>
                                    <br>
                                    <strong data-toggle="tooltip" data-original-title="@lang('Amount after charge')">
                                    {{ getAmount($withdraw->amount-$withdraw->charge) }} {{ __($general->cur_text) }}
                                    </strong>

                                </td>

                                <td data-label="@lang('Conversion')">
                                   1 {{ __($general->cur_text) }} =  {{ getAmount($withdraw->rate) }} {{ __($withdraw->currency) }}
                                    <br>
                                    <strong>{{ getAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}</strong>
                                </td>



                                <td data-label="@lang('Status')">
                                    @if($withdraw->status == 2)
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                    @elseif($withdraw->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('Approved')</span>
                                    <br>{{ diffForHumans($withdraw->updated_at) }}
                                    @elseif($withdraw->status == 3)
                                    <span class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span>
                                    <br>{{ diffForHumans($withdraw->updated_at) }}
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="icon-btn ml-1 " data-toggle="tooltip" data-original-title="@lang('Detail')">
                                        <i class="la la-desktop"></i>
                                    </a>
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
                    {{ $withdrawals->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

@endsection




@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.withdrawals'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Withdrawal code/Username')"
                       value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else
        <form
            action="{{ route('admin.withdraw.search', $scope ?? str_replace('admin.withdraw.', '', request()->route()->getName())) }}"
            method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Withdrawal code/Username')"
                       value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush

