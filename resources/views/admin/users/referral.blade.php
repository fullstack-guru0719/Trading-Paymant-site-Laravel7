@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Fullname')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Phone')</th>
                                <th scope="col">@lang('Joined At')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referrals as $referral)
                                <tr>
                                    <td data-label="@lang('SL')">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td data-label="@lang('Fullname')">{{ __($referral->fullname) }}
                                    <td data-label="@lang('Email')">{{ __($referral->email) }}
                                    <td data-label="@lang('Phone')">{{ __($referral->mobile) }}
                                    </td>
                                    <td data-label="@lang('Joined At')">{{ showDateTime($referral->created_at) }}</td>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('User Not Found')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


