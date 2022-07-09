<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:300,400,600,700|Open+Sans: 400,500,700&display=swap">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/vendor/bootstrap.min.css')}}">
    @stack('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/vendor/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/vendor/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/vendor/slick.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color}}&secondColor={{ $general->secondary_color}}">
    @stack('style')
</head>
<body>
@php echo  fbComment() @endphp
<div class="preloader">
    <div class="dl">
        <div class="dl__container">
            <div class="dl__corner--top"></div>
            <div class="dl__corner--bottom"></div>
        </div>
        <div class="dl__square"></div>
    </div>
</div>
<main class="color-version-one">
    <!-- header-section start  -->
    <header class="header-section">
        <div class="header-top">
            <div class="container-fluid">
                <div class="header-top-content d-flex flex-wrap align-items-center justify-content-between">
                    <div class="header-top-left">
                        <select class="langSel">
                            @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="header-top-right">
                        <div class="header-action d-flex flex-wrap align-items-center">
                            @guest
                            <a href="{{ route('user.login') }}" class="btn btn-primary btn-small">@lang('Login')</a>
                            <a href="{{ route('user.register') }}" class="btn btn-primary btn-small">@lang('Register')</a>
                            @else
                                <a href="{{ route('user.home') }}" class="btn btn-primary btn-small w-auto">@lang('Dashboard')</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-xl align-items-center">

                    <a href="{{url('/')}}" class="site-logo site-title">
                        <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo">
                    </a>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu-toggle"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav main-menu ml-auto">
                            <li><a href="{{route('home')}}">{{trans('Home')}}</a></li>
                            <li><a href="{{route('plan')}}">{{trans('Plan')}}</a></li>
                            @foreach($pages as $k => $data)
                                <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                            @endforeach

                            <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                            <li><a href="{{route('contact')}}">@lang('Contact')</a></li>



                            @guest
                            <li class="d-sm-none"><a href="{{route('user.login')}}">@lang('Login')</a></li>
                            <li class="d-sm-none"><a href="{{route('user.register')}}">@lang('Register')</a></li>
                            @endguest

                            @auth
                                <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
                            @endauth


                            <li class="menu_has_children d-sm-none">
                                <select class="langSel">
                                    @foreach($language as $item)
                                        <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>

                    </div><!-- navbar-collapse end -->
                </nav>
            </div>
        </div>
    </header>

    <!-- header-section end  -->


    @yield('content')


    @stack('renderModal')


    @include($activeTemplate.'.partials.footer')


@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    return $cookie;
@endphp
@if(@$cookie->data_values->status && !session('cookie_accepted'))
  <div class="cookie__wrapper">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <p class="txt my-2">
          @php echo @$cookie->data_values->description @endphp
          <a href="{{ @$cookie->data_values->link }}" class="text-primary" target="_blank">@lang('Cookie Policy')</a>
        </p>
          <button class="cmn-btn btn-md my-2 policy">@lang('Accept')</button>
      </div>
    </div>
  </div>
@endif
      
</main>



<script src="{{asset($activeTemplateTrue.'js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/bootstrap.min.js')}}"></script>

@stack('script-lib')

<script src="{{asset($activeTemplateTrue.'js/vendor/jquery.nice-select.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/slick.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/wow.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/viewport.jquery.js')}}"></script>



<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
@include($activeTemplate.'partials.notify')

@stack('script')

<script>
    (function () {
        "use strict";
        $(document).on("change", ".langSel", function () {
            window.location.href = "{{url('/')}}/change/" + $(this).val();
        });

        $('.policy').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get('{{route('cookie.accept')}}', function(response){
                iziToast.success({message: response, position: "topRight"});
                $('.cookie__wrapper').addClass('d-none');
            });
        });
    })();
</script>


</body>
</html>
