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
if($arResult["ITEMS"]){


?>


<div class="employee__box">
    <div class="inline-block">
        <p class="text " >Благодарности</p>
    </div>

<div class="owl-carousel owl-theme owlGratUP" id="employee-carousel-grat">

        <?foreach ($arResult["ITEMS"] as  $key=>$item):?>

        <?php

        $pieces = explode(" ", $item["PROPERTY_DATE_TIME_VALUE"]);
        $date = $pieces[0]; // кусок1
        $time = $pieces[1]; // кусок2

        $pieces = explode(":", $time);
        $time = $pieces[0] . ":" . $pieces[1];
            if($item["employeeFrom"]["ACTIVE"] == "N"){
                $link = "" ;
                $name = "Сотрудник деактивирован";
            }else{
                $link = $item["employeeFrom"]["DETAIL_PAGE_URL"] ;
                $name = $item["employeeFrom"]["NAME"];

            }
        ?>

                <div class="item grat">
                    <div class="employee-gratitude-item-container">
                        <div class="employee-gratitude-item-header">
                            <div class="employee-gratitude-item-img">
                                <img src="<?= $item["employeeFor"]["EPHOTO"] ?>">
                            </div>
                            <div class="employee-gratitude-item-text">
                                <p class="employee-gratitude-item-thanks">Спасибо</p>
                                <p class="employee-gratitude-item-name"><?= $item["employeeFor"]["NAME"] ?></p>
                            </div>
                        </div>
                        <p class="employee-gratitude-item-description"><?= $item["PROPERTY_GRATITUDES_VALUE"]["TEXT"] ?></p>
                        <div class="employee-gratitude-item-line"></div>
                        <div class="employee-gratitude-item-footer">
                            <div class="employee-gratitude-item-footer-left">
                                <p class="employee-gratitude-item-from">От</p>
                                <a href="<?= $link ?>" class="employee-gratitude-item-who"><?= $name ?></a>
                            </div>
                            <div class="employee-gratitude-item-footer-right">
                                <div class="employee-gratitude-item-footer-right-item">
                                    <img class="employee-gratitude-item-time-icon" src="<?=SITE_TEMPLATE_PATH?>/img/time-icon.svg" />
                                    <p class="employee-gratitude-item-time-text"><?= $time ?></p>
                                </div>
                                <div class="employee-gratitude-item-footer-right-item">
                                    <img class="employee-gratitude-item-date-icon" src="<?=SITE_TEMPLATE_PATH?>/img/date-icon.svg" />
                                    <p class="employee-gratitude-item-date-text"><?= $date ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <?endforeach;?>
</div>
</div>
<?php
}
?>



