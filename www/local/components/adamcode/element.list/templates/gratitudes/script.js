$(document).ready(function() {
$("div.gratitudes-show-more").on("click", function() {
    $(this).children("img").toggleClass('lk-arrow-down')
    $(this).children("img").toggleClass('lk-arrow-up')
    ua = navigator.userAgent;
    if (ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1) {
        if ($(this).children("img").hasClass("lk-arrow-down")) {
            $("." +$(this).attr("data-id")).css("max-height", "48px");
            $(this).children("a").text("Показать больше");
        } else {
            $("." +$(this).attr("data-id")).css("max-height", "500px")
            $(this).children("a").text("Свернуть");
        }
    } else {
        if ($(this).children("img").hasClass("lk-arrow-down")) {
            $("." +$(this).attr("data-id")).css("max-height", "48px");
            $(this).children("a").text("Показать больше");
        } else {
            $("." +$(this).attr("data-id")).css("max-height", "500px")
            $(this).children("a").text("Свернуть");
        }
    }
});

    $('.gratitudes-item-text').each(function(index, element) {
        let item = $( this );


        if(item.height() < 48){
            console.log(item.height())
            item.next().children(".gratitudes-show-more").css("visibility", "hidden")
        }else{
            item.next().children(".gratitudes-show-more").css("visibility", "visible")
        }
    })
})