<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
use Bitrix\Main\Type\DateTime;
$this->setFrameMode(true);

//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
//ENUM_ID
?>






	<?foreach ($arResult["ITEMS"] as  $key=>$slide):?>
<?php

        if($slide["PROPERTY_COLOR_VALUE"] == "Черный" || $slide["PROPERTY_COLOR_ENUM_ID"] == 18){
            $color = "black";
        }elseif ($slide["PROPERTY_COLOR_VALUE"] == "Белый" || $slide["PROPERTY_COLOR_ENUM_ID"] == 19){
            $color = "white";
        }elseif ($slide["PROPERTY_COLOR_VALUE"] == "Фирменный" || $slide["PROPERTY_COLOR_ENUM_ID"] == 20){
            $color = "var(--pink-color)";
        }
        if($slide["PROPERTY_CATEG_VALUE"] != ""){
            $slide["PROPERTY_CATEG_VALUE"] = " . " . $slide["PROPERTY_CATEG_VALUE"];
        }

        // получаем массив, содержащий размеры изображения

        list($width, $height) = getimagesize(SITE_TEMPLATE_PATH . $slide["DETAIL_PICTURE"]);
        ?>


        <div class="item" onclick="location.href = '<?= $slide["PROPERTY_LINK_VALUE"]?>';">
            <div class="effect">

            <img  src="<?= $slide["DETAIL_PICTURE"]?>" alt="">

            </div>
<div class="blur-block">

</div>
            <div class="tt">
                <div class="date" style="color: <?= $color ?>"><?= $slide["PROPERTY_DATE_VALUE"]?><?= $slide["PROPERTY_CATEG_VALUE"]?></div>
                <div class="name"><a style="color: <?= $color ?>" href="<?= $slide["PROPERTY_LINK_VALUE"]?>" ><?= $slide["NAME"]?></a></div>
            </div>
        </div>

<?endforeach;?>
