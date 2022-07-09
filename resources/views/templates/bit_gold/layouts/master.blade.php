<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/bootstrap.min.css') }}">
  <!-- fontawesome 5  -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/all.min.css') }}">
  <!-- line-awesome webfont -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/line-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/animate.min.css') }}">
  <!-- slick slider css -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/slick.css') }}">
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/dots.css') }}">
  @stack('style-lib')
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/custom.css') }}">
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color}}&secondColor={{ $general->secondary_color}}">
  @stack('style')
</head>
  <body>
@php echo  fbComment() @endphp
    
  
    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
      <span class="scroll-icon">
        <i class="fa fa-rocket" aria-hidden="true"></i>
      </span>
    </div>
    <!-- scroll-to-top end -->

  <div class="full-wh">
    <!-- STAR ANIMATION -->
    <div class="bg-animation">
      <div id='stars'></div>
      <div id='stars2'></div>
      <div id='stars3'></div>
      <div id='stars4'></div>
    </div><!-- / STAR ANIMATION -->
  </div>
  <div class="page-wrapper">
      <!-- header-section start  -->
  <header class="header">
    <div class="header__bottom">
      <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
          <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="site-logo"></a>
          <ul class="account-menu responsive-account-menu ml-3">
            @guest
            <li class="icon"><a href="{{ route('user.login') }}"><i class="las la-user"></i></a></li>
            @else
            <li class="icon"><a href="{{ route('user.home') }}"><i class="las la-user"></i></a></li>
            @endif
          </ul> 
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-toggle"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav main-menu ml-auto">
              <li> <a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
              <li><a href="{{route('user.plan')}}">@lang('Invesment')</a></li>
              <li><a href="{{route('user.deposit')}}">@lang('Deposit')</a></li>
              <li><a href="{{route('user.withdraw')}}">@lang('Withdraw')</a></li>
              <li><a href="{{route('user.transactions.deposit')}}">@lang('Transactions')</a></li>
              <li class="menu_has_children"><a href="#0">@lang('Referrals')</a>
                <ul class="sub-menu">
                  <li><a href="{{route('user.referral.users')}}">@lang('Referred Users')</a></li>
                  <li><a href="{{ route('user.referral.commissions.deposit') }}">@lang('Referral Commissions')</a></li>
                </ul>
              </li>
              <li class="menu_has_children"><a href="#0">@lang('Account')</a>
                <ul class="sub-menu">
                  <li><a href="{{route('user.profile-setting')}}">@lang('Profile Setting')</a></li>
                  @if($general->b_transfer)
                  <li><a href="{{route('user.transfer.balance')}}">
                    @lang('Transfer Balance')</a></li>
                  @endif
                  <li><a href="{{route('user.change-password')}}">
                    @lang('Change Password')</a></li>
                  <li><a href="{{route('ticket')}}">
                    @lang('Support Ticket')</a></li>
                  <li><a href="{{route('user.twofactor')}}">
                    @lang('2FA Security')</a></li>
                  <li><a href="{{ route('user.logout') }}"> {{ __('Logout') }}</a></li>
                </ul>
              </li>
            </ul>
            <div class="nav-right">
              <ul class="account-menu ml-3">
                @guest
                <li class="icon"><a href="{{ route('user.login') }}"><i class="las la-user"></i></a></li>
                @else
                <li class="icon"><a href="{{ route('user.home') }}"><i class="las la-user"></i></a></li>
                @endif
              </ul>  
              <select class="select d-inline-block w-auto ml-xl-3 langSel">
                @foreach($language as $item)
                  <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </nav>
      </div>
    </div><!-- header__bottom end -->
  </header>
  <!-- header-section end  -->

    @yield('content')

    @stack('renderModal')


    <!-- footer section start -->
            @php
              $links = getContent('links.element','','',1);
              $footer = getContent('footer.content',true);
              $socials = getContent('social_icon.element','','',1);
            @endphp
<footer class="footer bg_img" data-background="{{ getImage('assets/images/frontend/footer/'.@$footer->data_values->image,'1920x1281') }}">
  <div class="footer__top">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12 text-center">
          <a href="{{ route('home') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image"></a>
          <ul class="footer-short-menu d-flex flex-wrap justify-content-center mt-3">
            @foreach($links as $link)
            <li><a href="{{ route('linkDetails',[slug($link->data_values->title),$link->id]) }}">@lang($link->data_values->title)</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer__bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 text-md-left text-center">
          <p>@lang('© '.date('Y').' <a href="'.route('home').'" class="base--color">'.$general->sitename.'</a>. All rights reserved')</p>
        </div>
        <div class="col-lg-6">
          <ul class="social-link-list d-flex flex-wrap justify-content-md-end justify-content-center">
            @foreach($socials as $social)
            <li><a href="{{ @$social->data_values->url }}">@php echo @$social->data_values->icon @endphp</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- footer section end -->
  </div> <!-- page-wrapper end -->
    <!-- jQuery library -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery-3.5.1.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/bootstrap.bundle.min.js') }}"></script>

  @stack('script-lib')
  <!-- slick slider js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/slick.min.js') }}"></script>
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/wow.min.js') }}"></script>
  <!-- dashboard custom js -->
  <script src="{{ asset($activeTemplateTrue.'/js/app.js') }}"></script>


  @include($activeTemplate.'partials.notify')

  
  @include('partials.plugins')

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

  </body>
</html> 