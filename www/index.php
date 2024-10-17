<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости банка");

$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/main.css", true);


?>

    <main class="py-20">
        <div class="container mx-auto grid grid-cols-[78%_20%] gap-7">
            <div></div>
            <div class="flex flex-col gap-16">
                <div class="flex flex-col gap-5 p-6 border rounded-lg shadow-[0_2px_2px_0_rgba(0,0,0,0.01),_0_4px_5px_0_rgba(0,0,0,0.02),_0_8px_10px_0_rgba(0,0,0,0.02),_0_14px_18px_0_rgba(0,0,0,0.02),_0_25px_33px_0_rgba(0,0,0,0.03),_0_61px_80px_0_rgba(0,0,0,0.04)]">
                    <div class="flex gap-4"><a class="w-12  h-12 cursor-pointer"><img class="w-full h-full object-contain rounded-full" src="/local/templates/furnitureAssembly/img/people/Avatar_1.png"></a>
                        <div class="flex flex-col gap-2">
                            <p class="font-montserrat font-semibold text-base leading-4">Здравствуйте,</p><a class="font-montserrat font-semibold cursor-pointer text-base leading-4 text-black hover:text-[#7a5bca]">Иванов Иван</a>
                        </div>
                    </div>
                    <p class="font-montserrat font-semibold text-base text-gray-500">
                        Партнер, руководитель решения Инновации на базе продуктов SAP</p>
                    <div class="flex flex-col gap-3"><a class="font-montserrat font-semibold text-xl hover:text-primary" href="#">Заказы</a>
                        <div class="flex flex-col gap-1">
                            <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Новые</a>
                                <p class="font-montserrat font-semibold text-sm text-primary">1</p>
                            </div>
                            <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">В обработке</a>
                                <p class="font-montserrat font-semibold text-sm text-primary">15</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Package.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="/anketa/">Анкета старт</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Package.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Заказы</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Phone.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Диспетчерская</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Coins.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Зарплаты</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Garage.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Склад</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/ClipboardText.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Справочник</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>