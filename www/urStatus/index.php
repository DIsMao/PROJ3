<?

use Adamcode\Config\Blocks;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/pages/urStatus/css/style.css", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/pages/urStatus/js/script.js");
$APPLICATION->SetTitle("Юр статус");
CModule::IncludeModule("iblock");

global $USER;
$arFilter = array("ID" => $USER->GetID());
$arParams["SELECT"] = array("UF_STATUS", "UF_UR_STATUS_DESC", "UF_UR_STATUS_FILES");
$arRes = CUser::GetList([],[],$arFilter,$arParams);
if ($res = $arRes->Fetch()) {
    $statusId = $res["UF_STATUS"];
    $desc = $res["UF_UR_STATUS_DESC"];
    $filesIds = $res["UF_UR_STATUS_FILES"];

}
foreach ($filesIds as $item){
    $files[] = CFile::GetFileArray($item);
}

global $USER_FIELD_MANAGER;
$arFields = $USER_FIELD_MANAGER->GetUserFields("USER");
$obEnum = new CUserFieldEnum;
$rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => $arFields["UF_STATUS"]["ID"]));
while($arEnum = $rsEnum->GetNext()){

    $list[$arEnum["ID"]] = $arEnum;
}
if(!empty($statusId)){
    $statusName = $list[$statusId]["VALUE"];
}


?>
    <main class="py-20">
        <div class="container mx-auto grid grid-cols-[78%_20%] gap-7">
            <div class="flex flex-col gap-8">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "breadcrumb",
                    array(
                        "START_FROM" => "1",
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "COMPONENT_TEMPLATE" => "breadcrumb"
                    ),
                    false
                );?>

                <h1 class="font-montserrat font-semibold text-black text-4xl">Юридический статус</h1>

                <div class="appForm flex flex-col gap-3">
                    <p>Вводный текст как заполнять эти поля </p>

<!--                    СТАТУС+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                    <div class="inputRow">
                        <p class="capitalize text-right">
                            статус
                        </p>

                        <div class="min-w-28 h-full">
                            <div class="bg-white border rounded-md h-full pt-2 pr-3 pl-3 pb-3 relative" data-select="select">
                                <div class="flex gap-2 justify-center items-center cursor-pointer" listinput="">
                                    <p class="UF_STATUS font-montserrat font-semibold text-base w-calc-input" data-value="<?= $statusId ?>"><?= $statusName ?></p><img class="w-5 h-5 object-contain transition-all" src="/local/templates/furnitureAssembly/img/icons/CaretDown.svg" list-btn="" alt="Иконка">
                                </div>
                                <div class="flex flex-col gap-2 absolute bg-white left-0 w-full overflow-hidden top-full shadow-md z-50 h-0" list="">

                                    <? foreach ($list as $item): ?>

                                        <div class="px-3 cursor-pointer pb-2" data-value="<?= $item["ID"] ?>">
                                            <p class="font-montserrat font-semibold text-base" selectVal="<?= $item["ID"] ?>"><?= $item["VALUE"] ?></p>
                                            <p class="font-montserrat font-semibold text-base text-gray-400"></p>
                                        </div>


                                    <? endforeach; ?>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ОПИСАНИЕ+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                    <div class="inputRow items-start">
                        <p class="capitalize text-right">
                            Описание
                        </p>
                        <div class="w-96">
                            <textarea class="border rounded-md min-h-24 pt-3 pr-4 pl-4 pb-4 w-full" data-input="UF_UR_STATUS_DESC" placeholder="Описание"><?= $desc ?></textarea>
                        </div>
                    </div>
                    <!-- ФАЙЛЫ+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                    <div class="inputRow items-start fullGrid">
                        <p class="capitalize text-right">
                           Приложенные документы
                        </p>
                        <div class="flex flex-col gap-4">
                            <label class="flex gap-2 font-montserrat font-semibold cursor-pointer hover:text-primary">Прикрепить документы<img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Paperclip.svg" alt="иконка"/>
                                <input data-file='FILE' class="hidden photo" multiple="multiple"  type="file" name="file[]"/>
                            </label>
                            <div class="w-full docs flex flex-col gap-3">

                                <? foreach ($files as $item): ?>
                                    <div class="flex gap-2 w">
                                        <div class="w-full flex gap-5">
                                            <div class="w-12 h-12"><img class="w-full h-full object-contain" src="/local/templates/furnitureAssembly/img/icons/DocIcons.svg" alt="Иконка"></div>
                                            <div class="w-full flex flex-col gap-1">
                                                <p class="font-montserrat font-semibold text-base text-primary"><?= $item["ORIGINAL_NAME"] ?></p>
                                                <div class="flex gap-2 justify-between">
                                                    <div class="flex gap-2">
                                                        <p class="font-montserrat font-semibold text-base text-gray-500"><?= $item["TIMESTAMP_X"] ?></p>
                                                    </div><a class="flex gap-2 w-max font-montserrat font-semibold text-base text-primary hover:text-[#7a5bca]" href="<?= $item["SRC"] ?>"> Скачать</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach; ?>

                            </div>
                        </div>


                    </div>
                    <p class="error col" style="display: none"></p>

                    <? if($_GET["success"]): ?>
                        <p class="success" >Данные успешно сохранены</p>
                    <? endif; ?>
                    <!-- Кнопка отправки+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                    <button class="mt-4 flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max" data-btn="send">Отправить
                    </button>
                </div>
            </div>

            <div class="flex flex-col gap-16 mt-[4.25rem]">
                <div class="flex flex-col gap-6">
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


<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>