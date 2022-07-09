@php
    $topInvestor = \App\Models\Invest::with('user')
               ->selectRaw('SUM(amount) as totalAmount, user_id')
               ->orderBy('totalAmount', 'desc')
               ->groupBy('user_id')
               ->limit(6)
               ->get()->toArray();

    $top_investorContent = getContent('top_investor.content',true);
@endphp

<!-- investor-section start -->
<section class="investor-section pb-150 pt-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$top_investorContent->data_values->heading)</h2>
                    <p>@lang(@$top_investorContent->data_values->sub_heading)</p>
                </div><!-- section-header end -->
            </div>
        </div>
        <div class="investor-slider-area">
            <div class="investor-slider">
                @foreach($topInvestor as $k => $data)
                    <div class="investor-item">
                        <div class="investor-item__thumb">
                            <img src="{{getImage('assets/images/user/profile/'. @json_decode(json_encode($data['user']['image'])), '800x800') }}"  alt="image">
                        </div>
                        <div class="investor-item__content">
                            <h3 class="investor__name text-shadow">{{@json_decode(json_encode($data['user']['username']))}}</h3>
                            <p>@lang('Total Invest') <span lass="amount">{{$general->cur_sym}}{{$data['totalAmount'] }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- investor-section end -->


