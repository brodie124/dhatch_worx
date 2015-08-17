// Setting some variables
var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
//var isSafari = navigator.userAgent.indexOf("Safari") > -1;
var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
var windowHeight = jQuery(window).height();
var windowWidth = jQuery(window).width();
var navHeight = jQuery('header.navbar').height();
var container = jQuery('#portfolio-list');
var navbar = jQuery('header.navbar');

var home = jQuery('#home');

/* Stellar.js - jQuery plugin that provides parallax scrolling effects to any scrolling element
http://markdalgleish.com/projects/stellar.js/docs/
-------------------------*/
function parallax() {
    // Check for mobile
    if (!isMobile) {
        jQuery(window).stellar({
            horizontalScrolling: false
        });
    }
    /* Disable Parallax on Safari, as its very jittery (Worx v1.0)
    if( isSafari ) {
    	jQuery('.parallax').addClass('safari');
    }
    */
}

jQuery(document).ready(function() {

    jQuery('#loadbox img').fadeTo(200, 1);

    // Nav overflow, when navHeight > windowHeight
    jQuery('.navbar-toggle, .navbar-nav li a').click(function() {

        setTimeout(function() {

            if (navHeight > windowHeight) {

                // nav is collapsed
                if (jQuery('.navbar-collapse').hasClass('in')) {
                    jQuery('header.navbar').css('height', 'auto');
                }

                // nav is expanded
                else {
                    jQuery('header.navbar').css('height', '100%');
                }

            }

        }, 1000);

    });

    jQuery('#home, [id^="home-layout-"], #home .container').css('height', windowHeight);
    jQuery('body').css('margin-bottom', jQuery('#footer').height());
    //jQuery('.animation-init').css('opacity', '0');


    /* Loadbox: Retina Image for Mobile
    -------------------------*/
    if (isMobile) {
        var loadboxImageHeight = jQuery('#loadbox img').height() / 2;
        var loadboxImageWidth = jQuery('#loadbox img').width() / 2;
        jQuery('#loadbox img').css({
            'height': loadboxImageHeight,
            'width': loadboxImageWidth
        });
    }


    /*	Navigation
    -------------------------*/

    // Mobile: Menu Toggle On Click
    jQuery('.navbar-nav > li').not('.menu-item-has-children').click(function() {
        jQuery('.collapse').toggleClass('in');
    });

    jQuery(document).click(function() {
        jQuery('.navbar-nav').removeClass('show');
    });

    // Mobile: Show Sub Menu on Click
    jQuery('.menu-item-has-children > a').click(function() {
        jQuery('.navbar-nav').addClass('move show');
        setNavbarHeight();
    });

    setNavbarHeight();


    // Add a "Back" link to the top of the sub menu
    jQuery('.sub-menu').prepend('<li class="sub-menu-back"><a href="">&nbsp;</a></li>');

    jQuery('.sub-menu-back a').click(function(e) {
        e.preventDefault();
        jQuery('.navbar-nav').removeClass('move');
        setNavbarHeight();
    });

    jQuery('.home-btn-bottom button').on('click', function(e) {
        jQuery('html,body').animate({
            scrollTop: 0
        }, 800);
    });




    jQuery(window).resize(function() {
        setNavbarHeight();

        setButtonPosition();
    });

    jQuery(document).on('DOMNodeInserted', function(e) {
        //console.log(e);
        if(e.target.id == 'wrapper_mbYTP_video') {
            console.log("Wrapper added!");
            setButtonPosition();
        }
    });


    function setButtonPosition() {
        var videoWrapper = jQuery("#home .mbYTP_wrapper");
        var videoButton = jQuery('#home .home-btn-bottom');

        var videoWrapperBottom = videoWrapper.position().top + videoWrapper.height();
        var videoButtonTop = videoButton.position().top;
        var homeBottom = home.position().top + home.height();

        if(videoWrapperBottom - videoButtonTop < 0)
            videoButton.css('top', videoWrapperBottom);

        if(videoButtonTop + videoButton.height() > homeBottom)
            videoButton.css('top', homeBottom - (videoButton.height() * 2));
    }

    function setNavbarHeight() {
        console.log(jQuery(window).width());
        if(jQuery(window).width() < 1024) {
            console.log("collapsed");
            navbar.css('height', navbar[0].scrollHeight + 'px');
        } else {
            navbar.css('height', 80 + 'px');
        }

    }

    var windowOffsetHeight = windowHeight - 1;

    if (!jQuery('header.navbar').hasClass('show')) {
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > windowOffsetHeight) {
                jQuery('header.navbar').addClass('show');
            } else {
                jQuery('header.navbar').removeClass('show');
            }
        });
    };

    // Transparent Menu
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > windowOffsetHeight) {
            jQuery('header.transparent').addClass('white').find('.navbar-brand img').fadeIn(400);
        } else {
            jQuery('header.transparent').removeClass('white').find('.navbar-brand img').fadeOut(400);
        }
    });

    // Sub Menu: Add Arrow
    if (!isMobile) {
        jQuery('.sub-menu').prepend('<div class="arrow-up"></div>');
    }

    /* Scroll To The Top - Button
    -------------------------*/
    jQuery('#up').click(function(e) {
        e.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, 1500);
    });


    /* Slideshow: Clients
    -------------------------*/
    clientsContainer = jQuery('.slideshow-clients').closest('.container').width();

    // Number of clients to show at once (according to device width)
    if (windowWidth < 768) {
        var slidesAtOnce = 2; // Mobile devices
    } else if (windowWidth >= 768) {
        var slidesAtOnce = 3; // Tablet and desktos with a screen smaller than 1200px
    }
    slideWidthCustom = Math.round(clientsContainer / slidesAtOnce);
    var clientSlider = jQuery('.slideshow-clients').bxSlider({
        infiniteLoop: false,
        hideControlOnEnd: true,
        minSlides: slidesAtOnce,
        maxSlides: slidesAtOnce,
        slideWidth: slideWidthCustom,
        slideMargin: 10,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        pager: false,
        controls: true,
        oneToOneTouch: false
    });

    // Initialize Portfolio Filter (on click)
    jQuery('#portfolio-filter a').click(function(e) {
        e.preventDefault();
        var selector = jQuery(this).attr('data-filter');
        container.isotope({
            filter: selector
        });

        setTimeout(function() {
            jQuery(window).stellar('refresh');
            jQuery.waypoints('refresh');
        }, 1000);

        // Active Filter Class
        jQuery('#portfolio-filter').find('.active').removeClass('active');
        jQuery(this).parent().addClass('active');
        return false;

    });

    // Portfolio Filter Item Counter
    jQuery('#portfolio-filter a').each(function() {
        var projecttype = jQuery(this).attr('data-filter');
        if (projecttype == "*" || "") {
            jQuery(this).append('<span class="type-counter">' + jQuery("#portfolio-list > li").length + '</span>'); // Count All Projects
        } else {
            jQuery(this).append('<span class="type-counter">' + jQuery("#portfolio-list > li" + projecttype).length + '</span>'); // Count The Specific Project Type
        }
    });

    /* Portfolio
    -------------------------*/
    var portfolio = jQuery('#portfolio-list');
    var portfolioItem = portfolio.find('li');
    var projectLength = portfolioItem.length;
    var prevButton = jQuery('#project-container .prev');
    var nextButton = jQuery('#project-container .next');

    function projectFunctions() {

        // Timeout necessary for Safari 6
        setTimeout(function() {
            jQuery('#project-container [class^="slideshow"]').bxSlider({
                mode: 'fade',
                adaptiveHeight: true,
                controls: true,
                pager: false,
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>'
            });
        }, 100);

        /* FitVids v1.0 - Fluid Width Video Embeds
        https://github.com/davatron5000/FitVids.js/
        -------------------------*/
        jQuery('.video-full-width').fitVids();
        jQuery('.fluid-width-video-wrapper').css('padding-top', '56.25%'); // Always display videos 16:9 (100/16*9=56.25)

        jQuery('#project-container .project-loadbox').fadeOut(400);

    };

    // Opening a Project
    portfolioItem.find('a').click(function(e) {
        //e.preventDefault();

        // Disable browser scrollbar
        jQuery('body').addClass('overflow-hidden');

        var projectLink = jQuery(this).attr('href');
        var projectOpen = portfolio.find(this).attr('href', projectLink).closest('li');

        // Add class "open" to opened project
        projectOpen.addClass('open');

        // Disable prev link, when first project is open
        if (projectOpen.index() == 0) {
            prevButton.addClass('disabled');
        } else {
            prevButton.attr('href', projectOpen.prev('li').find('.project-link').attr('href'));
        }

        // Disable next link, when last project is open
        if (projectOpen.index() + 1 == projectLength) {
            nextButton.addClass('disabled');
        } else {
            nextButton.attr('href', projectOpen.next('li').find('.project-link').attr('href'));
        }

        // Show project popup and load project content
        jQuery('#project-container').addClass('show');

        jQuery('.project-content').load(window.location.pathname + ' ' + projectLink, function() {
            projectFunctions();
        });

    });

    // Button: Previous Project
    function previousProject() {

        var currentProject = portfolio.find('.open');
        var currentIndex = currentProject.index() + 1;

        // Keyboard nav: Stop, when trying to go before first project
        if (currentIndex == 1) {
            return false;
        }

        // Enable next button when going to the previous project
        jQuery('.next').removeClass('disabled');

        // Disable prev button when reaching first project
        var prevProjectLink = currentProject.prev('li').find('a').attr('href');
        currentProject.removeClass('open').prev('li').addClass('open');

        // Reached first project
        if (currentIndex <= 2) {
            jQuery('.prev').addClass('disabled');
        }

        jQuery('#project-container .project-loadbox').fadeIn(200);

        jQuery('.project-content').load(window.location.pathname + ' ' + prevProjectLink, function() {
            projectFunctions();
        });

    }

    jQuery('.prev').click(function() {
        previousProject();
    });

    // Button: Next Project
    function nextProject() {

        var currentProject = portfolio.find('.open');
        var currentIndex = currentProject.index() + 1;

        // Keyboard nav: Stop, when trying to go beyond last project
        if (currentIndex == projectLength) {
            return false;
        }

        // Enable prev button when going to the next project
        jQuery('.prev').removeClass('disabled');

        // Disable next button when reaching the last project
        var nextProjectLink = currentProject.next('li').find('a').attr('href');
        currentProject.removeClass('open').next('li').addClass('open');

        // Reached last project
        if (currentIndex + 1 >= projectLength) {
            jQuery('.next').addClass('disabled');
        }

        jQuery('#project-container .project-loadbox').fadeIn(200);

        jQuery('.project-content').load(window.location.pathname + ' ' + nextProjectLink, function() {
            projectFunctions();
        });

    }

    jQuery('.next').click(function() {
        nextProject();
    });

    // Enable Arrow Key Project Navigation only on Project Fullscreen Expander
    if (!jQuery('body').hasClass('single-portfolio')) {

        jQuery(document).keyup(function(e) {
            if (e.keyCode == 37) {
                previousProject();
            }
        });

        jQuery(document).keyup(function(e) {
            if (e.keyCode == 39) {
                nextProject();
            }
        });

    }


    // Close button
    jQuery('.close').click(function() {
        // Enable browser scrollbar
        jQuery('body').removeClass('overflow-hidden');
        jQuery('#project-container').removeClass('show');
        portfolio.find('.open').removeClass('open');
        jQuery('.next, .prev').removeClass('disabled');
        jQuery('.project-content').html('');
    });

    // Close using "ESC" key
    jQuery(document).keyup(function(e) {
        if (e.keyCode == 27) {
            // Enable browser scrollbar
            jQuery('body').removeClass('overflow-hidden');
            jQuery('#project-container').removeClass('show');
            portfolio.find('.open').removeClass('open');
            jQuery('.next, .prev').removeClass('disabled');
            jQuery('.project-content').html('');
        }
    });

    /* Full-Width
    -------------------------*/
    var fullWidthSpace = (windowWidth - jQuery('.full-width').width()) / 2;
    jQuery('.full-width').css({
        'width': windowWidth + 'px',
        'margin-left': -fullWidthSpace + 'px'
    });

    /* Fluid Width Video Embeds: FitVids v1.0
    https://github.com/davatron5000/FitVids.js/
    -------------------------*/
    jQuery('.video-full-width').fitVids();
    jQuery('.fluid-width-video-wrapper').css('padding-top', '56.25%'); // Always display videos 16:9 (100/16*9=56.25)


    /* Bootstrap Plugins
    -------------------------*/

    // Navigation - Collapse (for mobile)
    jQuery('.navbar .collapse').collapse();

    // Tooltip
    jQuery('[data-toggle="tooltip"]').tooltip();





}); // END jQuery(document).ready()


jQuery(window).load(function() {

    // Hide Site Load Overlay
    jQuery('#loadbox .inner').fadeOut(400);
    jQuery('#loadbox').delay(800).fadeOut(400);
    setTimeout(function() {
        jQuery('#loadbox').remove();
    }, 1200);

    /* Activate animate.css effects once page is loaded
	http://css-tricks.com/transitions-only-after-page-load/
  -------------------------*/
    function removeLoadbox() {
        setTimeout(function() {
            jQuery("body").removeClass("loading");
        }, 1200);
    }

    // removeLoadbox(); // Deactivated as Web Animations 1.0 introduced in Chrome 33 cause the .loading  delay not to function properly http://www.sitepoint.com/whats-new-chrome-33/


    function overlayHeight() {
        jQuery('.parallax').each(function() {
            var parallaxHeight = jQuery(this).height();
            jQuery(this).find('.background-overlay').css('height', parallaxHeight);
        });
    };


    /* Team Members
    -------------------------*/
    jQuery('.team-member').find('img').each(function() {
        var teamMemberImageHeight = jQuery(this).height();
        jQuery('.team-member').find('.overlay').css('height', teamMemberImageHeight);
    });

    /* Team Member Metabox Content Position "Side" */
    var teamMemberCount = jQuery('.team-member').length;
    if (teamMemberCount > 1) {
        jQuery('.team-member.place-side').addClass('member-divider');
        //jQuery('.team-member.place-side').last('member-divider').removeClass('member-divider');
    }

    /* Mobile Specific */
    if (isMobile) {
        jQuery('.team-member').find('.overlay').removeClass('overlay').addClass('overlay-mobile');
        jQuery('.team-member').find('.btn').addClass('btn-sm');
    }


    /* Slideshow: BxSlider
    List with all slideshow options can be found here: http://bxslider.com/options
    -------------------------*/

    // Background Slideshow "Home"
    var sectionSlideshow = jQuery('.slideshow-home').bxSlider({
        mode: 'fade',
        pause: 5000,
        speed: 1000,
        adaptiveHeight: true,
        controls: true,
        pager: false,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        oneToOneTouch: false
    });

    // Slideshow "horizontal"
    jQuery('.slideshow').bxSlider({
        mode: 'horizontal',
        adaptiveHeight: true,
        controls: true,
        pager: false,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        oneToOneTouch: false,
        onSlideAfter: function() {
            overlayHeight();
        }
    });

    // Slideshow "vertical"
    jQuery('.slideshow-vertical').bxSlider({
        mode: 'vertical',
        adaptiveHeight: true,
        controls: true,
        pager: false,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        oneToOneTouch: false,
        onSlideAfter: function() {
            overlayHeight();
        }
    });

    // Slideshow "fade"
    jQuery('.slideshow-fade').bxSlider({
        mode: 'fade',
        adaptiveHeight: true,
        controls: true,
        pager: false,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        oneToOneTouch: false,
        onSlideAfter: function() {
            overlayHeight();
        }
    });

    // Blog: Slideshow with Controls "fade"
    jQuery('.slideshow-controls').bxSlider({
        mode: 'fade',
        adaptiveHeight: true,
        controls: true,
        pager: false,
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        oneToOneTouch: false,
        onSlideAfter: function() {
            overlayHeight();
        }
    });

    overlayHeight();

    jQuery(window).smartresize(function() {
        overlayHeight();
    });

    // Check if this page has a timeline
    if (jQuery('#timelinr').length) {

        /* Timeline
        http://www.csslab.cl/2011/08/18/jquery-timelinr/#english
        -------------------------*/
        jQuery(function() {
            jQuery().timelinr({
                containerDiv: '#timelinr',
                datesDiv: '#dates',
                issuesDiv: '#events',
                issuesSpeed: 300,
                datesSpeed: 300,
                startAt: 2, // Date that you want to select initially (default: 2, which stands for the second date)
                issuesTransparency: 0
            })
            var eventHeight = jQuery('#events li').eq(settings.startAt - 1).height();
            jQuery('#events').css('height', eventHeight);
        });

        jQuery('#dates a').click(function() {
            var dateId = jQuery(this).attr('href');
            var eventHeight = jQuery('#events li' + dateId).height();
            jQuery('#events').animate({
                height: eventHeight
            }, 800, function() {
                // Refresh Parallax plugin to account for new window height
                if (!isMobile) {
                    jQuery(window).stellar('refresh');
                }
            });
        });

    }

    // Smooth scroll for menu links
    jQuery('header.navbar a[href^="#"], #home a[href^="#"], .modal a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        if(typeof jQuery(this.hash).offset() != 'undefined') {
            jQuery('html,body').animate({
                scrollTop: jQuery(this.hash).offset().top
            }, 800);
        }
    });

    /*	Bootstrap Specific
    -------------------------*/

    // Accordion & Toggle
    jQuery('.accordion').each(function() {
        var accordionId = jQuery(this).attr('id');
        jQuery(this).find('.accordion-toggle').attr('data-parent', "#" + accordionId);
    });

    jQuery('.accordion-toggle').click(function() {
        jQuery(this).closest('.accordion').find('i').removeClass('fa-minus-square').addClass('fa-plus-square');
        jQuery(this).find('i').toggleClass('fa-plus-square fa-minus-square');
    });

    /* Portfolio: Isotope Layout Plugin
    -------------------------*/

    // Portfolio: Number of columns
    // 3 columns grid for mobile
    // 4 columns grid for tablet & desktop
    function portfolioColumnNumber() {
        if (windowWidth >= 768) {
            var portfolioColumns = 3;
        } else {
            var portfolioColumns = 2;
        }
        return portfolioColumns;
    }

    // Initialize Isotope & Masonry Layout
    container.imagesLoaded(function() {
        container.isotope({
            itemSelector: 'li',
            resizable: false, // disable normal resizing
            masonry: {
                columnWidth: container.width() / portfolioColumnNumber
            }
        });
        parallax();
    });

    /* Blog: Masonry
    -------------------------*/

    // Cache portfolio container
    var blogMasonryContainer = jQuery('#blog-masonry');

    // Blog: Number of columns
    function blogMasonryColumnNumber() {
        if (windowWidth >= 768) {
            var blogMasonryColumnNumber = 3;
        } else {
            var blogMasonryColumnNumber = 2;
        }
        return blogMasonryColumnNumber;
    }

    // Initialize Isotope & Masonry Layout
    blogMasonryContainer.imagesLoaded(function() {
        blogMasonryContainer.isotope({
            itemSelector: 'article',
            resizable: false, // disable normal resizing
            masonry: {
                columnWidth: blogMasonryContainer.width() / blogMasonryColumnNumber
            }
        });
    });

    /* Blog: Masonry Full Width
    -------------------------*/

    // Cache portfolio container
    var blogMasonryFullContainer = jQuery('#blog-masonry-fullwidth');

    // Blog: Number of columns
    function blogMasonryFullColumnNumber() {
        if (windowWidth >= 1200) {
            var blogMasonryFullColumnNumber = 4;
        } else if (windowWidth < 1200) {
            var blogMasonryFullColumnNumber = 3;
        } else if (windowWidth < 992) {
            var blogMasonryFullColumnNumber = 2;
        }
        return blogMasonryFullColumnNumber;
    }

    // Initialize Isotope & MasonryFull Layout
    blogMasonryFullContainer.imagesLoaded(function() {
        blogMasonryFullContainer.isotope({
            itemSelector: 'article',
            resizable: false, // disable normal resizing
            masonry: {
                columnWidth: blogMasonryFullContainer.width() / blogMasonryFullColumnNumber
            }
        });
    });

    /* Update all isotope layouts when resizing the browser window
  -------------------------*/
    jQuery(window).smartresize(function() {
        container.isotope({
            masonry: {
                columnWidth: container.width() / portfolioColumnNumber
            }
        });
        blogMasonryContainer.isotope({
            masonry: {
                columnWidth: blogMasonryContainer.width() / blogMasonryColumnNumber
            }
        });
        blogMasonryFullContainer.isotope({
            masonryFull: {
                columnWidth: blogMasonryFullContainer.width() / blogMasonryFullColumnNumber
            }
        });
    });

    jQuery(window).smartresize();

});
