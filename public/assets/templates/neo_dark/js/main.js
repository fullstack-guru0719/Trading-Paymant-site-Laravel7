(function($){
  "use strict";
  $(window).on("load", function() {
    //preloader
    $(".preloader").delay(300).animate({
      "opacity" : "0"
      }, 300, function() {
      $(".preloader").css("display","none");
    });
    var img=$('.bg_img');
      img.css('background-image', function () {
      var bg = ('url(' + $(this).data('background') + ')');
      return bg;
    });
  });
  // $('select').niceSelect();
  // mobile menu js
  $(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
    const element = $(this).parent("li");
    if (element.hasClass("open")) {
      element.removeClass("open");
      element.find("li").removeClass("open");
    }
    else {
      element.addClass("open");
      element.siblings("li").removeClass("open");
      element.siblings("li").find("li").removeClass("open");
    }
  });
  // header-fixed
  var fixed_top = $(".header-section");
  $(window).on("scroll", function(){
      if( $(window).scrollTop() > 300){  
          fixed_top.addClass("animated fadeInDown header-fixed");
      }
      else{
          fixed_top.removeClass("animated fadeInDown header-fixed");
      }
  });
  $(".header-search-btn").on('click', function(){
    //$(".header-top-search-area").toggleClass("open");
    if ($(this).hasClass('toggle-close')) {
        $(this).removeClass('toggle-close').addClass('toggle-open');
        $('.search-form-area').addClass('open');
    }
    else {
        $(this).removeClass('toggle-open').addClass('toggle-close');
        $('.search-form-area').removeClass('open');
    }
  });
  //close when click off of container
  $(document).on('click touchstart', function (e){
    if (!$(e.target).is('.header-search-btn, .header-search-btn *, .search-form-area, .search-form-area *')) {
      $('.search-form-area').removeClass('open');
      $('.header-search-btn').addClass('toggle-close');
    }
  });
   // Show or hide the sticky footer button
   $(window).on("scroll", function() {
    if ($(this).scrollTop() > 200) {
        $(".scroll-to-top").fadeIn(200);
    } else {
        $(".scroll-to-top").fadeOut(200);
    }
  });
  // Animate the scroll to top
  $(".scroll-to-top").on("click", function(event) {
    event.preventDefault();
    $("html, body").animate({scrollTop: 0}, 300);
  });
  $(".overview-item").each(function () {
    $(this).isInViewport(function (status) {
      if (status === "entered") {
        for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
          var el = document.querySelectorAll('.odometer')[i];
          el.innerHTML = el.getAttribute("data-odometer-final");
        }
      }
    });
  });
  $('.investor-slider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    speed: 700,
    arrows: true,
    nextArrow: '<div class="next"><i class="fa fa-angle-right"></i></div>',
    prevArrow: '<div class="prev"><i class="fa fa-angle-left"></i></div>',
    centerMode: true,
    dots: false,
    centerPadding: '0px',
    autoplay: true,
    mobileFirst:true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          centerMode: false
        }
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
          centerMode: false
        }
      },
      {
        breakpoint: 0,
        settings: {
          slidesToShow: 1,
          centerMode: false
        }
      }
    ]
  });
  $('.investor-slider-two').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    speed: 700,
    arrows: true,
    rows: 2,
    nextArrow: '<div class="next"><i class="fa fa-angle-right"></i></div>',
    prevArrow: '<div class="prev"><i class="fa fa-angle-left"></i></div>',
    dots: false,
    autoplay: true,
    mobileFirst:true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 0,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
    $('.currency-slider').slick({
        dots: false,
        infinite: false,
        autoplay: true,
        slidesToShow: 4,
        arrows: false,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 499,
                settings: {
                    slidesToShow: 2,
                }
            }
        ]
    });
  // testimonail-slider
  $('.testimonail-slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 700,
    arrows: true,
    nextArrow: '<div class="next"><i class="fa fa-angle-right"></i></div>',
    prevArrow: '<div class="prev"><i class="fa fa-angle-left"></i></div>',
    dots: false,
    autoplay: true,
    mobileFirst:true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 1
        }
      },
      {
        breakpoint: 0,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
    // dashboard side menu open & close js
    let dashboardSideMenu, openBtn, closeBtn;
    dashboardSideMenu = document.querySelector('.user-sidebar');
    openBtn = document.querySelector('.dashboard-side-menu-open');
    closeBtn = document.querySelector('.dashboard-side-menu-close');
    if(openBtn){
        openBtn.addEventListener('click', function(){
            dashboardSideMenu.classList.add('active');
        });
    }
    if(closeBtn){
        closeBtn.addEventListener('click', function(){
            dashboardSideMenu.classList.remove('active');
        });
    }
})(jQuery);