@extends($activeTemplate.'layouts.master')

@section('content')


    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="cmn-section">


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                        <div class="right float-right mb-4">
                            <a href="{{route('ticket.open') }}" class="btn cmn-btn">
                                <i class="fa fa-plus"></i> @lang('New Ticket')
                            </a>
                        </div>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive--md">
                        <table class="table style--two">
                            <thead>
                            <tr>
                                <th scope="col" class="text-left">@lang('Subject')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Last Reply')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($supports as $key => $support)
                                <tr>
                                    <td class="data-row text-left">
                                        <a href="{{ route('ticket.view', $support->ticket) }}"
                                           class="text-white font-weight-bold"> [Ticket#{{ $support->ticket }}
                                            ] {{ $support->subject }} </a></td>
                                    <td data-label="@lang('Status')">
                                        @if($support->status == 0)
                                            <span class="badge badge-primary py-1 px-2">@lang('Open')</span>
                                        @elseif($support->status == 1)
                                            <span class="badge badge-success py-1 px-2">@lang('Answered')</span>
                                        @elseif($support->status == 2)
                                            <span class="badge badge-warning py-1 px-2">@lang('Customer reply')</span>
                                        @elseif($support->status == 3)
                                            <span class="badge badge-dark py-1 px-2">@lang('Closed')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Last reply')">{{ diffForHumans($support->last_reply) }} </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('ticket.view', $support->ticket) }}"
                                           class="icon-btn base--bg text-dark">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{trans($empty_message)}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{$supports->links()}}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
