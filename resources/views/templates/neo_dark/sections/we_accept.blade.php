@php
    $weAccept = \App\Models\Gateway::where('status', '1')->get();

    $weAcceptContent = getContent('we_accept.content',true);
@endphp

@if(0 < count($weAccept))

    <!--=======Currency-Accept-Section Starts Here=======-->
    <section class="currency-accept-section pt-150 pb-150">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-left margin-olpo mb-lg-0">
                        <h2 class="section__title">@lang(@$weAcceptContent->data_values->heading)</h2>
                        <p>@lang(@$weAcceptContent->data_values->sub_heading)</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="currency-slider">
                        @foreach($weAccept as $data)
                        <div class="payment-thumb">
                            <a href="javascript:void(0)">
                                <img src="{{getImage(imagePath()['gateway']['path'].'/'. $data->image)}}" alt="sponsor">
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======Currency-Accept-Section Ends Here=======-->

@endif
