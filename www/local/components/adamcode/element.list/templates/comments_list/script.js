$(document).ready(function (){
    $('.comment').on('click', function(e) {
        e.preventDefault()
        if($(".comment__form__textarea").val() == ""){
            alert("Введите комментарий")
        }else{
            var request = BX.ajax.runComponentAction('adamcode:ajax.comments', 'comment', {
                mode: 'class',
                data:{parent:parent,text:$(".comment__form__textarea").val(),objID:objId}
            })
            request.then(function(response) {

                window.location.reload()
            });
        }

    })
})
