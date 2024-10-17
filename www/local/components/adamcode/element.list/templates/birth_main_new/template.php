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
$i = 0;
?>

<div class="cards__employee birthday">
    <?
    foreach ($arResult['ITEMS'] as $arItem):?>
    <?
        $i++;
        if($i > 4){
continue;
        }
        ?>
            <div class="card employee birthday no_angle " >
                <img class="card__img" src="<?= $arItem["PHOTO"] ?>">
                <div class="card__box">
                    <div class="card__header">
                        <p style="display: none;"><?= $arItem['PROPERTY_EMAIL_VALUE'][0] ?></p>
                        <p class="card__data">
                            <? echo FormatDate("d F", MakeTimeStamp($arItem["PROPERTY_DATE_VALUE"])); ?>
                        </p>
                    </div>
                    <div class="card_body">
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                            <p class="card__fio">
                                <?=$arItem["NAME"]?>
                            </p>
                            <p class="employees__item__info__job hidden">
                                <?= $arItem["PROPERTY_POSITION_VALUE"] ?>
                            </p>
                        </a>
                    </div>
                    <div class="card__footer">
						<? if (($arItem["CAN_CONGRAT"]) && ($USER->IsAuthorized())): ?>
                            <p class="card__job"><?= $arItem["PROPERTY_POSITION_VALUE"] ?></p>

                            <a  hx-post="/dynamic_elements/birthday_modal.php"
                                hx-trigger="click"
                                hx-vals='js:{"id": "<?= $arItem["ID"] ?>"}'                                hx-target="#popUp"
                                data-bs-toggle="modal"
                                data-bs-target="#popUp"  class="link birthday" href="#"
                               style="user-select: auto;">
                                <img class="link__img" src="<?= SITE_TEMPLATE_PATH ?>/img/icon/Cake.svg"
                                     style="user-select: auto;">
                                <p style="user-select: auto;">Поздравить</p>
                            </a>


                        <? endif; ?>
                    </div>
                </div>
            </div>



    <? endforeach ?>
    <a class="link " href="/birthdays/">
        <p class="blue fw-bold"  >Показать еще </p>
    </a>
</div>

<?php
//echo '<pre>';
//print_r($arResult['ITEMS']);
//echo '</pre>';
?>