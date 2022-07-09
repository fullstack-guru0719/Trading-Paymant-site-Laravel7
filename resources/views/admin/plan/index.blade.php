@extends('admin.layouts.app')
@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Invest Limit')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($plan as $data)
                            <tr>
                                <td data-label="@lang('Name')">{{trans($data->name)}}</td>
                                <td data-label="@lang('Invest Limit')">
                                    @if($data->fixed_amount == 0)
                                        <span class="price d-block">{{trans($general->cur_sym)}}{{$data->minimum}}
                                            - {{trans($general->cur_sym)}}{{$data->maximum}}</span>
                                    @else
                                        <span class="price d-block">{{$general->cur_sym}}{{$data->maximum}}</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--warning">@lang('In-active')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                     <a href="{{route('admin.plan-edit',$data->id)}}" class="icon-btn"><i class="las la-pen"></i></a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Data Not Found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $plan->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.plan-create')}}" class="btn btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush


