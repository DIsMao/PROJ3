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
//echo '<pre>';
//print_r($arResult["ITEMS"]);
//echo '</pre>';
?>
<div class="page__type__page__comments">
    <div class="comments__title">
        <h2>Комментарии</h2>
        <p class="counter"><?=count($arResult["ITEMS"])?></p>
    </div>
    <?if(!empty($arResult["ITEMS"])):?>
    <div class="comments__items">
        <?foreach ($arResult["ITEMS"] as $arItem):
          ?>
        <?
            if($arItem["AUTHOR_INFO"]["ACTIVE"] == "N"){
                $DP_URL = "";
                $NAME = "Пользователь деактивирован";
                $PHOTO = "/local/templates/moskvich/img/people/no-user-photo.png";
            }else{
                $DP_URL = $arItem["AUTHOR_INFO"]["DETAIL_PAGE_URL"];
                $NAME = $arItem["AUTHOR_INFO"]["NAME"];
                $PHOTO = CFile::GetPath($arItem["AUTHOR_INFO"]["PROPERTY_PHOTO_VALUE"]);
                if($PHOTO == ''){
                    $PHOTO = "/local/templates/moskvich/img/people/no-user-photo.png";
                }
            }
            ?>
        <div class="comments__item">
            <a class="comments__item__img" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <img src="<?= $PHOTO ?>">
            </a>
            <div class="comments__item__info">
                <div class="comments__item__info__header">
                    <a href='<?=$DP_URL?>'>
                        <h2 class="comments__item__fio">
                            <?=$NAME?>
                        </h2>
                    </a>
                    <p class="comments__item__date"><?=$arItem["DATE_CREATE"]?></p>
                </div>
                <div class="comments__item__info__body">
                    <p><?=$arItem["DETAIL_TEXT"]?></p>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>
    <?endif?>
    <? if($USER->IsAuthorized()): ?>
    <div class="leave__comment">
        <a href="#">
            <img class="leave__comment__img" src="<?=SITE_TEMPLATE_PATH?>/img/people/no-user-photo.png">
        </a>
        <div class="comment__form">
            <div class="comment__form__input">
                <p class="comment__form__title">Оставить комментарий</p>
                <textarea class="comment__form__textarea" placeholder=""></textarea>
            </div>
            <a href="#" class="btn submit comment">Ответить</a>

        </div>
    </div>
    <? endif; ?>
</div>
<script data-skip-moving="true" >
    let parent=<?=$arResult["ADIT"]["IBLOCK_ID"]?>;
    let objId=<?=$arResult["ADIT"]["ID"]?>;
</script>



