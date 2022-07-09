@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border--primary mt-2">
            <h5 class="card-header bg--primary">@lang('Deposit Commission')
                @if($general->deposit_commission == 0)
             <span class="badge badge-danger float-right">@lang('Disabled')</span>
             @else
             <span class="badge badge-success float-right">@lang('Enabled')</span>

             @endif
         </h5>
            <div class="card-body parent">


                    <div class="row">
                        <div class="col-md-12">
                            @if($general->deposit_commission == 0)
                            <a href="{{ route('admin.referral.status','deposit_commission') }}" class="btn btn--success btn-block mb-3">@lang('Enable Now')</a>
                            @else
                            <a href="{{ route('admin.referral.status','deposit_commission') }}" class="btn btn--danger btn-block mb-3">@lang('Disable Now')</a>
                            @endif
                        </div>
                    </div>

                 <div class="table-responsive--sm mt-2 mb-2">
                            <table class="table table--light style--two">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Level')</th>
                                    <th scope="col">@lang('Commission')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($trans->where('commission_type','deposit') as $key => $p)
                                    <tr>
                                        <td data-label="Level">@lang('LEVEL')# {{ $p->level }}</td>
                                        <td data-label="Commission">{{ $p->percent }} %</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table><!-- table end -->
                        </div>
                        <hr>



                <div class="row mt-3 mb-5">
                        <div class="col-md-6">
                            <input type="number" name="level" placeholder="@lang('HOW MANY LEVEL')" class="form-control input-lg levelGenerate">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn--success btn-block generate">
                                @lang('GENERATE')
                            </button>
                        </div>
                    </div>

                    <form action="{{route('admin.store.refer')}}"
                          method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="commission_type" value="deposit">
                        <div class="d-none levelForm">
                            
                            <div class="form-group">
                                <label class="text-success"> @lang('Level & Commission :')
                                    <small>@lang('(Old Levels will Remove After Generate)')</small>
                                </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="description referral-desc">
                                            <div class="row">
                                                <div class="col-md-12 planDescriptionContainer">

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn--primary btn-block my-3">@lang('Submit')</button>
                        </div>
                    </form>


            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border--primary mt-2">
            <h5 class="card-header bg--primary">@lang('Investment Commission')
                @if($general->invest_commission == 0)
             <span class="badge badge-danger float-right">@lang('Disabled')</span>
             @else
             <span class="badge badge-success float-right">@lang('Enabled')</span>

             @endif
         </h5>
            <div class="card-body parent">


                    <div class="row">
                        <div class="col-md-12">
                            @if($general->invest_commission == 0)
                            <a href="{{ route('admin.referral.status','invest_commission') }}" class="btn btn--success btn-block mb-3">@lang('Enable Now')</a>
                            @else
                            <a href="{{ route('admin.referral.status','invest_commission') }}" class="btn btn--danger btn-block mb-3">@lang('Disable Now')</a>
                            @endif
                        </div>
                    </div>

                 <div class="table-responsive--sm mt-2 mb-2">
                            <table class="table table--light style--two">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Level')</th>
                                    <th scope="col">@lang('Commission')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($trans->where('commission_type','invest') as $key => $p)
                                    <tr>
                                        <td data-label="Level">@lang('LEVEL')# {{ $p->level }}</td>
                                        <td data-label="Commission">{{ $p->percent }} %</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table><!-- table end -->
                        </div>
                        <hr>



                <div class="row mt-3 mb-5">
                        <div class="col-md-6">
                            <input type="number" name="level" placeholder="@lang('HOW MANY LEVEL')" class="form-control input-lg levelGenerate">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn--success btn-block generate">
                                @lang('GENERATE')
                            </button>
                        </div>
                    </div>

                    <form action="{{route('admin.store.refer')}}"
                          method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="commission_type" value="invest">
                        <div class="d-none levelForm">
                            
                            <div class="form-group">
                                <label class="text-success"> @lang('Level & Commission :')
                                    <small>@lang('(Old Levels will Remove After Generate)')</small>
                                </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="description referral-desc">
                                            <div class="row">
                                                <div class="col-md-12 planDescriptionContainer">

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn--primary btn-block my-3">@lang('Submit')</button>
                        </div>
                    </form>


            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border--primary mt-2">
            <h5 class="card-header bg--primary">@lang('Interest Commission')
                @if($general->invest_return_commission == 0)
             <span class="badge badge-danger float-right">@lang('Disabled')</span>
             @else
             <span class="badge badge-success float-right">@lang('Enabled')</span>

             @endif
         </h5>
            <div class="card-body parent">


                    <div class="row">
                        <div class="col-md-12">
                            @if($general->invest_return_commission == 0)
                            <a href="{{ route('admin.referral.status','invest_return_commission') }}" class="btn btn--success btn-block mb-3">@lang('Enable Now')</a>
                            @else
                            <a href="{{ route('admin.referral.status','invest_return_commission') }}" class="btn btn--danger btn-block mb-3">@lang('Disable Now')</a>
                            @endif
                        </div>
                    </div>

                 <div class="table-responsive--sm mt-2 mb-2">
                            <table class="table table--light style--two">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Level')</th>
                                    <th scope="col">@lang('Commission')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($trans->where('commission_type','interest') as $key => $p)
                                    <tr>
                                        <td data-label="Level">@lang('LEVEL')# {{ $p->level }}</td>
                                        <td data-label="Commission">{{ $p->percent }} %</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table><!-- table end -->
                        </div>
                        <hr>



                <div class="row mt-3 mb-5">
                        <div class="col-md-6">
                            <input type="number" name="level" placeholder="@lang('HOW MANY LEVEL')" class="form-control input-lg levelGenerate">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn--success btn-block generate">
                                @lang('GENERATE')
                            </button>
                        </div>
                    </div>

                    <form action="{{route('admin.store.refer')}}"
                          method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="commission_type" value="interest">
                        <div class="d-none levelForm">
                            
                            <div class="form-group">
                                <label class="text-success"> @lang('Level & Commission :')
                                    <small>@lang('(Old Levels will Remove After Generate)')</small>
                                </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="description referral-desc">
                                            <div class="row">
                                                <div class="col-md-12 planDescriptionContainer">

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn--primary btn-block my-3">@lang('Submit')</button>
                        </div>
                    </form>


            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script>
        $(document).ready(function () {
            "use strict";

            var max = 1;
            $(document).ready(function () {
                $(".generate").on('click', function () {

                    var levelGenerate = $(this).parents('.parent').find('.levelGenerate').val();
                    var a = 0;
                    var val = 1;
                    var viewHtml = '';
                    if (levelGenerate !== '' && levelGenerate > 0) {
                        $(this).parents('.parent').find('.levelForm').removeClass('d-none');
                        $(this).parents('.parent').find('.levelForm').addClass('d-block');

                        for (a; a < parseInt(levelGenerate); a++) {
                            viewHtml += `<div class="input-group mt-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text no-right-border">LEVEL</span>
                            </div>
                            <input name="level[]" class="form-control margin-top-10 no-left-border width-120" type="number" readonly value="${val++}" required placeholder="Level">
                            <input name="percent[]" class="form-control margin-top-10" type="text" required placeholder="@lang("Commission Percentage %")">
                            <span class="input-group-btn">
                            <button class="btn btn--danger margin-top-10 delete_desc" type="button"><i class='fa fa-times'></i></button></span>
                            </div>`;
                        }
                         $(this).parents('.parent').find('.planDescriptionContainer').html(viewHtml);

                    } else {
                        alert('Level Field Is Required');
                    }
                });

                $(document).on('click', '.delete_desc', function () {
                    $(this).closest('.input-group').remove();
                });
            });


        });
    </script>
@endpush
