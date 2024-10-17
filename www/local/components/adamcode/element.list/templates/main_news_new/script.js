
    $(document).on('click',".like", function (e) {
    let likecount = $(`[data-id='${this.lastElementChild.dataset.id}']`)
    if (!this.classList.contains('like_sending')) {
    this.classList.add('like_sending');
console.log("67")
    let Id = this.lastElementChild.dataset.id;
    let status = this.lastElementChild.dataset.status;
        var request = BX.ajax.runComponentAction('adamcode:ajax.news', 'like', {
            mode: 'class',
            data: {
                id: Id,
                status: status,
            }
        });
        // промис в который прийдет ответ
        request.then(function (response) {
            console.log(response);
        });
    this.classList.remove('like_sending');
    likecount .each(function() {
    if (status === 'Поставить лайк') {
    this.textContent = Number(this.textContent) + 1;
    this.setAttribute('data-status', 'Убрать лайк');
    $(this).parent().addClass('active');

} else if (status === 'Убрать лайк') {
    this.textContent = Number(this.textContent) - 1;
    this.setAttribute('data-status', 'Поставить лайк');
    $(this).parent().removeClass('active');


}
});

    e.preventDefault();
}
});
