/*
 * @package inChurch
 * @version 1.0.0
 * @created May 4, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Javascript for shortcodes
 *
 */

(function($){
    "use strict";
    /**
     * Tabs
     */
    $.fn.iwTabs = function (type) {
        $(this).each(function () {
            var iwTabObj = this, $iwTab = $(this);
            if (type === 'tab') {
                iwTabObj.content_list = $iwTab.find('.iw-tab-content .iw-tab-item-content');
                iwTabObj.list = $iwTab.find('.iw-tab-items .iw-tab-item');
                iwTabObj.item_click_index = 0;
                $('.iw-tab-items .iw-tab-item', this).click(function () {
                    if ($(this).hasClass('active')) {
                        return;
                    }
                    var itemclick = this, item_active = $iwTab.find('.iw-tab-items .iw-tab-item.active');
                    iwTabObj.item_click_index = iwTabObj.list.index(itemclick);
                    $(itemclick).addClass('active');
                    iwTabObj.list.each(function () {
                        if (iwTabObj.list.index(this) !== iwTabObj.list.index(itemclick) && $(this).hasClass('active')) {
                            $(this).removeClass('active');
                        }
                    });
                    iwTabObj.loadTabContent();
                });
                this.loadTabContent = function () {
                    var item_click = $(iwTabObj.content_list.get(iwTabObj.item_click_index));
                    iwTabObj.content_list.each(function () {
                        if (iwTabObj.content_list.index(this) < iwTabObj.content_list.index(item_click)) {
                            $(this).addClass('prev').removeClass('active next');
                        } else if (iwTabObj.content_list.index(this) === iwTabObj.content_list.index(item_click)) {
                            $(this).addClass('active').removeClass('prev next');
//                            $(".map-contain",this).iwMap();
                        } else {
                            $(this).addClass('next').removeClass('prev active');
                        }
                    });
                };
            } else {
                this.accordion_list = $iwTab.find('.iw-accordion-item');
                $('.iw-accordion-header', this).click(function () {
                    var itemClick = $(this);
                    var item_target = itemClick.parent();
                    if (itemClick.hasClass('active')) {
                        itemClick.removeClass('active');
                        item_target.find('.iw-accordion-content').slideUp({easing: 'easeOutQuad'});
                        item_target.find('.iw-accordion-header-icon .expand').hide();
                        item_target.find('.iw-accordion-header-icon .no-expand').show();
                        return;
                    }
                    itemClick.addClass('active');
                    item_target.find('.iw-accordion-content').slideDown({easing: 'easeOutQuad'});
                    item_target.find('.iw-accordion-header-icon .expand').show();
                    item_target.find('.iw-accordion-header-icon .no-expand').hide();
                    iwTabObj.accordion_list.each(function () {
                        if (iwTabObj.accordion_list.index(this) !== iwTabObj.accordion_list.index(item_target) && $(this).find('.iw-accordion-header').hasClass('active')) {
                            $(this).find('.iw-accordion-header').removeClass('active');
                            $(this).find('.iw-accordion-content').slideUp({easing: 'easeOutQuad'});
                            $(this).find('.iw-accordion-header-icon .expand').hide();
                            $(this).find('.iw-accordion-header-icon .no-expand').show();
                        }
                    });
                });

                $('.iw-accordion-header', this).hover(function () {
                    var item = $(this), item_target = item.parent();
                    if (item.hasClass('active')) {
                        return;
                    }
                    item_target.find('.iw-accordion-header-icon .expand').show();
                    item_target.find('.iw-accordion-header-icon .no-expand').hide();
                }, function () {
                    var item = $(this), item_target = item.parent();
                    if (item.hasClass('active')) {
                        return;
                    }
                    item_target.find('.iw-accordion-header-icon .expand').hide();
                    item_target.find('.iw-accordion-header-icon .no-expand').show();
                });
            }

        });
    };

    //tesimonial
    $.fn.iwCarousel = function () {
        $(this).each(function () {
            var iwCarouselObj = this,
                $iwCarouselE = $(this),
                clients = $iwCarouselE.find('.iw-testimonial-client-item');
            $iwCarouselE.find('.testi-owl-maincontent').owlCarousel({
                slideSpeed: 500,
                paginationSpeed: 400,
                singleItem: true,
                direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                navigation: false,
                pagination: true,
                afterMove: function () {
                    var carContent = $iwCarouselE.find('.testi-owl-maincontent').data('owlCarousel');
                    iwCarouselObj.slideItem(carContent.currentItem);
                }
            });

            $iwCarouselE.find('.iw-testimonial-client-item').click(function () {
                var index = $(this).data('item-active'),
                    carContent = $iwCarouselE.find('.testi-owl-maincontent').data('owlCarousel');
                carContent.goTo(index);
                iwCarouselObj.slideItem(carContent.currentItem);

            });

            this.slideItem = function (index) {
                clients.each(function () {
                    if ($(this).data('item-active') == index) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });
            };

        });

    };
})(jQuery);


jQuery(document).ready(function($){
    /**
     * Video
     */
    $('.iw-video .play-button').click(function () {
        if (!$(this).parents('.iw-video').hasClass('playing')) {
            $(this).parents('.iw-video').find('video').get(0).play();
            $(this).parents('.iw-video').addClass('playing');
            return false;
        }
    });
	
    $('.iw-video,.iw-event-facts').click(function () {
        $(this).find('video').get(0).pause();
    });
    $('.iw-video video').on('pause', function (e) {
        $(this).parents('.iw-video').removeClass('playing');
    });

    /** CONTACT FORM **/
    $('.iw-contact form').submit(function (e) {
        $.ajax({
            type: "POST",
            url: inwaveCfg.ajaxUrl,
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                $('.iw-contact .ajax-overlay').show();
            },
            success: function (result) {
                if (result.success) {
                    $('.iw-contact form').get(0).reset();
                } else {
                    $('.iw-contact .form-message').addClass('error');
                }
                $('.iw-contact .ajax-overlay').hide();
                $('.iw-contact .form-message').html(result.message);
            }
        });
        e.preventDefault();
    });
    $('.iw-contact .btn-cancel').click(function () {
        $('.iw-contact form').get(0).reset();
        $('.iw-contact .form-message').removeClass('error');
        $('.iw-contact .form-message').html('');
        return false;
    });

    /** price box hover */
    $('.pricebox.style3').hover(function () {
        if (!$(this).hasClass('no-price')) {
            $('.pricebox.style3').removeClass('featured');
            $(this).addClass('featured');
        }
    });
    $('.pricebox.style2').hover(function () {
        if (!$(this).hasClass('no-price')) {
            $('.pricebox.style2').removeClass('featured');
            $(this).addClass('featured');
        }
    });
    $('.pricebox.style3').css('min-height', $('.pricebox.style3.featured').height());
    $(document).ready(function (){
        $('.iw-price-list .price-item').click(function(){
            $('.iw-price-list .price-item').removeClass('selected');
            $(this).addClass('selected');
            var price = $(this).data('price'),
                url = $('.iw-infunding-donate-us .infunding-paypal a').data('url');
            $('.iw-price-list input[name="amount"]').val(price);
            $('.iw-infunding-donate-us .infunding-paypal a').attr('href',url+'&amount='+price);
        });

        $('.iw-price-list input[name="amount"]').change(function(){
            var val = $(this).val();
            if(val >0){}else{
                val = 100;
            }
            var url = $('.iw-infunding-donate-us .infunding-paypal a').data('url');
            $('.iw-infunding-donate-us .infunding-paypal a').attr('href',url+'&amount='+val);
        }).trigger('change');
    });

//    $(".iw-sponsors-list.style1").owlCarousel({
//        // Most important owl features
//        direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
//        items: 5,
//        itemsCustom: false,
//        itemsDesktop: [1199, 1],
//        itemsDesktopSmall: [980, 1],
//        itemsTablet: [768, 1],
//        itemsTabletSmall: false,
//        itemsMobile: [479, 1],
//        singleItem: false,
//        itemsScaleUp: false,
//        //Autoplay
//        autoPlay: false,
//        stopOnHover: false,
//        // Navigation
//        navigation: true,
//        navigationText: ["", ""],
//        rewindNav: true,
//        scrollPerPage: false,
//        //Pagination
//        pagination: false,
//        paginationNumbers: false
//    });
//	$(".iw-sponsors-list.style2").owlCarousel({
//        // Most important owl features
//        direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
//        items: 5,
//        itemsCustom: false,
//        itemsDesktop: [1199, 4],
//        itemsDesktopSmall: [980, 3],
//        itemsTablet: [768, 2],
//        itemsTabletSmall: false,
//        itemsMobile: [479, 1],
//    //    singleItem: false,
//    //    itemsScaleUp: false,
//        //Autoplay
//    //    autoPlay: false,
//     //   stopOnHover: false,
//        // Navigation
//        navigation: true,
//        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
//     //   rewindNav: true,
//        scrollPerPage: false,
//        //Pagination
//        pagination: false,
//    //    paginationNumbers: false
//    });
	
	$(".iwe-sponsor-slider .iwe-sponsors-list").owlCarousel({
        direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
        items: $(this).data("number"),
        itemsCustom: false,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        scrollPerPage: false,
        pagination: false,
    });


    $(window).on("load resize", function () {
        $(".iw-our-missions").click(function (){
            $('html, body').animate({
                scrollTop: $(".iw-scroll-to-top").offset().top
            }, 500);
        });
    });

    $(window).on("load resize", function () {
        var height_address = $( '.iw-contact-address-right .iw-address' ).height();
        var height_icon = $( '.iw-contact-address-right .iw-address .icon' ).height();
        var margin_top = (height_address - height_icon)/2;
        $(".iw-contact-address-right .iw-address .icon").css("margin-top",+ margin_top);
    });

    $('[data-toggle="tooltip"]').tooltip();

    $(function(){
       // SyntaxHighlighter.all();
    });
    $(window).load(function(){
        $('.iw-carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: true,
            itemWidth: 170,
            itemMargin: 30,
            rtl: true,
            asNavFor: '.iw-slider'
        });

        $('.iw-slider').flexslider({
            animation: "slide",
            controlNav: false,
            directionNav: false,
            animationLoop: false,
            slideshow: true,
            rtl: true,
            sync: ".iw-carousel",
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    });


    $('.wpcf7-select').select2({});

});

var iweCheckoutForm = function(value){
    if(jQuery('.iwe-checkout').hasClass('style4')){
        jQuery('*[name="ticket_buy"]').val(value);
        jQuery('.ticket-plan').removeClass('active');
        jQuery('.ticket-plan-inner[data-value="'+value+'"]').closest('.ticket-plan').addClass('active');
        jQuery('html,body').animate({
                scrollTop: jQuery('.iwe-checkout').offset().top},
            'slow');
    }else{
        jQuery('*[name="ticket_buy"]').val(value).trigger("change");
        jQuery('html,body').animate({
                scrollTop: jQuery('.iwe-checkout').offset().top},
            'slow');
    }
};

function iwaveSetCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function iwaveGetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function iwaveCheckCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}