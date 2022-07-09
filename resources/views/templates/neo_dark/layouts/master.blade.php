<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                            <a href="{{ route('user.home') }}" class="btn btn-primary btn-small w-auto">@lang('Dashboard')</a>
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


                    <button type="button" class="dashboard-side-menu-open ml-auto"><i class="fa fa-bars"></i>
                    </button>
                </nav>
            </div>
        </div>
    </header>

    <!-- header-section end  -->


    @yield('content')


    @include($activeTemplate.'partials.sidebar')


    @stack('renderModal')


    @include($activeTemplate.'.partials.footer')
</main>


<script src="{{asset($activeTemplateTrue.'js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/bootstrap.min.js')}}"></script>

@include($activeTemplate.'partials.notify')

@stack('script-lib')

<script src="{{asset($activeTemplateTrue.'js/vendor/jquery.nice-select.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/slick.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/wow.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/vendor/viewport.jquery.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>


@stack('script')

<script>
    (function () {
        "use strict";
        $(document).on("change", ".langSel", function () {
            window.location.href = "{{url('/')}}/change/" + $(this).val();
        });
    })();
</script>


</body>
</html>
