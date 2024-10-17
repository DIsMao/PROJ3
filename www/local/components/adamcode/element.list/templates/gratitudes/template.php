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
$this->setFrameMode(true);
//echo '<pre>';
//print_r($arResult['ITEMS']);
//echo '</pre>';
?>



<?foreach ($arResult["ITEMS"] as  $key=>$item):?>

<?php

    $pieces = explode(" ", $item["PROPERTY_DATE_TIME_VALUE"]);
     $date = $pieces[0]; // кусок1
     $time = $pieces[1]; // кусок2

    $pieces = explode(":", $time);
    $time = $pieces[0] . ":" . $pieces[1];
//    echo '<pre>';
//    print_r($arResult["ITEMS"]);
//    echo '</pre>';

    if($item["employeeFrom"]["ACTIVE"] == "N"){
        $link = "" ;
        $name = "Сотрудник деактивирован";
    }else{
        $link = $item["employeeFrom"]["DETAIL_PAGE_URL"] ;
        $name = $item["employeeFrom"]["NAME"];

    }
    ?>
    <div class="gratitudes-item">
        <div class="gratitudes-item-header">
            <div class="gratitudes-item-card">
                <a href="">
                    <div class="gratitudes-item-img green">
                        <img src="<?= $item["employeeFor"]["EPHOTO"] ?>">
                    </div>
                </a>
                <div class="gratitudes-item-info">
                    <p class="gratitudes-item-thanks">Спасибо</p>
                    <a class="gratitudes-item-name" href="<?= $item["employeeFor"]["DETAIL_PAGE_URL"] ?>"><?= $item["employeeFor"]["NAME"] ?></a>

                </div>
            </div>

            <div class="gratitudes-item-from">
                <p class="gratitudes-item-from-text">От</p>
                <a class="gratitudes-item-from-who" href="<?= $link ?>"><?= $name ?></a>
            </div>
        </div>
        <p class="gratitudes-item-text text<?= $item["ID"] ?>">
            <?= $item["PROPERTY_GRATITUDES_VALUE"]["TEXT"] ?>
        </p>
        <div class="gratitudes-item-footer">
            <div class="gratitudes-show-more" data-id = "text<?= $item["ID"] ?>"><a class="gratitudes-link-show">Показать больше</a><img class="lk-arrow-down" src="<?=SITE_TEMPLATE_PATH?>/img/grat-down-arrow.png"></div>
            <div class="gratitudes-item-from-sm">
                <p class="gratitudes-item-from-text">От</p>

                <a class="gratitudes-item-from-who" href="<?= $link ?>">
                    <?= $name ?>
                </a>
            </div>
            <div class="gratitudes-item-datetime">
                <div class="gratitudes-item-time">
                    <img class="gratitudes-item-datetime-icon" src="<?=SITE_TEMPLATE_PATH?>/img/time-icon.svg">
                    <p class="gratitudes-item-datetime-text"><?= $time ?></p>
                </div>
                <div class="gratitudes-item-date">
                    <img class="gratitudes-item-datetime-icon" src="<?=SITE_TEMPLATE_PATH?>/img/date-icon.svg">
                    <p class="gratitudes-item-datetime-text"><?= $date ?></p>
                </div>
            </div>
        </div>
    </div>

<?endforeach;?>



