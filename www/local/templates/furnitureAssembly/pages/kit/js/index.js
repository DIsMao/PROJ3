$(document).ready(function() {


    new AirDatepicker('#datepicker',{
        inline: false
    });

    $('div[data-search="search1"]').on('click', 'button[data-btn]', function(){
        var $btn = $(this);
        var btnName = $(this).attr('data-btn');
        var $parent = $(this).closest('div[data-search="search1"]');
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
    })
    
    $('div[data-search="search2"]').on('click', 'button[data-btn]', function(){
        var $btn = $(this);
        var btnName = $(this).attr('data-btn');
        var $parent = $(this).closest('div[data-search="search2"]');
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
    })

    $('div[data-tabs="tab1"]').on('click', 'div[data-tab_item]', function(){
        var $parent = $(this).closest('div[data-tabs="tab1"]');
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
});
