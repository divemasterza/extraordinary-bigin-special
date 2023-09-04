jQuery(document).ready(function($) {
    // Ensure the slick-slider element exists
    if ($('.slick-slider').length) {
        // Initialize slick only if not in the admin area
        if (!$('body').hasClass('wp-admin')) {
            $('.slick-slider').slick({
                slidesToShow: 10,  // Show as many slides as possible on desktop
                slidesToScroll: 1,     // Scroll one slide at a time
                arrows: true,
                responsive: [
                    {
                        breakpoint: 768,   // Mobile breakpoint
                        settings: {
                            slidesToShow: 1,  // Show one slide at a time on mobile
                            slidesToScroll: 1 // Scroll one slide at a time
                        }
                    }
                ]
            });
        }
    }
});
