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




    <div class="owl-carousel owlGrat">

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
        <div class="item">
            <div class="gratitude">
                <div class="gratitude-card">
                    <a href="<?= $item["employeeFor"]["DETAIL_PAGE_URL"] ?>">
                        <div class="gratitude-card-img">
                            <img src="<?= $item["employeeFor"]["EPHOTO"] ?>">
                        </div>
                    </a>
                    <div class="gratitude-card-info">
                        <p class="gratitude-card-thanks">Спасибо</p>
                        <a class="gratitude-card-name" href="<?= $item["employeeFor"]["DETAIL_PAGE_URL"] ?>">
                            <?= $item["employeeFor"]["NAME"] ?>
                        </a>
                    </div>
                </div>
                <div class="slider_desc" id="desc<?= $item["ID"] ?>">
                    <p class="slider_desc_p"><?= $item["PROPERTY_GRATITUDES_VALUE"]["TEXT"] ?></p>
                </div>
                <div class="slider_desc_toogler" data-id = "<?= $item["ID"] ?>"><a class="gratitude-text-btn">Показать больше</a><img class="gratitude-btn-icon" src="<?=SITE_TEMPLATE_PATH?>/img/grat-down-arrow.png" /></div>
                <div class="gratitude-line"></div>
                <div class="gratitude-from-container">
                    <p class="gratitude-from">
                        От
                    </p>
                    <a class="gratitude-from-name" href="<?= $link ?>"><?= $name ?></a>
                </div>
                <div class="gratitude-footer">
                    <div class="gratitude-datetime">
                        <p class="gratitude-time">
                            <img class="gratitude-time-icon" src="<?=SITE_TEMPLATE_PATH?>/img/time-icon.svg" /> <?= $time ?>
                        </p>
                        <p class="gratitude-date">
                            <img class="gratitude-date-icon" src="<?=SITE_TEMPLATE_PATH?>/img/date-icon.svg" /> <?= $date ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>





