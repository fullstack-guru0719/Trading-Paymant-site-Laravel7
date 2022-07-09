@php
    $faqs = getContent('faq.element');
    $faqContent = getContent('faq.content',true);
@endphp
<!-- faq-section start -->
<section class="faq-section pt-150 pb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$faqContent->data_values->heading)</h2>
                    <p>@lang(@$faqContent->data_values->sub_heading)</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="accordion cmn-accordion style--two" id="categoryAccordion">
                    @foreach($faqs as $k=>$data)
                    <div class="card">
                        <div class="card-header" id="h-{{$k}}">
                            <button class="acc-btn" type="button" data-toggle="collapse" data-target="#c-{{$k}}" aria-expanded="{{($k==0) ? 'true':'false'}}" aria-controls="c-{{$k}}">
                                <span class="text">{{__(@$data->data_values->question)}}</span>
                            </button>
                        </div>
                        <div id="c-{{$k}}" class="collapse {{($k==0) ? 'show':''}} " aria-labelledby="h-{{$k}}" data-parent="#categoryAccordion">
                            <div class="card-body">
                                <p>@php echo @$data->data_values->answer @endphp


                                {{__(@$data->data_values->answer)}}

                            </p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq-section end -->



