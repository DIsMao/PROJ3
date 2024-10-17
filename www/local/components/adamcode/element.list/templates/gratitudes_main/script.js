$(document).ready(function() {


    $(".slider_desc_toogler").on("click", function() {
        $(this).children("img").toggleClass('gratitude-btn-icon')
        $(this).children("img").toggleClass('gratitude-btn-icon-up')
        let id = $(this).attr("data-id")

        if ($(this).children("img").hasClass("gratitude-btn-icon")) {
            $("#desc" + id).css("max-height", "51px");
            $(this).children("a").text("Показать больше");
        } else {
            $("#desc" + id).css("max-height", "500px")
            $(this).children("a").text("Свернуть");
        }
    });

    $(".owlGrat").owlCarousel({
        items: 1,
        rewind: true,
        nav: true,
        margin: 35,
        touchDrag: false,
        mouseDrag: false,
        navText: ["<div class='small-arrow-icon'><i class='arrow-left'></i></div>", "<div class='small-arrow-icon'><i class='arrow-right'></i></div>"],
    })


    $('.owlGrat .slider_desc .slider_desc_p').each(function(index, element) {
        let item = $( this );


        if(item.height() <= 51){
            console.log(item.height())
            item.parent().next().css("display", "none")
        }
    })
});