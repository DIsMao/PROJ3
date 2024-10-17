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
//                                        echo '<pre>';
//                                print_r($arResult['ITEMS']);
//                                echo '</pre>';
?>


    <?foreach ($arResult['ITEMS'] as $mounth=>$items):?>

    <div class="page__birthdays__title__block">
        <h2 class="page__birthdays__title"><?=$mounth?></h2>
        <p class="page__birthdays__title__count"><?=count($items)?></p>
    </div>
<div class="page__birthdays__items">
    <?foreach ($items as $arItem):?>
            <div class="card employee birthday " style="margin-bottom: 0; ">
                <img class="card__img" src="<?= $arItem["PHOTO"] ?>">
                <div class="card__box">
                    <div class="card__header">
                        <p style="display: none;"><?= $arItem['PROPERTY_EMAIL_VALUE']?></p>
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
                        <p class="card__job"><?= $arItem["PROPERTY_POSITION_VALUE"] ?></p>
                        <? if (($arItem["CAN_CONGRAT"]) && ($USER->IsAuthorized())): ?>


                            <a  hx-post="/dynamic_elements/birthday_modal.php"
                                hx-trigger="click"
                                hx-vals='<?=json_encode($arItem,JSON_UNESCAPED_UNICODE)?>'
                                hx-target="#popUp"
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
</div>
<?endforeach;?>


