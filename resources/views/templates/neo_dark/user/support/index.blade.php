@extends($activeTemplate.'layouts.master')

@section('content')


    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="dashboard__header mb-4">
                        <div class="left">
                            <h3>{{trans($page_title)}}</h3>
                        </div>
                        <div class="right">
                            <a href="{{route('ticket.open') }}" class="btn btn-success btn-sm action-btn btn-primary">
                                <i class="fa fa-plus"></i> @lang('New Ticket')
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive--sm neu--table">
                        <table class="table text-white">
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
                                    <td class="data-row text-left" data-label="@lang('Subject')">
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
                                           class="btn btn-primary btn-sm action-btn ">
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
