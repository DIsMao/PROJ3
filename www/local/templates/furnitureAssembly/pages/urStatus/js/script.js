$(document).ready(function (){
    var formData = new FormData();

    $("[data-file='FILE']").on( "change", function() {
        $(".docs").removeClass("hidden")
        $(".docs").html("")
        let code = "";
        $.each($("[data-file='FILE']")[0].files,function(key, input){

            code = code + `
<div class="flex gap-2 w">
<div class="w-full flex gap-5">
<div class="w-12 h-12"><img class="w-full h-full object-contain" src="/local/templates/furnitureAssembly/img/icons/DocIcons.svg" alt="Иконка"></div>
<div class="w-full flex flex-col gap-1">
<p class="font-montserrat font-semibold text-base text-primary">${input.name}</p>
<div class="flex gap-2 justify-between">
<div class="flex gap-2">
</div>  
</div>
</div>
</div>    
</div>       
`
            $(".docs").html(code)
            console.log(input)
        });
    })
let $arr = [];
    let listArr = []
    $('[data-btn="send"]').click(function (){

        listArr = []
        inputs = $(".appForm").find("[data-input]")
            inputs.map(function(){
                // console.log($(this).attr("href"))
                if($(this).data("input")){
                    var item = $(this).data("input");
                    var val = $(this).val();
                    formData.append(item, val)
                }

            });

        formData.append('UF_STATUS', $(".UF_STATUS").data("value"))



        $.each($("[data-file='FILE']")[0].files,function(key, input){
            formData.append('file[]', input);
        });
        console.log(formData);
        $.ajax("/local/components/adamcode/ajax.urStatus/ajax.php", {
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data == "true"){
                     window.location.replace("/urStatus?success=true")
                }else{
                    $(".error").css("display", "block")
                    $(".error").text("")
                    $(".error").append( data )
                }
            },
            error: function () {
                console.log('Upload error');
            }
        });

        console.log($arr)
    })

})
// if($(this).data("list")){
//
//     var val = $(this).val();
//     var item = $(this).data("list");
//     $arr[item] = val;
//
// }