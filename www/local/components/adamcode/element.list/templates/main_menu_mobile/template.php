<? use Bitrix\Main\Application;
use Bitrix\Main\Context;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);?>


	<?

	$context = Application::getInstance()->getContext();
	// получаем объект Request
	$request = $context->getRequest();
	// или
	$request = Context::getCurrent()->getRequest();
    foreach ($arResult["ITEMS"] as $key => $firstlvl) {   ?>
		<?if(!empty($firstlvl["ELEMENTS"])):?>

              <li>
                            <div class="nav__link mobOpenBtn <?=(stripos($request->getRequestUri(),$firstlvl["UF_LINK"]  )!==false&&($firstlvl["UF_LINK"]!="" ))?"red":""?>"  ><?=$firstlvl["NAME"]?>
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/chevron-down.svg" class="" style="user-select: auto;">
                            </div>
                  <ul class="dropdown">
                                 <?foreach($firstlvl["ELEMENTS"] as $key_name => $grop):?>
                                <li>
                                    <p class="dropdown__group__title"><?=$key_name?></p>
                                    <?foreach($grop as $key_item => $secondlvl):?>

                                    <?

                                        if(!empty($secondlvl["PROPERTY_ICON_VALUE"])){
                                            $icon = CFile::GetPath($secondlvl["PROPERTY_ICON_VALUE"]);
                                        }

                                    ?>

                                    <a class="dropdown__item" href="<?=$secondlvl["PROPERTY_LINK_VALUE"]?>">
                                        <? if ($icon) { ?>
                                            <img src="<?=$icon?>" />
                                        <?}?>
                                        <div class="dropdown__block">
                                            <p class="dropdown__block__title"><?=$secondlvl["NAME"]?></p>
                                            <?if (!empty($secondlvl["PROPERTY_SIGNATURE_VALUE"])):?>
                                            <p class="dropdown__block__description"><?=$secondlvl["PROPERTY_SIGNATURE_VALUE"]?></p>
                        <?endif?>
                        </div>
                                    </a>
                                    <?endforeach;?>
                                </li>
                                 <?endforeach;?>
                            </ul>
                        </li>
                    <?else:?>

                    <li><a class="nav__link disable" href="<?=$firstlvl["UF_LINK"]?>"><?=$firstlvl["NAME"]?></a></li>
                    <?endif;?>
                
                <?}?>
               











