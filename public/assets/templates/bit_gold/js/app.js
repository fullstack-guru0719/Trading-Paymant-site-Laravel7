'use strict';

// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 50){  
        fixed_top.addClass("animated fadeInDown menu-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown menu-fixed");
    }
});

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

let img=$('.bg_img');
img.css('background-image', function () {
  let bg = ('url(' + $(this).data('background') + ')');
  return bg;
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


//preloader js code
$(".preloader").delay(300).animate({
  "opacity" : "0"
  }, 300, function() {
  $(".preloader").css("display","none");
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})



$(".header-serch-btn").on('click', function(){
  //$(".header-top-search-area").toggleClass("open");
  if ($(this).hasClass('toggle-close')) {
      $(this).removeClass('toggle-close').addClass('toggle-open');
      $('.header-top-search-area').addClass('open');
  }
  else {
      $(this).removeClass('toggle-open').addClass('toggle-close');
      $('.header-top-search-area').removeClass('open');
  }
});

//close when click off of container
$(document).on('click touchstart', function (e){
  if (!$(e.target).is('.header-serch-btn, .header-serch-btn *, .header-top-search-area, .header-top-search-area *')) {
    $('.header-top-search-area').removeClass('open');
    $('.header-serch-btn').addClass('toggle-close');
  }
});


/* ==============================
          slider area
================================= */

// testimonial slider 
$('.testimonial-slider').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: false,
  autoplay: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1
      }
    }
  ]
});

$('.product-two-slider').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 2,
  slidesToScroll: 1,
  arrows: true,
  autoplay: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});

$('.product-details-thumb-slider').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  autoplay: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
});



$('.payment-slider').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 6,
  slidesToScroll: 1,
  arrows: false,
  autoplay: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});