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
?>


	<? foreach ($arResult["ITEMS"] as $arItem): ?>

        <div class="card employee rating">
            <a href="#">
                <img class="card__img" src="<?= CFile::GetPath($arItem["PROPERTY_PHOTO_VALUE"]) ?>">
            </a>
            <div class="card__box">
                <div class="card__header">
                    <a src="#">
                        <p class="card__fio"><?= $arItem["NAME"] ?></p>
                        <img class="card__award__img" src="<?=SITE_TEMPLATE_PATH?>/images/exampel/award.svg">
                    </a>
                </div>
                <div class="card__body">
                    <p class="card__job"><?= $arItem["PROPERTY_DOLJN_VALUE"] ?></p>
                </div>
                <div class="card__footer">
                    <p><span class="color-2">Номинация:</span> <?= $arItem["GROUP"]["NAME"] ?></p>
                </div>
            </div>

        </div>

	<? endforeach; ?>
