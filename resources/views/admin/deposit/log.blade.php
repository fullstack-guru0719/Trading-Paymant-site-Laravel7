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
                            @forelse($deposits as $deposit)
                                @php
                                    $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                                @endphp
                                <tr>
                                    <td data-label="@lang('Gateway | Trx')">
                                         <span class="font-weight-bold"> {{ __($deposit->gateway->name) }} </span>
                                         <br>
                                         <small> {{ $deposit->trx }} </small>
                                    </td>

                                    <td data-label="@lang('Date')">
                                        {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                    </td>

                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $deposit->user->fullname }}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.users.detail', $deposit->user_id) }}"><span>@</span>{{ $deposit->user->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Amount')">
                                       {{ __($general->cur_sym) }}{{ getAmount($deposit->amount ) }} + <span class="text-danger" data-toggle="tooltip" data-original-title="@lang('charge')">{{ getAmount($deposit->charge)}} </span>
                                        <br>
                                        <strong data-toggle="tooltip" data-original-title="@lang('Amount with charge')">
                                        {{ getAmount($deposit->amount+$deposit->charge) }} {{ __($general->cur_text) }}
                                        </strong>
                                    </td>

                                    <td data-label="@lang('Conversion')">
                                       1 {{ __($general->cur_text) }} =  {{ getAmount($deposit->rate) }} {{__($deposit->method_currency)}}
                                        <br>
                                        <strong>{{ getAmount($deposit->final_amo) }} {{__($deposit->method_currency)}}</strong>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($deposit->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @elseif($deposit->status == 1)
                                            <span class="badge badge--success">@lang('Approved')</span>
                                             <br>{{ diffForHumans($deposit->updated_at) }}
                                        @elseif($deposit->status == 3)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                            <br>{{ diffForHumans($deposit->updated_at) }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.deposit.details', $deposit->id) }}"
                                           class="icon-btn ml-1 " data-toggle="tooltip" title="" data-original-title="@lang('Detail')">
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
                    {{ $deposits->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>



@endsection


@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.deposits'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Deposit code/Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else

        <form action="{{route('admin.deposit.search', $scope ?? str_replace('admin.deposit.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append  ">
                <input type="text" name="search" class="form-control" placeholder="@lang('Deposit code/Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush


