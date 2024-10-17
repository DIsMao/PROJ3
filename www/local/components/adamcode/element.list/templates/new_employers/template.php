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



<div class="page__new__employees__items">
	<?foreach($arResult["ITEMS"] as $arItem):?>



	<div class="card__new__employees">
		<div class="card__new__employees__block text">
            <?if ($arItem['PROPERTY_LAST_POSITION_VALUE']==""): ?>
				<h2 class="card__new__employees__title">Новый сотрудник</h2>
            <?else:?>
                <h2 class="card__new__employees__title"><?=$arItem['PROPERTY_LAST_POSITION_VALUE']?></h2>
                <p class="card__new__employees__description"><?=$arItem['PROPERTY_LAST_DEP_VALUE']?></p>
        <?endif?>
        </div>
			<div class="card__new__employees__block">
				<img  src="<?=SITE_TEMPLATE_PATH?>/img/icon/CaretCircleDoubleRight.svg" />
			</div>
			<div class="card__new__employees__block text">
				<h2 class="card__new__employees__title"><?=$arItem["PROPERTY_POSITION_VALUE"]?></h2>

                <p class="card__new__employees__description red"><?=$arItem['PROPERTY_DEP_VALUE']?></p>

            </div>
        <div class="card__new__employees__block">
            <div class="employees__item">
                <a>
                    <img src="<?=($arItem["PHOTO"])?>">
                </a>
                <div class="employees__item__info">
                    <a href="<?=$arItem["employee"]["DETAIL_PAGE_URL"]?>">
                        <p class="employees__item__info__fio"><?=$arItem['NAME']?></p>
                    </a>
                    <p class="employees__item__info__date"><?=FormatDate("j F Y", MakeTimeStamp($arItem['PROPERTY_DATE_VALUE']))?></p>
                </div>

            </div>
        </div>

    </div>
	<?endforeach;?>
</div>
<?=$arResult["NAV_STRING"]?>


