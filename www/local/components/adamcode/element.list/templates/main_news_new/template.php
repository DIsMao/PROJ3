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
?>





<!--<div class="board__news  owl-carousel  owl-theme">-->
<!---->
<!---->
<!--	--><?//
//	foreach ($arResult["ITEMS"] as  $key=>$slide):
//		?>
<!--        <div class="board__new"  data-hash="slide--><?php //=  $key ?><!--">-->
<!--            <div class="card board__new">-->
<!--                <div class="board__new__img">-->
<!--                    <a href="--><?php //=$slide["DETAIL_PAGE_URL"]?><!--">-->
<!---->
<!--                    <img class="card__img" src="--><?php //=$slide['PREVIEW_PICTURE']?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--                <div class="card__box">-->
<!--                    <div class="card__header">-->
<!--                        <div class="card__header__nav">-->
<!--                            <p class="text data red">--><?php //=FormatDate("d F", MakeTimeStamp($slide['PROPERTY_DATE_VALUE']))?><!--</p>-->
<!--                            <div class="tags news" >-->
<!---->
<!--								--><?//foreach ($slide["categories"] as $key => $category):?>
<!--                                <div class="tag pe-none" style="cursor: unset">-->
<!---->
<!--                                    <p class="tag__text"> --><?php //=$category["NAME"]?><!--</p>-->
<!--                                </div>-->
<!--							--><?//endforeach;?>
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="card__body">-->
<!--                        <a href="--><?php //=$slide["DETAIL_PAGE_URL"]?><!--">-->
<!--                            <p class="card__title">--><?php //=$slide['NAME']?><!--</p>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="card__footer">-->
<!--                        <div class="card__footer__box">-->
<!--                            <div class="btn__group">-->
<!--                                <a class="btn img" href="--><?php //=$slide["DETAIL_PAGE_URL"]?><!--">-->
<!--                                    <p class="btn__text">Открыть</p>-->
<!--                                    <img src="--><?php //=SITE_TEMPLATE_PATH?><!--/img/icons/linkPage.svg">-->
<!--                                </a>-->
<!--                                <div class="btn__panel__group" style="user-select: auto;">-->
<!--									--><?//
//									$statusLike = (!$slide["USER_LIKED"]) ? 'Поставить лайк' : 'Убрать лайк';
//									if(!$USER->IsAuthorized())
//									{
//										$statusLike = 'Поставить лайк';
//
//
//									}
//                                    ?>
<!--                                    <div class="btn__panel like  --><?php //= ($statusLike == 'Убрать лайк') ? "active" : ""; ?><!-- --><?// echo (!$USER->IsAuthorized())?"pe-none":""?><!--" style="user-select: auto;">-->
<!--                                        <div class="btn__panel bg__img brown" style="user-select: auto;">-->
<!--                                            <img src="--><?php //=SITE_TEMPLATE_PATH?><!--/img/icon/Likes.svg" style="user-select: auto;">-->
<!--                                        </div>-->
<!--                                        <p class="btn__panel number text-light-brown" data-status="--><?php //= $statusLike ?><!--" data-id="--><?php //=$slide['ID']?><!--">-->
<!--											--><?//
//											echo  $slide["LIKES_COUNT"]?><!--</p>-->
<!--                                    </div>-->
<!--                                    <div class="btn__panel heart" style="user-select: auto;">-->
<!--                                        <div class="btn__panel bg__img brown" style="user-select: auto;">-->
<!--                                            <img src="--><?php //=SITE_TEMPLATE_PATH?><!--/img/icon/Eye.svg" style="user-select: auto;">-->
<!--                                        </div>-->
<!--                                        <p class="btn__panel number text-light-brown" style="user-select: auto;">--><?php //=$slide['SHOW_COUNTER']?><!--</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--		--><?// $slidecount++;
//	endforeach;
//	?>
<!---->
<!---->
<!--</div>-->

<div class="board__news__bottom ">
	<?foreach ($arResult["ITEMS"] as $key => $item) :?>
            <div class="card new mainNewsCard" data-slide="slide<?= $key?>">
                <div class="card__header">
                    <div class="card__img__container ">
                        <a href="<?=$item["DETAIL_PAGE_URL"]?>">

                        <img class="card__img" src="<?=$item['PREVIEW_PICTURE']?>">
                        </a>
                    </div>


                    <div class="card__header__nav">
                        <p class="text data red"><?=FormatDate("d.m.Y", MakeTimeStamp($item['PROPERTY_DATE_VALUE']))?></p>
                        <div class="tags news" style="margin-top: -4px;">

							<?foreach ($item["categories"] as $key => $value):?>
                                <div class="tag pe-none" style="cursor: unset">

                                    <p class="tag__text"> <?=$value["NAME"]?></p>
                                </div>
							<?endforeach?>
                        </div>
                    </div>

                </div>
                <div class="card__body">
                    <div class="card__body__box">
                        <a href="<?=$item['DETAIL_PAGE_URL']?>">
                            <p class="card__text"><?=$item['NAME']?></p>
                        </a>
                    </div>
                </div>
                <div class="card__footer" style="user-select: auto;">
                    <div class="card__footer__box" style="user-select: auto;">
						<?
						$statusLike = (!$item["USER_LIKED"]) ? 'Поставить лайк' : 'Убрать лайк';
                        if(!$USER->IsAuthorized())
                        {
                        $statusLike = 'Поставить лайк';

                        }?>
                        <div class="btn__group" style="user-select: auto;">
                            <div class="btn__panel like  <?= ($statusLike == 'Убрать лайк') ? "active" : "";?> <? echo (!$USER->IsAuthorized())?"pe-none":""?>" style="user-select: auto;">
                                <div class="btn__panel bg__img brown<? echo (!$USER->IsAuthorized())?"pe-none":"" ?>" style="user-select: auto;">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Likes.svg" style="user-select: auto;">
                                </div>
                                <p class="btn__panel number text-light-brown" data-status="<?= $statusLike ?>" data-id="<?=$item['ID']?>">
									<?=$item["LIKES_COUNT"]?></p>
                            </div>
                            <div class="btn__panel heart" style="user-select: auto;">
                                <div class="btn__panel bg__img brown" style="user-select: auto;">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Eye.svg" style="user-select: auto;">
                                </div>
                                <p class="btn__panel number text-light-brown" style="user-select: auto;"><?=$item['SHOW_COUNTER']?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



	<?endforeach;?>
</div>
<a class="link" href="/news/" style=" font-weight: bold;">Показать все новости</a>
