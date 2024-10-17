<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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
$this->setFrameMode(true);

$newspaperNum = array_search('newspaper', array_column($arResult['ITEMS'], 'CODE'));

$newspaperArr = array_slice($arResult['ITEMS'], $newspaperNum, 1)[0];

?>






	<?foreach ($arResult['ITEMS'] as $arItem):?>
    <?
    if($arItem["CODE"] == "newspaper"){
       continue;
    }
        ?>
        <a class="link" href="<?=$arItem["PROPERTY_LINK_VALUE"]?>" style="user-select: auto;">
            <img class="link__img" src="<?= CFile::GetPath($arItem["PROPERTY_ICON_VALUE"])?>" style="user-select: auto;">
            <p style="user-select: auto;"><?=$arItem["NAME"]?></p>
        </a>
	<?
	endforeach;
	?>


