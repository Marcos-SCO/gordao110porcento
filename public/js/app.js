// on load spinner
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        document.querySelector(
            "body").style.visibility = "hidden";
        document.querySelector(
            "#loader").style.visibility = "visible";
    } else {
        setTimeout(() => {
            document.querySelector(
                "#loader").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }, 100);
    }
};

// flash message
let flash = document.querySelector('#msg-flash');
if (flash != null) {
    setTimeout(() => {
        flash.style =
            'display:none;transition: transform .18s, opacity .18s, visibility 0s .18s;';
    }, 4000);
}

// Carousel Principal
$('#carousel-principal').owlCarousel({
    items: 1,
    lazyLoad: true,
    loop: true,
    margin: 10,
    nav: true,
    navSpeed: 1000,
    navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
    dots: true,
    dotsSpeed: 1000,
    // autoplay: true,
    autoplaySpeed: 1000,
    reponsiveRefreshRatio: 10
});