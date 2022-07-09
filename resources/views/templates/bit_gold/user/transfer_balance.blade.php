@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <section class="cmn-section">
        <div class="container">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Wallet')</label>
                                <select class="form-control" name="wallet">
                                    <option value="">@lang('Select a wallet')</option>
                                    <option value="1">@lang('Deposit Wallet')</option>
                                    <option value="2">@lang('Interest Wallet')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Username')</label>
                                <input type="text" name="username" class="form-control form-control-lg">
                            </div>
                            <div class="form-group">
                                <label>@lang('Amount') <small class="text-success">( @lang('Charge'): {{ getAmount($general->f_charge) }} {{ $general->cur_text }} + {{ getAmount($general->p_charge) }}% )</small></label>
                                <div class="input-group">
                                    <input type="text" name="amount" class="form-control form-control-lg">
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Amount Will Cut From Your Account')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg calculation" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md w-100 cmn-btn">@lang('Transfer')</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@push('script')
<script type="text/javascript">
    $('input[name=amount]').on('input',function(){
        var amo = parseFloat($(this).val());
        var calculation = amo + ( parseFloat({{ $general->f_charge }}) + ( amo * parseFloat({{ $general->p_charge }}) ) / 100 );
        $('.calculation').val(calculation);
    });
</script>
@endpush

