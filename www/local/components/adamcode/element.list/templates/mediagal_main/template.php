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

<div class="cards desktop">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>

        <?
        $statusLike = (!$arItem["USER_LIKED"]) ? 'Поставить лайк' : 'Убрать лайк';
        if(!$USER->IsAuthorized())
        {
            $statusLike = 'Поставить лайк';

        }?>

        <div class="card media">
            <div class="card__header">
                <div class="card__img__bg"></div>
                <div class="card__img__bg first"></div>
                <div class="card__img__container">
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
                        <img class="card__img" src="<?= $arItem["PREVIEW_PICTURE"] ?>">
                        </a>
                </div>
                <div class="card__header__nav">
                    <p class="text data red"><?= $arItem['PROPERTY_MEDIA_DATE_VALUE'] ?></p>
                    <div class="tags">
						<? foreach ($arItem['PROPERTY_CATEGORY_VALUE'] as $key => $value)
						{


							?>
                            <div class="tag">
                                <p class="tag__text">   <?= $value ?></p>
                            </div>
						<? } ?>
                    </div>

                </div>
            </div>
            <div class="card__body">
                <div class="card__body__box">
                    <a class="card__text " href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
                        <p class="card__text"> <?= $arItem["NAME"] ?></p>
                    </a>
                </div>
            </div>
            <div class="card__footer">
                <div class="card__footer__box">
                    <div class="btn__group">
                        <div class="btn__panel like <?= ($statusLike == 'Убрать лайк') ? "active" : "";?> <? echo (!$USER->IsAuthorized())?"pe-none":""?>">
                            <div class="btn__panel bg__img  brown<? echo (!$USER->IsAuthorized())?"pe-none":"" ?>">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/Likes.svg">
                            </div>
                            <p class="btn__panel number text-light-brown" data-status="<?= $statusLike ?>" data-id="<?=$arItem['ID']?>">
                               <? echo $arItem["LIKES_COUNT"] ?></p>
                        </div>
                        <!--                                            <div class="btn__panel comment">
                                                <div class="btn__panel bg__img">
                                                    <img src="<?php /*=SITE_TEMPLATE_PATH*/ ?>/img/icon/ChatCentered.svg">
                                                </div>
                                                <p class="btn__panel number text-light-brown"> <p class="btn__panel number text-light-brown">
													<? /* $comment_count = CIBlockElement::GetList(
														array(),
														array('IBLOCK_ID' =>  $IBIDs->MediagalComm, "PROPERTY_FILE_ID" => $arItem["PROPERTIES"]['PHOTOS']["VALUE"]),
														array(),
														false,
														array('ID', 'NAME')
													);
													echo $comment_count */ ?></p>
                                            </div>
-->                                        </div>
                </div>
            </div>
        </div>
	<? endforeach; ?>
</div>
<div class="cards mob owl-carousel owl-theme">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="card media">
            <div class="card__header">
                <div class="card__img__bg"></div>
                <div class="card__img__bg first"></div>
                <div class="card__img__container">
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
                        <img class="card__img" src="<?= $arItem["PREVIEW_PICTURE"] ?>">
                    </a>
                </div>
                <div class="card__header__nav">
                    <p class="text data red"><?= $arItem['PROPERTY_MEDIA_DATE_VALUE'] ?></p>
                    <div class="tags">
						<? foreach ($arItem['PROPERTY_CATEGORY_VALUE'] as $key => $value)
						{


							?>
                            <div class="tag">
                                <p class="tag__text">   <?= $value ?></p>
                            </div>
						<? } ?>
                    </div>

                </div>
            </div>
            <div class="card__body">
                <div class="card__body__box">
                    <a class="card__text " href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
                        <p class="card__text"> <?= $arItem["NAME"] ?></p>
                    </a>
                </div>
            </div>
            <div class="card__footer">
                <div class="card__footer__box">
                    <div class="btn__group">
                        <div class="btn__panel like <?= ($statusLike == 'Убрать лайк') ? "active" : "";?> <? echo (!$USER->IsAuthorized())?"pe-none":""?>">
                            <div class="btn__panel bg__img  brown<? echo (!$USER->IsAuthorized())?"pe-none":"" ?>">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/Likes.svg">
                            </div>

                            <p class="btn__panel number text-light-brown" data-status="<?= $statusLike ?>" data-id="<?=$arItem['ID']?>"><?
								echo $arItem["LIKES_COUNT"] ?></p>
                        </div>
                        <!--                                            <div class="btn__panel comment">
                                                <div class="btn__panel bg__img">
                                                    <img src="<?php /*=SITE_TEMPLATE_PATH*/ ?>/img/icon/ChatCentered.svg">
                                                </div>
                                                <p class="btn__panel number text-light-brown"> <p class="btn__panel number text-light-brown">
													<? /* $comment_count = CIBlockElement::GetList(
														array(),
														array('IBLOCK_ID' =>  $IBIDs->MediagalComm, "PROPERTY_FILE_ID" => $arItem["PROPERTIES"]['PHOTOS']["VALUE"]),
														array(),
														false,
														array('ID', 'NAME')
													);
													echo $comment_count */ ?></p>
                                            </div>
-->                                        </div>
                </div>
            </div>
        </div>
	<? endforeach; ?>
</div>