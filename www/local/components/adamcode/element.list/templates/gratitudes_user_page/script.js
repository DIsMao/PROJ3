$(document).ready(function() {
    $("#employee-carousel-grat").owlCarousel({
        items: 1,
        rewind: true,
        singleItem: true,
        nav: true,
        dots: false,
        touchDrag: false,
        mouseDrag: false,
        navText: ["<div class='small-arrow-icon'><i class='arrow-left'></i></div>", "<div class='small-arrow-icon'><i class='arrow-right'></i></div>"],
    });
});