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
 /*			echo '<pre>';
 print_r($arResult);
 echo '</pre>';
*/?>

<ul class="tab">
    <li class="active">Предстоящие</li>
    <li>Прошедшие</li>
</ul>


<div class="widget__events active">
	<? foreach($arResult["ITEMS"]["ACTIVE"] as $arItem):

		?>

        <div class="widget__event">
            <div class="widget__event__left">
                <p class="text__data"><?=$arItem["PROPERTY_DATE_OPEN_FORMATTED_VALUE"]?></p>
				<?if(!empty($arItem["PROPERTY_SUBBED_VALUE"])):
                    ?>
                    <div class="widget__event__block">
                        <div class="widget__event__employee">
							<?  foreach ($arItem["PROPERTY_SUBBED_INFO"]as $item):

								?>


                                <a href="<?=$item["DETAIL_PAGE_URL"]?>">
                                    <img src="<?=$item["PHOTO"]?>" alt="">
                                </a>

							<? endforeach;?>


                            <? if( count($arItem["PROPERTY_SUBBED_VALUE"])>3):?>
                                <a href="#">
                                    <p class="text">+ <?=count($arItem["PROPERTY_SUBBED_VALUE"])-3?></p>
                                </a>
							<?endif?>
                        </div>

                    </div>
				<?endif;?>
            </div>
            <div class="widget__event__right">
                <a  href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <p class="widget__event__title"><?=$arItem["NAME"]?></p>
                </a>
            </div>
        </div>





	<?endforeach;?>
</div>
<div class="widget__events">
	<? foreach($arResult["ITEMS"]["ARCHIVE"] as $arItem):?>
 <div class="widget__event">
            <div class="widget__event__left">
                <p class="text__data"><?=$arItem["PROPERTY_DATE_OPEN_FORMATTED_VALUE"]?></p>
				<?if(!empty($arItem["PROPERTY_SUBBED_VALUE"])):?>

                    <div class="widget__event__block">
                        <div class="widget__event__employee">
							<?  foreach ($arItem["PROPERTY_SUBBED_INFO"]as $item):

								?>


                                <a href="<?=$item["DETAIL_PAGE_URL"]?>">
                                    <img src="<?=$item["PHOTO"]?>" alt="">
                                </a>

							<? endforeach;?>
							<? if( count($arItem["PROPERTY_SUBBED_INFO"])>3):?>
                                <a href="#">
                                    <p class="text">+ <?=count($arItem["PROPERTY_SUBBED_VALUE"])-3?></p>
                                </a>
							<?endif?>
                        </div>

                    </div>
				<?endif;?>
            </div>
            <div class="widget__event__right">
                <a  href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <p class="widget__event__title"><?=$arItem["NAME"]?></p>
                </a>
            </div>
        </div>





	<?endforeach;?>
                            
        
                        

