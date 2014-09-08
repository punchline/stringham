
(function ($) {

    "use strict";

    jQuery(document).ready(function ($) {
    

        // ========================================================================
        //	Togglers
        // ========================================================================

        // toogle sidebar
        $('.left-toggler').click(function (e) {
            $(".responsive-admin-menu").toggleClass("sidebar-toggle");
            $(".content-wrapper").toggleClass("main-content-toggle-left");
            e.preventDefault();
        });

        // We should listen to touch elements of touch devices
        $('.smooth-overflow').on('touchstart', function (event) {});

        // toggle sidebar
        $('.right-toggler').click(function (e) {
            $(".main-wrap").toggleClass("userbar-toggle");
            e.preventDefault();
        });

        // toggle chatbar
        $('.chat-toggler').click(function (e) {
            $(".chat-users-menu").toggleClass("chatbar-toggle");
            e.preventDefault();
        });

        // Toggle Chevron in Bootstrap Collapsible Panels
        $('.btn-close').click(function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().fadeOut();
        });

        $('.btn-minmax').click(function (e) {
            e.preventDefault();
            var $target = $(this).parent().parent().next('.panel-body');
            if ($target.is(':visible')) $('i', $(this)).removeClass('fa fa-chevron-circle-up').addClass('fa fa-chevron-circle-down');
            else $('i', $(this)).removeClass('fa-chevron-circle-down').addClass('fa fa-chevron-circle-up');
            $target.slideToggle();
        });
        $('.btn-question').click(function (e) {
            e.preventDefault();
            $('#myModal').modal('show');
        });

        if ($('#megamenuCarousel').length) {
            $('#megamenuCarousel').carousel();
        }

        // ========================================================================
        //	Bootstrap Tooltips and Popovers
        // ========================================================================

        if ($('.tooltiped').length) {
            $('.tooltiped').tooltip();
        }

        if ($('.tooltiped').length) {
            $('.popovered').popover({
                'html': 'true'
            });
        }


        // Making Bootstrap Popover Hovered


        if ($('.popover-hovered').length) {
            $('.popover-hovered').popover({
                trigger: 'hover',
                'html': 'true',
                'placement': 'top'
            });
        }

        // ========================================================================
        //	Full screen Toggle
        // ========================================================================

        $('#toggle-fullscreen').click(function () {
            screenfull.request();
        });


        // ========================================================================
        //	Keep open Bootstrap Dropdown on click
        // ========================================================================

        $('.keep_open').click(function (event) {
            event.stopPropagation();
        });


        // ========================================================================
        //	Left Responsive Menu
        // ========================================================================	  

        $(document).ready(function () {

            // Responsive Menu//
            $(".responsive-menu").click(function () {
                $(".responsive-admin-menu #menu").slideToggle();
            });
            $(window).resize(function () {
                $(".responsive-admin-menu #menu").removeAttr("style");
            });

            (function multiLevelAccordion($root) {

                var $accordions = $('.accordion', $root).add($root);
                $accordions.each(function () {

                    var $this = $(this);
                    var $active = $('> li > a.submenu.active', $this);
                    $active.next('ul').css('display', 'block');
                    $active.addClass('downarrow');
                    var a = $active.attr('data-id') || '';

                    var $links = $this.children('li').children('a.submenu');
                    $links.click(function (e) {
                        if (a !== "") {
                            $("#" + a).prev("a").removeClass("downarrow");
                            $("#" + a).slideUp("fast");
                        }
                        if (a == $(this).attr("data-id")) {
                            $("#" + $(this).attr("data-id")).slideUp("fast");
                            $(this).removeClass("downarrow");
                            a = "";
                        } else {
                            $("#" + $(this).attr("data-id")).slideDown("fast");
                            a = $(this).attr("data-id");
                            $(this).addClass("downarrow");
                        }
                        e.preventDefault();
                    });
                });
            })($('#menu'));




            // Responsive Menu Adding Opened Class//

            $(".responsive-admin-menu #menu li").hover(
                function () {
                    $(this).addClass("opened").siblings("li").removeClass("opened");
                },
                function () {
                    $(this).removeClass("opened");
                }
            );


            // ========================================================================
            //	Sign Out Modal
            // ========================================================================            

            $(".goaway").click(function (e) {
                e.preventDefault();
                $('#signout').modal();
                $('#yesigo').click(function () {
                    window.open('admin-login.html', '_self');
                    $('#signout').modal('hide');
                });

            });
        });


        // ========================================================================
        //	Lock Modal
        // ======================================================================== 

        $(".lockme").click(function (e) {
            e.preventDefault();
            $('#lockscreen').modal();
            $('#yesilock').click(function () {
                window.open('admin-lock.html', '_self');
                $('#lockscreen').modal('hide');
            });

        });


    });

    // ========================================================================
    //	MegaMenu Elements
    // ========================================================================

    // The following code is used to initialize widgets inside dropdown menu
    // after they becomes visible
    // Please note that Google Maps Inits JS in you can found in Google Maps Section of this file


    $('.dropdown').on('show.bs.dropdown', function () {
        var $this = $(this);
        setTimeout(function () {

            // carousels
            var $carousel = $('.carousel', $this).carousel();
            $('[data-slide], [data-slide-to]', $carousel).click(function (e) {
                e.preventDefault();
                $(this).trigger('click.bs.carousel.data-api');
            });

            // tabs
            var $tabs = $('#tabs', $this).tab();
            $('[data-toggle="tab"], [data-toggle="pill"]', $tabs).click(function (e) {
                e.preventDefault();
                $(this).trigger('click.bs.tab.data-api');
            });
        }, 10);
    });
	if(window.location.hash) {
	  // Fragment exists
	   var id = window.location.hash.replace('#','');
	   var link = document.getElementById(id+'-tab-link');
	   link.click();
	   console.log(id);
	}
	
	if ($('.nestable').length) {
        $('.nestable').nestable({
            group: 1
        });
    }
	
    // ========================================================================
    //	Scroll To Top
    // ========================================================================

    $('.smooth-overflow').on('scroll', function () {

        if ($(this).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
        } else {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    $('.scroll-top-wrapper').on('click', scrollToTop);

    function scrollToTop() {
            var verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
            var element = $('body');
            var offset = element.offset();
            var offsetTop = offset.top;
            $('.smooth-overflow').animate({
                scrollTop: offsetTop
            }, 400, 'linear');
        }
        //----------------------------------------------------------------------
        
        
        
    // ========================================================================
    // Lie Detector
    // ========================================================================
    
    
    
    
        
        
    // =========================================================================
    // FlotChart Stuff
    // =========================================================================
        
        //Example #2 - Stacked Graph

        if ($("#placeholder2").length) {

            var dates2 = [
                ["Jan", 56],
                ["Feb", 67],
                ["Mar", 42],
                ["Apr", 87],
                ["May", 53],
                ["June", 38],
                ["July", 49],
                ["Aug", 32],
                ["Sep", 33],
                ["Oct", 34],
                ["Nov", 41],
                ["Dec", 14]
            ];

            var dates1 = [
                ["Jan", 189],
                ["Feb", 244],
                ["Mar", 293],
                ["Apr", 192],
                ["May", 265],
                ["June", 167],
                ["July", 231],
                ["Aug", 169],
                ["Sep", 163],
                ["Oct", 168],
                ["Nov", 152],
                ["Dec", 52]
            ];


            jQuery.plot("#placeholder2", [{
                data: dates1,
                label: "Earnings"
            }, {
                data: dates2,
                label: "Buys"
            }], {
                colors: ["#5bc0de", "#f87aa0"],
                grid: {
                    hoverable: true,
                    clickable: false,
                    borderWidth: 0,
                    backgroundColor: "transparent"
                },
                legend: {

                    labelBoxBorderColor: false,
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.9,
                        fill: 1,
                        lineWidth: 0,
                        align: "center"
                    }
                },
                xaxis: {
                    font: {
                        color: '#555',
                        family: 'Open Sans, sans-serif',
                        size: 11
                    },
                    mode: "categories",
                    tickLength: 0
                },
                yaxis: {
                    font: {
                        color: '#333',
                        family: 'Open Sans, sans-serif',
                        size: 11
                    }
                }
            });

        }
        

})(jQuery);