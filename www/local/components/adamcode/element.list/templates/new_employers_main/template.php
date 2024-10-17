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
?>

<div class="cards__employee">
	<?
	foreach ($arResult['ITEMS'] as $key => $arItem):


			if ($arItem["LAST_POSITION_VALUE"]==="")
				{
					$arItem["TITLE"]= 'Добро пожаловать в команду !';


				}
				else
				{
					$arItem["TITLE"]= "Поздравляю с новой должностью!";

                }
			?>
            <div class="card employee no_angle  blue_background_card">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img class="card__img" src="<?=$arItem["PHOTO"]?>" />
                </a>
                <div class="card__box pt-2  ">
                    <div class="card__header my-1">
                    <a href="<?=$arItem["employee"]["DETAIL_PAGE_URL"]?>">
                        <p class="card__fio"><?=$arItem['NAME']?></p>
                    </a>
                        <p class="mail" style="display: none;">
							<?=$arItem["PROPERTY_EMAIL_VALUE"] ?>
                        </p>
                </div>

                    <div class="card__footer">
                        <p class="card__job mh-100  "><?=$arItem["PROPERTY_POSITION_VALUE"]?></p>
                    <?
              /*         if ($USER->IsAuthorized()): */?><!--
                            <a  hx-post="/dynamic_elements/new_employee_congrat.php"
                                hx-trigger="click"
                                hx-vals='<?php /*=json_encode($arItem,JSON_UNESCAPED_UNICODE)*/?>'
                                hx-target="#popUp"
                                data-bs-toggle="modal"
                                data-bs-target="#popUp" class="link new_employ" href="#" style="user-select: auto;">
                            <p style="user-select: auto; font-weight: 600;">Поздравить</p>
                        </a>
                        --><?/*endif*/?>
                    </div>

            </div>
            </div>
	<?endforeach?>
</div>
