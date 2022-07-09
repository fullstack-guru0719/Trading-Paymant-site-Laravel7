@extends($activeTemplate.'layouts.master')

@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="cmn-section pt-60">
        <div class="container">
            <div class="row justify-content-center mt-2">
                <div class="col-md-12">
                    <div class="right float-right mb-5">
                        <a href="{{ route('user.withdraw') }}" class="btn cmn-btn">
                            @lang('Withdraw Now')                            
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 ">

                    <div class="table-responsive--md">
                        <table class="table style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Rate')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Receivable')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('More')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{getAmount($data->amount)}} {{$general->cur_text}}</strong> <br>
                                       @lang('via') {{ $data->method->name   }}</td>


                             
                                    <td data-label="@lang('Rate')">
                                       1  {{$general->cur_text}} = {{getAmount($data->rate)}} {{$data->currency}} <br>  
                                       {{getAmount($data->amount)}} {{$general->cur_text}} = {{round($data->amount*$data->rate,2)}} {{$data->currency}}
                                    </td>



                                    <td data-label="@lang('Charge')">
                                        <strong>{{getAmount($data->charge)}}  {{$general->cur_text}} </strong> <br>    or {{round($data->charge*$data->rate,2)}}   {{$data->currency}}
                                    </td>

                                    <td data-label="@lang('Receivable')" class="text-success">
                                        <strong>{{getAmount($data->final_amount, currency()['fiat'])}} {{$data->currency}}</strong> 
                                    </td>


                                    <td data-label="@lang('Status')">
                                        @if($data->status == 2)
                                            <span class="badge badge-warning">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge badge-success">@lang('Completed')</span>
                                        @elseif($data->status == 3)
                                            <span class="badge badge-danger">@lang('Rejected')</span>
                                            
                                        @endif

                                    </td>
                                    <td data-label="@lang('More')">
                                        <button class="btn-info btn-rounded approveBtn" 
                                                   data-info="{{json_encode($data->withdraw_information)}}"
                                                   data-admin_feedback="{{$data->admin_feedback}}"
                                                   data-transactions="{{ $data->trx }}"><i class="fa fa-list"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="9">{{ $empty_message }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{$withdraws->links()}}
                    </div>


                </div>
            </div>
        </div>
    </section>



    {{-- Detail MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item dark-bg">@lang('Transactions') : <span class="trx"></span></li>
                        <li class="list-group-item dark-bg">@lang('Admin Feedback') : <span class="feedback"></span></li>
                    </ul>
                    <ul class="list-group withdraw-detail mt-1">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('.trx').text($(this).data('transactions'));
                modal.find('.feedback').text($(this).data('admin_feedback'));
                var list = [];
                var details =  Object.entries($(this).data('info'));

                var ImgPath = "{{asset(imagePath()['verify']['withdraw']['path'])}}/";
                var singleInfo = '';
                for (var i = 0; i < details.length; i++) {
                    if (details[i][1].type == 'file') {
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="..." class="w-100">
                                        </li>`;
                    }else{
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span> 
                                        </li>`;
                    }
                }
                
                if (singleInfo)
                {
                    modal.find('.withdraw-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${singleInfo}`);
                }else{
                    modal.find('.withdraw-detail').html(`${singleInfo}`);
                }
                modal.modal('show');
            });
        });
    </script>
@endpush
