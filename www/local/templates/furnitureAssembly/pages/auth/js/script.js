$(document).ready(function (){
    $(".changeLogin").on("change", function () {
        $(".regLogin").val($(this).val())
    });

    $(".mailReg").on("click", function () {
        $(".changeLogin").val("")
        $(".mailInput").removeClass("hidden")
        $(".phoneInput").addClass("hidden")
        $(".regLogin").val($(this).val(""))
    });
    $(".phoneReg").on("click", function () {
        $(".changeLogin").val("")
        $(".phoneInput").removeClass("hidden")
        $(".mailInput").addClass("hidden")
        $(".regLogin").val($(this).val(""))
    });

})