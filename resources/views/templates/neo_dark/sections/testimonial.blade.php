@php
    $testimonial = getContent('testimonial.element');
    $testimonialContent = getContent('testimonial.content',true);
@endphp

<!-- testimonial-section start -->
<section class="testimonial-section pb-150 pt-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$testimonialContent->data_values->heading)</h2>
                    <div class="header__divider">
                        <span class="left-dot"></span>
                        <span class="right-dot"></span>
                    </div>
                    <p>@lang(@$testimonialContent->data_values->sub_heading)</p>
                </div><!-- section-header end -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-slider-area">
                    <div class="testimonail-slider">
                        @foreach($testimonial as $data)
                        <div class="testimonial-single">
                            <div class="client__thumb"><img src="{{getImage('assets/images/frontend/testimonial/'.@$data->data_values->image)}}" alt="image"></div>
                            <i class="flaticon-quotation"></i>
                            <p> {{__(@$data->data_values->quote)}}</p>
                            <h4 class="client__name">{{__(@$data->data_values->author)}}</h4>
                            <span class="designation">{{__(@$data->data_values->designation)}}</span>
                        </div><!-- testimonial-single end -->
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial-section end  -->
