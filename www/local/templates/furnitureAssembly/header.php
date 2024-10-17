<?
//phpinfo();

use Adamcode\Services\MenuService;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Page\Asset;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

CModule::IncludeModule("intranet");


$isCompositeMode = defined("USE_HTML_STATIC_CACHE");


?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
<?
$APPLICATION->ShowHead();
//css libs

//css
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/style.css", true);
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/input.css", true);
//js libs
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/libs/jquery/jquery-3.7.1.min.js", true);
//js
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/common.js", true);
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="/local/templates/furnitureAssembly/img/other/favicon.ico" type="image/x-icon"/>
    <title><? $APPLICATION->ShowTitle()?></title>

</head>
<? if (( $USER->IsAdmin()) && !defined("SKIP_SHOW_PANEL")):?>
    <div id="panel">
        <?$APPLICATION->ShowPanel();?>
    </div>
<? endif ?>
<body>
<div id="content-wrapper">
    <?
    if(isset($disHeaderFooter) == true){return;}
    ?>
    <header class="mt-11">

        <div class="container px-2 sm:px-0 mx-auto">
            <div class="flex flex-col gap-8">
                <div class="flex items-center justify-between">
                    <div class="w-32 h-10"><img class="w-full h-full object-cover" src="/local/templates/furnitureAssembly/img/other/stub.png" alt="лого"></div>
                    <div class="flex gap-8 items-center">
                        <div class="relative bg-white border rounded-md h-full p-2 " data-search="main">
                            <div class="flex gap-2 items-center justify-center"><img class="w-5 h-5 object-contain filter brightness-90 opacity-70" src="/local/templates/furnitureAssembly/img/icons/MagnifyingGlass.svg" alt="иконка">
                                <input class="outline-none" type="text" placeholder="Поиск по сотрудникам">
                                <div class="flex gap-2 p-2 border rounded-md">
                                    <button data-btn="search_user" style="filter: invert(59%) sepia(62%) saturate(3426%) hue-rotate(220deg) brightness(99%) contrast(98%);"><img class="w-5 h-5 object-contain" src="/local/templates/furnitureAssembly/img/icons/User.svg" alt="иконка"></button>
                                    <div class="border-l border-gray-400 h-5 w-[1px]"> </div>
                                    <button data-btn="search_order"><img class="w-5 h-5 object-contain" src="/local/templates/furnitureAssembly/img/icons/ClipboardText.svg" alt="иконка"></button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 absolute bg-white left-0 w-full overflow-hidden h-0 top-full shadow-md" searchlist="">
                                <div class="px-3 cursor-pointer"><a class="font-montserrat font-semibold text-base hover::text-[#E04E00] " href="#">Иванов Иван1</a></div>
                                <div class="px-3 cursor-pointer"><a class="font-montserrat font-semibold text-base hover::text-[#E04E00]" href="#">Иванов Иван2</a></div>
                                <div class="px-3 cursor-pointer"><a class="font-montserrat font-semibold text-base hover::text-[#E04E00]" href="#">Иванов Иван3</a></div>
                            </div>
                        </div>
                        <?if ($USER->IsAuthorized()):?>
                            <div class="flex gap-4"><a class="w-12  h-12 cursor-pointer"><img class="w-full h-full object-contain rounded-full" src="/local/templates/furnitureAssembly/img/people/Avatar_1.png"></a>
                                <div class="flex items-center gap-2">
                                    <a class="font-montserrat font-semibold cursor-pointer text-base leading-4 text-black hover:text-[#7a5bca]">Личный кабинет</a>
                                </div>
                            </div>
                        <?endif?>
                        <?if ($USER->IsAuthorized()):?>
                            <a href="/auth/?logout=yes&<?=bitrix_sessid_get()?>" class="w-6 h-6 cursor-pointer relative"><img class="w-full h-full object-contain peer" src="/local/templates/furnitureAssembly/img/icons/SignOut.svg">
                                <div class="hidden p-2 rounded-md bg-black w-max peer-hover:block ">
                                    <p class="font-montserrat font-semibold text-base text-white">Выход</p>
                                </div>
                            </a>
                        <? else: ?>
                            <a href="/auth/" class="w-6 h-6 cursor-pointer relative"><img class="w-full h-full object-contain peer" src="/local/templates/furnitureAssembly/img/icons/DoorOpen.svg">
                                <div class="hidden p-2 rounded-md bg-black w-max peer-hover:block ">
                                    <p class="font-montserrat font-semibold text-base text-white">Войти</p>
                                </div>
                            </a>
                        <?endif?>
                    </div>
                </div>
                <nav class="flex gap-2 justify-between">
                    <? $menu=MenuService::getItems();
                    $APPLICATION->IncludeComponent(
                        "adamcode:element.list",
                        "main_menu",
                        array(
                            "DATA" => $menu,
                        ),
                        false
                    );?>

                </nav>
            </div>
        </div>


    </header>