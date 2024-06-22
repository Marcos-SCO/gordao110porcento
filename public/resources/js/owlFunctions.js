async function owlCarouselFunctions() {
    // console.log(window.$.fn.owlCarousel);

    const owlCarouselExists =
        (typeof $.fn.owlCarousel === 'function');

    if (!owlCarouselExists) {
        console.error('Owl Carousel functions not loaded');
        return;
    }

    // owl carousel
    const owl = $('[data-js="owlDefaultItem"]');
    const owlLoaded = owl.attr('data-loaded');

    if (owl && !owlLoaded) {

        owl.attr('data-loaded', true);

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
    const blogPostsLoaded = blogPostsSection.attr('data-loaded');

    if (blogPostsSection && !blogPostsLoaded) {

        blogPostsSection.attr('data-loaded', true);

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

document.addEventListener('DOMContentLoaded', owlCarouselFunctions);

// document.addEventListener('htmx:afterSwap', owlCarouselFunctions);

export { owlCarouselFunctions };