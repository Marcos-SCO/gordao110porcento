function owlCarouselFunctions() {

    const owlCarouselExists = (typeof $.fn.owlCarousel === 'function');
    if (!owlCarouselExists) return;

    // owl carousel
    const owl = $('[data-js="owlDefaultItem"]');

    if (owl) {
        
        owl.owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                },
                // breakpoint from 768 up
                768: {
                    items: 4,
                },
                // breakpoint from 1000 up
                1161: {
                    items: 5,
                }
            }
        });
    }

    const blogPostsSection = $('[data-js="blog-posts-section"]');

    if (blogPostsSection) {

        blogPostsSection.owlCarousel({
            loop: true,
            margin: 0,
            padding: 0,
            autoplay: true,
            autoplayTimeout: 3100,
            autoplayHoverPause: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                },
                // breakpoint from 768 up
                768: {
                    items: 4,
                },
                // breakpoint from 1000 up
                1161: {
                    items: 5,
                }
            }
        });
    }

}

owlCarouselFunctions();