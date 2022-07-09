<!-- footer-section start -->
<footer class="footer-section">
    <div class="container">
        <div class="row mb-none-50 justify-content-center text-center">
            <div class="col-xl-6 col-md-7 mb-50">
                <div class="footer-widget">
                    <div class="about__widget">
                        <a href="{{route('home')}}">
                            <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="footer"
                                 class="max-250">
                        </a>
                        <p class="mt-3">@lang(@$contact->data_values->website_footer)</p>

                        <ul class="social-links">

                            @foreach($socials as $data)
                                <li>
                                    <a href="{{@$data->data_values->url}}" target="_blank" title="{{@$data->data_values->title}}">
                                        @php echo  @$data->data_values->icon  @endphp
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                        @php
                          $links = getContent('links.element','','',1);
                        @endphp
                        <ul class="privacy-links">
                            @foreach($links as $link)
                            <li><a href="{{ route('linkDetails',[slug($link->data_values->title),$link->id]) }}">@lang($link->data_values->title)</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- footer-widget end -->
            </div>
        </div>
    </div>
</footer>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copy-right-text">&copy; {{date('Y')}} <a href="{{url('/')}}" class="text-white">@lang($general->sitename)</a>. @lang('All Rights Reserved')</p>
                </div>
            </div>
        </div>
    </div>
<!-- footer-section end  -->
@include('partials.plugins')

