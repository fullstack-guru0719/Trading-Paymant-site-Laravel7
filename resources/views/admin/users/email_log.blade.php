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
                                <th>@lang('From')</th>
                                <th>@lang('To')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Mail Sender')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>

                                        <td data-label="@lang('From')">{{ $log->from }}</td>


                                        <td data-label="@lang('To')"> {{ $log->to }}</td>

                                

                                        <td data-label="@lang('Subject')">{{ __($log->subject) }}</td>

                                        <td data-label="@lang('Mail Sender')">{{ __($log->mail_sender) }}</td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.users.email.details',$log->id) }}" class="icon-btn btn--primary"><i class="fas fa-desktop"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $logs->links() }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection

