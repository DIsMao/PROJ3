$(document).ready(function() {

    new AirDatepicker('#datepicker',{
        inline: false
    });

    new AirDatepicker('#datepicker2',{
        inline: false,
        timepicker: true,
    });

    $('button[data-btn="save"]').on('click', function(){
        const $btn = $(this);
        $btn.append(`<img class="w-6 h-6 object-contain filter invert sepia-0 saturate-0 hue-rotate-[94deg] brightness-[1.06] contrast-[20]" src="./local/templates/furnitureAssembly/img/other/loading2.gif" alt="иконка">`);
        $btn.prop('disabled', true);
        setTimeout(function(){
            $btn.find('img').remove();
            $btn.prop('disabled', false);
        }, 1000)
    });

    $("div[rowinput]").on('click', 'div[rowInputNew]', function(){
        const $parent = $(this).closest('div[rowinput]');
        $parent.find('div[rowbody]').append(`
            <div class="grid grid-cols-[35%_15%_10%_15%_12%_5%] items-center gap-4 group/rowInput" rowItem="">
                <div class="w-full h-full">
                    <div class="bg-white border rounded-md h-full pt-2 pr-3 pl-3 pb-3 relative" data-select="select">
                        <div class="flex gap-2 justify-center items-center">
                            <p class="font-montserrat font-semibold text-base w-calc-input" data-value=""> </p><img class="w-5 h-5 object-contain cursor-pointer" src="./local/templates/furnitureAssembly/img/icons/CaretDown.svg" list-btn="" alt="Иконка">
                        </div>
                        <div class="flex flex-col gap-2 absolute bg-white left-0 w-full overflow-hidden h-0 top-full shadow-md z-50" list="">
                            <div class="px-3 cursor-pointer pt-2" data-value="1">
                                <p class="font-montserrat font-semibold text-base">Заказ 1</p>
                            </div>
                            <div class="px-3 cursor-pointer" data-value="2">
                                <p class="font-montserrat font-semibold text-base">Заказ 2</p>
                            </div>
                            <div class="px-3 cursor-pointer pb-2" data-value="3">
                                <p class="font-montserrat font-semibold text-base">Заказ 3</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input class="border-none h-full outline-none w-full" type="text" data-input="count" placeholder="Кол-во">
                </div>
                </div>
                <div class="w-full">
                <p class="font-montserrat font-semibold text-base text-black" rowinputcount="">0 шт.</p>
                </div>
                <div class="w-full">
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input class="border-none h-full outline-none w-full" type="text" data-input="prise" placeholder="Сумма">
                </div>
                </div>
                <div class="w-full">
                <p class="font-montserrat font-semibold text-base text-black" rowinputprise="">0 руб.</p>
                </div>
                <div rowInputRemove class="none group/rowInput-hover:block"><img class="w-6 h-6 object-contain cursor-pointer" src="./local/templates/furnitureAssembly/img/icons/X.svg" alt="Иконка"></div>
            </div>`);

        $parent.find('div[data-select]').on('click', 'img[list-btn]', function(){
            const list = $(this).closest('div[data-select]').find('div[list]')
            if(list.hasClass('h-0')){
                list.removeClass('h-0');
            }else{
                list.addClass('h-0');
            }
        });

        $parent.find('div[data-select]').on('click', 'div[data-value]', function(){
            const $item = $(this);
            const $block = $(this).closest('div[data-select]')
            const $list = $block.find('div[list]');
    
            const value = $item.attr('data-value');
            const text = $item.text();
            
            $list.addClass('h-0');
            $block.find('p[data-value]').attr("data-value", value).text(text);
        });
    });

    $("div[rowinput]").on('click', 'div[rowInputRemove]', function(){
        $(this).closest('div[rowItem]').remove();
    });
});