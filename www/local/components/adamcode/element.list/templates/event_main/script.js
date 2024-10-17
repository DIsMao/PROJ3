$(document).on('click',".widget__calendar__events .tab li", function () {
    $('.widget__events, .widget__calendar__events .tab li').removeClass('active');
    let index = $(this).index();
    $('.widget__events:eq(' + index + '), .widget__calendar__events .tab li:eq(' + index + ')').addClass('active');
});