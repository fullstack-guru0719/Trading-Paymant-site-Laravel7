@php
  $calculationCaption = getContent('calculation.content',true);
  $planList = \App\Models\Plan::where('status', 1)->latest()->get();
@endphp
<section class="pt-120 pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="section-header text-center">
              <h2 class="section-title"><span class="font-weight-normal">{{ __(@$calculationCaption->data_values->heading_w) }}</span> <b class="base--color">{{ __(@$calculationCaption->data_values->heading_c) }}</b></h2>
              <p>{{ __(@$calculationCaption->data_values->sub_heading) }}</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-xl-8">
            <div class="profit-calculator-wrapper">
              <form class="profit-calculator">
                <div class="row">
                  <div class="col-lg-6">
                    <label>@lang('Choose Plan')</label>
                    <select class="base--bg" id="changePlan">
                      @foreach($planList as $k => $data)
                        <option value="{{$data->id}}" >{{$data->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-6">
                    <label>@lang('Invest Amount')</label>
                    <input type="text" name="#0" id="#0" placeholder="0.00" class="form-control base--bg invest-input" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                  </div>
                  <div class="col-lg-12">
                    <label>@lang('Profit Amount')</label>
                    <input type="text" class="form-control base--bg profit-input" disabled>
                    <code class="period"></code>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

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