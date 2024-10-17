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
<div class="widget__body">
        <?
    foreach ($arResult['ITEMS'] as $arItem):?>
        <div class="link__block">
            <a href="<?=$arItem["PROPERTY_LINK_VALUE"]?>" class="link"><?=$arItem["NAME"]?>
                <img class="aquamarine" src="<?=SITE_TEMPLATE_PATH?>/img/icon/ArrowUpRight.svg" alt=""></a>
            <img  hx-post="/dynamic_elements/user_link_modal.php"
                  hx-trigger="click"
                  hx-target="#popUpLink"
                  hx-vals='{"mode": "update", "sort": "<?=$arItem["SORT"]?>","id": "<?=$arItem["ID"]?>","name": "<?=$arItem["NAME"]?>","link": "<?=$arItem["PROPERTY_LINK_VALUE"]?>"}'
                  data-bs-toggle="modal"
                  data-bs-target="#popUpLink" class="aquamarine item__edite_link" src="<?=SITE_TEMPLATE_PATH?>\img\icon\edit-05.svg" alt="">
            <img class="aquamarine item__delete" data-id="<?=$arItem["ID"]?>" src="<?=SITE_TEMPLATE_PATH?>\img\icon\delete.svg" alt="">
        </div>


    <? endforeach ?>
</div>

