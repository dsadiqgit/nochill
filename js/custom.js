

// OnLoad
jQuery(document).ready(function($) {
    
    jQuery(".woocommerce-product-details__short-description").insertBefore(".woo-related-products-container ");

    // Search bar toggle
    jQuery(".search-icon").click(function(){
        $(".search-field").toggle();
    });

    $('.wpcf7-select').on('mousedown touchstart', function() {
        $(this).addClass("active");
    });

    // mobile menu toggle
    $(".mobile-menu").click(function(){
        $(this).toggleClass("active");
        $("#menu-main-menu").toggleClass("active");
        $("body").toggleClass("overflow");
    });

    // close menu 
    $("#enquire-popup").click(function(){
        $("#menu-main-menu").removeClass("active");
        $("body").removeClass("overflow");
    });

    jQuery(".product-spec .prive").insertAfter("table");

    $(window).resize(function(){
        if(screen.width >= 700){
            $(".mobile-menu").removeClass("active");
            $("#menu-main-menu").removeClass("active");
            $("body").removeClass("overflow");
        }
    });

    // Homepage hero slider
    $('.homepage-hero-main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        fade: true,
        autoplay: true,
        swipeToSlide: true
    });


    // Feedback slider
    $('.feedback-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        fade: true,
        autoplay: true,
        swipeToSlide: true,
        prevArrow:"<span class='slick-prev' alt='Previous arrow'></span>",
        nextArrow:"<span class='slick-next' alt='Next arrow'></span>",
    });


    // Security product slider
    $('.security-product-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        fade: true,
        autoplay: true,
        swipeToSlide: true,
        prevArrow:"<span class='slick-prev' alt='Previous arrow'></span>",
        nextArrow:"<span class='slick-next' alt='Next arrow'></span>",
    });


      // Search Bar Header placeholder text
      headerSearchBar();

      function headerSearchBar(){
        var headerSearchBarField = document.getElementsByClassName("search-field")[0];

        if(headerSearchBarField){
            if(document.querySelector("[placeholder='Search …']")){
                document.querySelector("[placeholder='Search …']").placeholder = "Search for products";
            }
        }
    }

    //Loader animation in view
        // Check if it's time to start the animation.
    function checkAnimation() {
        $.fn.isInViewport = function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
        
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
        
            return elementBottom > viewportTop && elementTop < viewportBottom;
        };
    }
    // loading when the page comes in the view
    $(window).scroll(function() {
        var $lWrap = $('.l-wrap');
        var $rWrap = $('.r-wrap');
        if (window.pageYOffset >= 1501) {
            $lWrap.addClass('left-wrap');
            $rWrap.addClass('right-wrap');
        }
        if (window.pageYOffset <= 1500) {
            $lWrap.removeClass('left-wrap');
            $rWrap.removeClass('right-wrap');
        }
    });
});

