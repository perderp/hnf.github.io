
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $('.navbar').css('background-color', '#FFF4E5');
        $('.navbar').css('transition', '450ms');
    } else {
        $('.navbar').css('background-color', 'transparent');
        $('.navbar').css('transition', '450ms');
    }

   

    
});
$( ".navbar-toggler" ).click(function() {
        $('.navbar').css('background-color', '#FFF4E5');
        $('.navbar').css('transition', '450ms');

  });


//Scroll to top
$(document).ready(function(){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 500) {
            $('.scrolltotop ,.scrolltop').fadeIn();
        } else {
            $('.scrolltotop ,.scrolltop').fadeOut();
        }
    });
    $('.scrolltotop').click(function(){   
        $('html, body').animate({scrollTop : 0},800);
        return false;
    }); 
});
$(".owl-carousel").owlCarousel({
    autoWidth: true,
    // center: true,
    dots: false,
    loop: true,
    autoplay:true,
    autoplayTimeout:10000,
    smartSpeed: 2000,
    nav: false,
    autoplayHoverPause: true
});

$(document).ready(function(){
    $('body').scrollspy({target: ".plan-list-nav", offset: 50});   
  
    $("#main-nav div a").on('click', function(event) {
      if (this.hash !== "") {
        event.preventDefault();
  
        var hash = this.hash;
  
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){
     
          window.location.hash = hash;
        });
      }  
    });
    // SIDE BAR
    $('.navbar-toggler').click(function(){
        $('.sidebar').addClass('active');
    });
    $('.close-sidebar').click(function(){
        $('.sidebar').removeClass('active');
    });
    
    // IMAGE FOOTER HOVER EFFECT
    // $('.footer-link').hover(function(){
    //     alert();
    // });
    
});

function closeSidebar(){
    $('.sidebar').removeClass('active');
}


(function($) {
    "use strict"; 
    var form = $('.contact__form'),
        message = $('.contact__msg'),
        form_data;
    // Success function
    function done_func(response) {
        message.fadeIn()
        message.html(response);
        setTimeout(function () {
            message.fadeOut();
        }, 5000);
        form.find('input:not([type="submit"]), textarea').val('');
    }
    // fail function
    function fail_func(data) {
        message.fadeIn()
        message.html(data.responseText);
        setTimeout(function () {
            message.fadeOut(5000);
        }, 5000);
    }
    form.submit(function (e) {
        e.preventDefault();
        form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        })
            .done(done_func)
            .fail(fail_func);
    });
})(jQuery);