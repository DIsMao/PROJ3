$(document).ready(function (){
    var formData = new FormData();
    function myFunc(input) {

        var files = input.files || input.currentTarget.files;

        var reader = [];
        var images = document.getElementById('images');
        var name;
        for (var i in files) {
            if (files.hasOwnProperty(i)) {
                name = 'file' + i;

                reader[i] = new FileReader();
                reader[i].readAsDataURL(input.files[i]);

                images.innerHTML += '<img id="'+ name +'" src="" />';

                (function (name) {
                    reader[i].onload = function (e) {
                        console.log(document.getElementById(name));
                        // formData.append('file[]', e.target.result);
                        document.getElementById(name).src = e.target.result;
                    };
                })(name);


                console.log(files[i]);
            }
        }
    }
    $(".photo").on( "change", function() {
        $("#images").css("display", "flex")
        $("#images").html("")
        myFunc(document.querySelector(".photo"))
    })
let $arr = [];
    let listArr = []
    $('[data-btn="send"]').click(function (){

        listArr = []
        inputs = $(".appForm").find("input")
            inputs.map(function(){
                // console.log($(this).attr("href"))
                if($(this).data("check")){
                    if($(this).is(':checked')){
                        var item = $(this).data("check");
                        var val = $(this).val();
                        formData.append(item, val)
                    }
                } else if($(this).data("input")){
                    var item = $(this).data("input");
                    var val = $(this).val();
                    formData.append(item, val)
                }

            });


        inputs = $(".appForm").find('[data-list]')
        $listArr = []
        inputs.map(function(){
            // console.log($(this).attr("href"))
            if($(this).is(':checked')){
                formData.append('TOOLS[]', $(this).val())
            }
        });

        formData.append('SPEC', $(".SPEC").data("value"))



        $.each($("[data-gal='GALLERY']")[0].files,function(key, input){
            formData.append('file[]', input);
        });

        $.ajax("/local/components/adamcode/ajax.anketa/ajax.php", {
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data == "true"){
                    window.location.replace("/anketa/successPage.php")
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