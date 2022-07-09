@php
    $planList = \App\Models\Plan::where('status', 1)->latest()->get();

    $calculationContent = getContent('calculation.content',true);
@endphp


<!-- profit-calculator-section start -->
<section class="profit-calculator-section pb-150 pt-150">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="profit-calculator-wrapper">
                    <h2 class="title">@lang(@$calculationContent->data_values->heading)</h2>
                    <p class="mb-4">@lang(@$calculationContent->data_values->sub_heading)</p>

                    <form class="profit-calculator-form exchange-form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>@lang('Plan')</label>
                                <select  id="changePlan">
                                    <option value="">@lang('Choose Plan')</option>
                                    @foreach($planList as $k => $data)
                                        <option value="{{$data->id}}" >{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>@lang('Invest Amount')</label>
                                <input type="text" placeholder="0.00" class="invest-input"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                            </div>


                            <div class="form-group col-md-12">
                                <label>@lang('Return')</label>
                                <input type="text" class="profit-input" readonly>
                                <code class="period"></code>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="profit-thumb">
                    <img src="{{getImage($activeTemplateTrue.'images/calculator.png')}}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- profit-calculator-section end -->


@push('script')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $("#changePlan").on('change', function () {
                    var planId = $("#changePlan option:selected").val();
                    var investAmount = $('.invest-input').val();
                    var profitInput = $('.profit-input').val('');

                    $('.period').text('');

                    if (investAmount != '' && planId != null) {
                        ajaxPlanCalc(planId, investAmount)
                    }
                });

                $(".invest-input").on('change', function () {
                    var planId = $("#changePlan option:selected").val();
                    var investAmount = $(this).val();
                    var profitInput = $('.profit-input').val('');
                    $('.period').text('');
                    if (investAmount != '' && planId != null) {
                        ajaxPlanCalc(planId, investAmount)
                    }
                });
            });
            function ajaxPlanCalc(planId, investAmount) {
                $.ajax({
                    url: "{{route('planCalculator')}}",
                    type: "post",
                    data: {
                        planId,
                        investAmount
                    },
                    success: function (response) {
                        var alertStatus = "{{$general->alert}}";
                        if (response.errors) {
                            iziToast.error({message: response.errors, position: "topRight"});
                        }else{
                            var msg = `${response.description}`
                            $('.profit-input').val(msg);
                            if(response.netProfit){
                                $('.period').text('Net Profit '+response.netProfit);
                            }
                        }
                    }
                });
            }
        })(jQuery);

    </script>
@endpush
