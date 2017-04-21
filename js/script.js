$(document).ready(function() {
    
    var HeaderHeight = $('header').outerHeight();
    
    
    $('.slidedown').click(function(e){
        
        var LinkHref = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(LinkHref).offset().top - HeaderHeight
        }, 1000);
            if($('header').hasClass('nav-is-visible')){ $('.moves-out').removeClass('moves-out');

            $('header').toggleClass('nav-is-visible');
            $('.cd-main-nav').toggleClass('nav-is-visible');
            $('.cd-main-content').toggleClass('nav-is-visible');
            $('.menutext').toggleClass('menu-color1');
            $('.menutext').toggleClass('menu-color2');
            };
        e.preventDefault();
    });
});