@php
  $whyChooseCaption = getContent('why_choose.content',true);
  $whyChooseElements = getContent('why_choose.element','','',1);
@endphp
<section class="pt-120 pb-120 overlay--radial bg_img" data-background="{{ getImage('assets/images/frontend/why_choose/'.@$whyChooseCaption->data_values->image,'1920x1281') }}">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <div class="section-header">
              <h2 class="section-title"><span class="font-weight-normal">{{ __(@$whyChooseCaption->data_values->heading_w) }}</span> <b class="base--color">{{ __(@$whyChooseCaption->data_values->heading_c) }}</b></h2>
              <p>{{ __(@$whyChooseCaption->data_values->sub_heading) }}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row justify-content-center mb-none-30">
          @foreach($whyChooseElements as $whyChooseElement)
          <div class="col-xl-4 col-md-6 mb-30">
            <div class="choose-card border-radius--5">
              <div class="choose-card__header mb-3">
                <div class="choose-card__icon base--color">
                  @php echo @$whyChooseElement->data_values->icon @endphp
                </div>
                <h4 class="choose-card__title base--color">{{ __(@$whyChooseElement->data_values->title) }}</h4>
              </div>
              <p>@lang(@$whyChooseElement->data_values->content)</p>
            </div><!-- choose-card end -->
          </div>
          @endforeach
        </div>
      </div>
    </section>