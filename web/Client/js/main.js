/**
*
* ---------------------------------------------------------------------------
*
* Template: Educare - Education Responsive Html 5 Template
* Author: Coderhut
* Author URI:  http://hiknik.com/
* Version: 1.0
*
* --------------------------------------------------------------------------- 
*
*/

(function ($) {

    'use strict';
        
/*  ======================================
    Search area
    ====================================== */
    $('#search-show').on('click', function () {
        $('.search-area').addClass('search-area-visible');
    });
    $('.cros-btn').on('click', function () {
        $('.search-area').removeClass('search-area-visible');
    });
        
/*  ======================================
    Banner Slide
    ====================================== */
    var mainBannerArea = $('.main-banner-area');

    mainBannerArea.owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        navText: ['', ''],
        autoplay: true,
        autoplayTimeout: 5000 // auto play time
    });

    var itemBg = $('.itembg');

    $('.main-banner-area .single-banner').each(function () {
        var itmeImg = $(this).find('.itembg img').attr('src');
        $(this).css({
            background: 'url(' + itmeImg + ')'
        });
    });

    function slideThumb() {

        $('.main-banner-area .owl-item').removeClass('next prev');

        var currenSlide = $('.main-banner-area .owl-item.active');
        currenSlide.next('.owl-item').addClass('next');
        currenSlide.prev('.owl-item').addClass('prev');

        var nextSlideImg = $('.owl-item.next').find('.itembg img').attr('src');
        var prevSlideImg = $('.owl-item.prev').find('.itembg img').attr('src');

        $('.main-banner-area .owl-nav .owl-prev').css({
            background: 'url(' + prevSlideImg + ')'
        });

        $('.main-banner-area .owl-nav .owl-next').css({
            background: 'url(' + nextSlideImg + ')'
        });

    }

    slideThumb();

    mainBannerArea.on('translated.owl.carousel', function () {
        slideThumb();
    });

    mainBannerArea.on('translate.owl.carousel', function () {
        $('.single-banner h1').removeClass('slideInDown animated').hide();
        $('.single-banner p').removeClass('slideInRight animated').hide();
        $('.single-banner .theme-btn').removeClass('slideInUp animated').hide();
    });

    mainBannerArea.on('translated.owl.carousel', function () {
        $('.owl-item.active .single-banner h1').addClass('slideInDown animated').show();
        $('.owl-item.active .single-banner p').addClass('slideInRight animated').show();
        $('.owl-item.active .single-banner .theme-btn').addClass('slideInUp animated').show();
    });


    // Append carousel dots
    $('.banner-dots').append($('.main-banner-area .owl-dots'));

/*  ======================================
    Sticky Menu
    ====================================== */
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.header-bottom-area').addClass('fixed');
        } else {
            $('.header-bottom-area').removeClass('fixed');
        }
    });

/*  ======================================
    Mobile Menu
    ======================================*/
    var mobileMenu = $('.main-menu-area');
    mobileMenu.slicknav({
        prependTo: '.mobile-menu'
    });

/*  ======================================
    Text banner Slide
    ====================================== */
    $('.text-banner-slide').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000 // auto play time
    });

/*  ======================================
    Testimonial Slide
    ====================================== */
    $('.all-testimonial').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000 // auto play time
    });

/*  ======================================
    Tweets carousel
    ====================================== */
    $('.twitter-caro').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000 // auto play time
    });

/*  ======================================
    About us hovver effect
    ====================================== */
    $('.single-content').directionalHover();

/*  ======================================
    Popup video
    ====================================== */
    $('.video-btn').YouTubePopUp({
        autoplay: 1
    });

/*  ======================================
    Event count
    ====================================== */
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });

/*  ======================================
    Course imgage slide
    ====================================== */
    $('.course-img-slide').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000, // auto play time
        nav: true,
        navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        dots: false
    });

/*  ======================================
    Scroll Up
    ====================================== */

    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        topDistance: '300', // Distance from top before showing element (px)
        topSpeed: 300, // Speed back to top (ms)
        animation: 'slide', // Fade, slide, none
        animationInSpeed: 500, // Animation in speed (ms)
        animationOutSpeed: 500, // Animation out speed (ms)
        scrollText: '<i class="fa fa-arrow-up" aria-hidden="true"></i>', // Text for element
        activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    });

/*  ======================================
    Parallax effect
    ====================================== */

    $('.jarallax').jarallax({
        speed: 0.5
    });

    $(window).on('load', function () {

    /*  ======================================
        Preloader
        ====================================== */
        
        $('.thme-preloader').fadeOut('500');
        
    });
}(jQuery));