<section class="inner-hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="inner-hero-content">
                    <h2 class="inner-hero__title text-shadow">{{__($page_title)}}</h2>
                    <ul class="page__breadcums">
                        <li><a href="{{url('/')}}">@lang('home')</a></li>
                        <li>{{__($page_title)}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="particles"></div>
</section>
@push('script-lib')
<script src="{{asset($activeTemplateTrue.'js/particles.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/colorJs.php?color='.$general->base_color)}}"></script>
@endpush