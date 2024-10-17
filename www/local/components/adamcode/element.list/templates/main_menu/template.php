<? use Bitrix\Main\Application;
use Bitrix\Main\Context;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>


	<?

	$context = Application::getInstance()->getContext();
	// получаем объект Request
	$request = $context->getRequest();
	// или
	$request = Context::getCurrent()->getRequest();
    foreach ($arResult["ITEMS"] as $key => $firstlvl) {   ?>
		<?if(!empty($firstlvl["ELEMENTS"])):?>
<div class="relative" dropdowns="">
    <div class="flex gap-2">
        <a href="<?=$firstlvl["UF_LINK"]?>" class="font-montserrat font-semibold text-base text-black <?=(stripos($request->getRequestUri(),$firstlvl["UF_LINK"]  )!==false&&($firstlvl["UF_LINK"]!="" ))?"text-primary":""?>">
            <?=$firstlvl["NAME"]?>
        </a>
        <img class="w-6 h-6 object-contain cursor-pointer transition-transform duration-300 transform" dropdownsbtn="" src="/local/templates/furnitureAssembly/img/icons/CaretDown.svg" alt="иконка">
    </div>
    <div class="absolute transition-all duration-300 max-h-0 overflow-hidden bg-white rounded-md shadow-md" dropdownslist="">
        <div class="py-4 px-4 flex flex-col gap-4 min-w-52 bg-white z-50 relative">

                                 <?foreach($firstlvl["ELEMENTS"] as $key_name => $grop):?>

                                    <?foreach($grop as $key_item => $secondlvl):?>

                                    <?

                                        if(!empty($secondlvl["PROPERTY_ICON_VALUE"])){
                                            $icon = CFile::GetPath($secondlvl["PROPERTY_ICON_VALUE"]);
                                        }

                                    ?>

                                            <div class="flex gap-3">
                                                <? if ($icon) { ?>
                                                    <img class="w-6 h-6 object-contain mt-1 filter-primary" src="/local/templates/furnitureAssembly/img/icons/FolderOpen.svg" alt="иконка">
                                                <?}?>
                                                <a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="<?=$secondlvl["PROPERTY_LINK_VALUE"]?>"><?=$secondlvl["NAME"]?></a>
                                            </div>

                                    <?endforeach;?>

                                 <?endforeach;?>
                                        </div>
        </div>
    </div>
                    <?else:?>
            <div class="relative" dropdowns="">
                <div class="flex gap-2">
                    <a href="<?=$firstlvl["UF_LINK"]?>" class="font-montserrat font-semibold text-base text-black <?=(stripos($request->getRequestUri(),$firstlvl["UF_LINK"]  )!==false&&($firstlvl["UF_LINK"]!="" ))?"text-primary":""?>">
                        <?=$firstlvl["NAME"]?>
                    </a>
                </div>
            </div>
                    <?endif;?>

                <?}?>








<!--<div class="relative" dropdowns="">-->
<!--    <div class="flex gap-2">-->
<!--        <p class="font-montserrat font-semibold text-base text-black">Заказы</p><img class="w-6 h-6 object-contain cursor-pointer transition-transform duration-300 transform" dropdownsbtn="" src="./local/templates/furnitureAssembly/img/icons/CaretDown.svg" alt="иконка">-->
<!--    </div>-->
<!--    <div class="absolute transition-all duration-300 max-h-0 overflow-hidden bg-white rounded-md shadow-md" dropdownslist="">-->
<!--        <div class="py-4 px-4 flex flex-col gap-4 min-w-52 bg-white z-50 relative">-->
<!---->
<!--            <div class="flex gap-3">-->
<!--                <img class="w-6 h-6 object-contain mt-1 filter-primary" src="./local/templates/furnitureAssembly/img/icons/FolderOpen.svg" alt="иконка">-->
<!--                <a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Счета/акты</a>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->



