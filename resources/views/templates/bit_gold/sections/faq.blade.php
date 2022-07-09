@php
  $faqCaption = getContent('faq.content',true);
  $faqElements = getContent('faq.element','','',1);
@endphp
<section class="pt-120 pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <div class="section-header">
              <h2 class="section-title"><span class="font-weight-normal">{{ __(@$faqCaption->data_values->heading_w) }}</span> <b class="base--color">{{ __(@$faqCaption->data_values->heading_c) }}</b></h2>
              <p>{{ __(@$faqCaption->data_values->sub_heading) }}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="accordion cmn-accordion" id="accordionExample">
              @foreach($faqElements as $faqElement)
              <div class="card">
                <div class="card-header" id="heading{{ $loop->index }}">
                  <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                      <i class="las la-question-circle"></i>
                      <span>{{ __($faqElement->data_values->question) }}</span>
                    </button>
                  </h2>
                </div>
            
                <div id="collapse{{ $loop->index }}" class="collapse" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample" style="">
                  <div class="card-body">
                    @lang(@$faqElement->data_values->answer)
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>