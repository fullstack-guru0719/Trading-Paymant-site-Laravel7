'use strict';

$(function(){
  $('#sidebar__menuWrapper').slimScroll({
    height: 'calc(100vh - 86.75px)'
  });
});

$(function(){
  $('.dropdown-menu__body').slimScroll({
    height: '270px'
  });
});

// modal-dialog-scrollable
$(function(){
  $('.modal-dialog-scrollable .modal-body').slimScroll({
    height: '100%'
  });
});

// activity-list 
$(function(){
  $('.activity-list').slimScroll({
    height: '385px'
  });
});

// recent ticket list 
$(function(){
  $('.recent-ticket-list__body').slimScroll({
    height: '295px'
  });
});





$('#navbar-search__field').on('input', function () {
    var search = $(this).val().toLowerCase();


    var search_result_pane = $('.navbar_search_result');
    $(search_result_pane).html('');
    if (search.length == 0) {
        return;
    }

    // search
    var match = $('.sidebar__menu-wrapper .nav-link').filter(function (idx, elem) {
        return $(elem).text().trim().toLowerCase().indexOf(search) >= 0 ? elem : null;
    }).sort();




    // show search result
    // search not found
    if (match.length == 0) {
        $(search_result_pane).append('<li class="text-muted pl-5">No search result found.</li>');
        return;
    }
    // search found
    match.each(function (idx, elem) {
        var item_url = $(elem).attr('href') || $(elem).data('default-url');
        var item_text = $(elem).text().replace(/(\d+)/g, '').trim();
        $(search_result_pane).append(`<li><a href="${item_url}">${item_text}</a></li>`);
    });


});

// $(".sidebar-dropdown > a").click(function() {
//   $(".sidebar-submenu").slideUp(200);
//   if (
//     $(this)
//       .parent()
//       .hasClass("open")
//   ) {
//     $(".sidebar-dropdown").removeClass("open");
//     $(this)
//       .parent()
//       .removeClass("open");
//   } else {
//     $(".sidebar-dropdown").removeClass("open");
//     $(this)
//       .next(".sidebar-submenu")
//       .slideDown(200);
//     $(this)
//       .parent()
//       .addClass("open");
//   }
// });

let img = $('.bg_img');
img.css('background-image', function () {
  let bg = ('url(' + $(this).data('background') + ')');
  return bg;
});

  const navTgg = $('.navbar__expand');
  navTgg.on('click', function(){
    $(this).toggleClass('active');
    $('.sidebar').toggleClass('active');
    $('.navbar-wrapper').toggleClass('active');
    $('.body-wrapper').toggleClass('active');
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  $('.nice-select').niceSelect();

  // navbar-search 
  $('.navbar-search__btn-open').on('click', function (){
    $('.navbar-search').addClass('active');
  }); 

  $('.navbar-search__close').on('click', function (){
    $('.navbar-search').removeClass('active');
  }); 

  // responsive sidebar expand js 
  $('.res-sidebar-open-btn').on('click', function (){
    $('.sidebar').addClass('open');
  }); 

  $('.res-sidebar-close-btn').on('click', function (){
    $('.sidebar').removeClass('open');
  }); 

/* Get the documentElement (<html>) to display the page in fullscreen */
let elem = document.documentElement;

/* View in fullscreen */
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

/* Close fullscreen */
function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) { /* Firefox */
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE/Edge */
    document.msExitFullscreen();
  }
}

$('.fullscreen-btn').on('click', function(){
  $(this).toggleClass('active');
});

$('.sidebar-dropdown > a').on('click', function () {
  if ($(this).parent().find('.sidebar-submenu').length) {
    if ($(this).parent().find('.sidebar-submenu').first().is(':visible')) {
      $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
      $(this).removeClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideUp({
        done: function done() {
          $(this).removeClass('sidebar-submenu__open');
        }
      });
    } else {
      $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
      $(this).addClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideDown({
        done: function done() {
          $(this).addClass('sidebar-submenu__open');
        }
      });
    }
  }
});

// select-2 init
$('.select2-basic').select2();
$('.select2-multi-select').select2();
$(".select2-auto-tokenize").select2({
  tags: true,
  tokenSeparators: [',']
});

// data table init
$(document).ready(function() {

  // $('#default-data-table').DataTable();
  $('table.default-data-table').DataTable();

  $('#scroll-vertical-datatable').DataTable( {
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging":         false
  });


  $('#buttons-datatable').DataTable( {
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  });

});


function proPicURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var preview = $(input).parents('.thumb').find('.profilePicPreview');
            $(preview).css('background-image', 'url(' + e.target.result + ')');
            $(preview).addClass('has-image');
            $(preview).hide();
            $(preview).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(".profilePicUpload").on('change', function () {
    proPicURL(this);
});

$(".remove-image").on('click', function () {
    $(this).parents(".profilePicPreview").css('background-image', 'none');
    $(this).parents(".profilePicPreview").removeClass('has-image');
    $(this).parents(".thumb").find('input[type=file]').val('');
});

$("form").on("change", ".file-upload-field", function(){ 
  $(this).parent(".file-upload-wrapper").attr("data-text",         $(this).val().replace(/.*(\/|\\)/, '') );
});


