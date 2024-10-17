$(document).ready(function() {
    $('div[data-search="main"]').on('click', 'button[data-btn]', function(){
        var $btn = $(this);
        var btnName = $(this).attr('data-btn');
        var $parent = $(this).closest('div[data-search="main"]');
        if(btnName === "search_user"){
            $parent.find("input[type='text']").attr("placeholder", "Поиск по сотрудникам");
            const btnCurrent = $parent.find("button[data-btn='search_order']");
            var btnColor = btnCurrent.attr('style');
            btnCurrent.attr('style', '').attr('active', 'false');
            $btn.attr('style', btnColor).attr('active', 'true');
        }else if(btnName === "search_order"){
            $parent.find("input[type='text']").attr("placeholder", "Поиск по заказам");
            const btnCurrent = $parent.find("button[data-btn='search_user']");
            var btnColor = btnCurrent.attr('style');
            btnCurrent.attr('style', '').attr('active', 'false');
            $btn.attr('style', btnColor).attr('active', 'true');
        }
    });

    $('div[data-search]').on('change', 'input[type="text"]', function(){
        const $parent = $(this).closest('div[data-search]');
        const $btn = $parent.find('button[active="true"]');
        const btnName = $btn.attr('data-btn');
        const $list = $parent.find('div[searchList]');

        if($list.hasClass('h-0')){
            $list.removeClass('h-0');
        }else{
            $list.addClass('h-0');
        }

        if(btnName === "search_user"){
            // TODO: логки получения списка сотрудников
        }else if(btnName === "search_order"){
            // TODO: логки получения списка заказов
        }
    });

    $('div[data-select]').on('click','div[listInput]', function(e){
        e.preventDefault();

        const $parent = $(this).closest('div[data-select]');
        const $list = $parent.find('div[list]')
        if($list.hasClass('h-0')){
            $list.removeClass('h-0');
            $parent.find('img[list-btn]').addClass('rotate-180')
        }else{
            $list.addClass('h-0');
            $parent.find('img[list-btn]').removeClass('rotate-180')
        }
    });


    $('div[data-select]').on('click', 'div[data-value]', function(){
        const $item = $(this);
        const $block = $(this).closest('div[data-select]')
        const $list = $block.find('div[list]');

        const value = $item.attr('data-value');
        const text = $item.find('p[selectVal]').text();

        $list.addClass('h-0');
        $block.find('p[data-value]').attr("data-value", value).text(text);
        $block.find('img[list-btn]').removeClass('rotate-180')
    })

    $('div[history]').on('click','img[history-btn]', function(){
        const $item = $(this);
        const $block = $item.closest('div[history]').find('div[historyList]')
        if($block.hasClass('hidden')){
            $block.removeClass('hidden');
        }else{
            $block.addClass('hidden');
        }
    })

    $('div[accordion]').on('click', function(){
        var $parent = $(this);
        var $body = $parent.find('div[accordion__body]');
        var icon = $parent.find('[accordion-icon]');

        if (!$body.hasClass('active')) {
            $body.addClass('active')
            $parent.addClass('bg-primary');
            $parent.find('.font-montserrat').addClass('text-white');
            $body.css('max-height', $body.prop('scrollHeight') + 'px');
            icon.addClass('rotate-180');
            icon.attr('style', 'filter:brightness(0) saturate(100%) invert(100%) sepia(1%) saturate(4%) hue-rotate(285deg) brightness(101%) contrast(101%)');
        } else {
            $body.removeClass('active')
            $parent.removeClass('bg-primary');
            $parent.find('.font-montserrat').removeClass('text-white');
            $body.css('max-height', '0px');
            icon.removeClass('rotate-180');
            icon.attr('style', '');
        }
    })

    $('div[accordion2]').on('click', function(){
        var $parent = $(this);
        var $body = $parent.find('div[accordion2__body]');
        var icon = $parent.find('[accordion2-icon]');

        if (!$body.hasClass('active')) {
            $body.addClass('active')
            $body.css('max-height', $body.prop('scrollHeight') + 'px');
            icon.addClass('rotate-180');
        } else {
            $body.removeClass('active')
            $body.css('max-height', '0px');
            icon.removeClass('rotate-180');
        }
    })

    $('div[data-tabs]').on('click', 'div[data-tab_item]', function(){
        var $parent = $(this).closest('div[data-tabs]');
        var $btn = $(this);
        var btnNumber = $(this).attr('data-tab_item');

        var $btns = $parent.find('div[data-tab_item]');
        var $btnText = $parent.find('.font-montserrat');
        var $btnsName = $parent.find('div[data-tab_block]:not(div[data-tab_block="' + btnNumber + '"])');

        $btns.removeClass("bg-primary");
        $btnText.removeClass("text-white");
        $btnsName.addClass("hidden");

        $btn.addClass("bg-primary");
        $btn.find(".font-montserrat").addClass("text-white");
        $parent.find('div[data-tab_block="' + btnNumber + '"]').removeClass("hidden");
    })

    $('div[data-orderId]').on('click', 'div[orderWorkBtn]', function(){
        var $parent = $(this).closest('div[data-orderId]')
        var $list = $parent.find('div[orderWorkList]');

        if(!$list.hasClass('active')){
            $list.addClass('active');
            // $list.css('max-height', $list.find('> div').prop('scrollHeight') + 'px');
            $list.css('max-height', "100%");
            $(this).find('img').addClass('rotate-180');
        }else{
            $list.removeClass('active');
            $(this).find('img').removeClass('rotate-180');
            $list.css('max-height', '0px');
        }
    })

    $("div[dropdowns]").on("mouseover", function() {
        var $parent = $(this).closest('div[dropdowns]');
        var $list = $parent.find('div[dropdownsList]');

        if(!$list.hasClass('active')){
            $list.addClass('active');
            $list.css('max-height', $list.find('> div').prop('scrollHeight') + 'px');
            $(this).find('img[dropdownsBtn]').addClass('rotate-180');
        }
    })
    $("div[dropdowns]").on("mouseout", function() {
        var $parent = $(this).closest('div[dropdowns]');
        var $list = $parent.find('div[dropdownsList]');
        $list.removeClass('active');
        $(this).find('img[dropdownsBtn]').removeClass('rotate-180');
        $list.css('max-height', '0px');
    })

    $('label[data-dropzone]').each(function() {
        const $dropzone = $(this);
        // Предотвращаем стандартное поведение браузера
        $dropzone.on('dragover', function(event) {
            event.preventDefault();
            $(this).addClass('bg-gray-100'); // Изменяем цвет фона при перетаскивании
        });

        $dropzone.on('dragleave', function() {
            $(this).removeClass('bg-gray-100'); // Возвращаем цвет фона
        });
    })

    $('header').on('mouseover', 'div[dropdowns]', function(){
        var $this = $(this).find('div[dropdownsList]');
        if($this.length > 0){
            var offset = $this.offset();
            var width = $this.width();
            var viewportWidth = $(window).width();
            var scrollLeft = $(window).scrollLeft();
            var viewportRight = viewportWidth - scrollLeft;

            if (offset.left + width > viewportRight) {
                $this.css({ right: '5px', left: 'auto' }); // adjust the right property
            }
        }
    });
});