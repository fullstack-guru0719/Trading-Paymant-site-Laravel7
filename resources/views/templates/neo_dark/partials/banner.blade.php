@php
    $bannerCaption = getContent('banner.content',true);
@endphp
<!-- hero-section start -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="hero-content">
                    <h2 class="hero__title">{{__(@$bannerCaption->data_values->heading)}}</h2>
                    <p>{{__(strip_tags(@$bannerCaption->data_values->description))}}</p>

                    <div class="btn-area">

                        @if(@$bannerCaption->data_values->btn_one_link)
                            <a href="{{@$bannerCaption->data_values->btn_one_link}}" class="btn btn-primary">{{@__($bannerCaption->data_values->btn_one_name)}}</a>
                        @endif
                        @if(@$bannerCaption->data_values->btn_two_link)
                            <a href="{{@$bannerCaption->data_values->btn_two_link}}" class="btn btn-primary">{{@__($bannerCaption->data_values->btn_two_name)}}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-thumb pulse-animation"><img src="{{getImage('assets/images/frontend/banner/'.@$bannerCaption->data_values->image)}}" alt="image"></div>
            </div>
        </div>
    </div>
</section>
<!-- hero-section end -->