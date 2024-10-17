<? use Adamcode\Services\DocLibraryServices;
use Bitrix\Main\Context;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
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
$request = Context::getCurrent()->getRequest();


//echo '<pre>';
//print_r($arResult['ITEMS']);
//echo '</pre>';
?>
<div class=" page__catalog__documents__box">
    <div  class="folder__menu">


		<?=DocLibraryServices::printList($arResult["ADIT"]["tree"], $request->getQuery("SECTION_ID"))?>
    </div>
<div class="page__catalog__documents__items">
    <?foreach ($arResult['ITEMS'] as $item):?>
                        <div class="card__document">
                            <div class="card__document__img">
								<?if($item["EXTENSION"] == 'xls'|| $item["EXTENSION"] == 'xlsx'):?>
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Fileicon-7.svg" />
								<?elseif($item["EXTENSION"] == 'doc' || $item["EXTENSION"] == 'docx'):?>
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Fileicon.svg" />
								<?elseif($item["EXTENSION"] == 'pdf'):?>
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Fileicon-4.svg" />
								<?elseif($item["EXTENSION"] == 'pptx'):?>
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/Fileicon-1.svg" />

								<?endif;?>
                            </div>
                            <div class="card__document__block">

                                <div class="card__document__header" style="user-select: text;">
									<?if ($item["PROPERTY_CATEGORY_VALUE"]!=""):?>

                                        <p class="red" style="user-select: text;"><?=$item["PROPERTY_CATEGORY_VALUE"]?></p>
									<?endif;?>


                                </div>

                                <div class="document__body">
                                    <p><?=$item['NAME']?></p>
                                </div>
                                <div class="card__document__footer" style="user-select: text;">
                                    <p style="user-select: text;"><?=$item["DATE_CREATE"]?> <?if (!empty($file['PROPERITIES']["DATE_START"]["VALUE"])) echo "| ". "Срок действия: ". $file['PROPERITIES']["DATE_START"]["VALUE"]. "-". $file['PROPERITIES']["DATE_END"]["VALUE"]?></p>
                                    <a class="link" href="<?=$item['DETAIL_PAGE_URL']?>"  style="user-select: text;">
                                        <p style="user-select: text;">Скачать</p>
                                        <img class="link__img" src="<?=SITE_TEMPLATE_PATH?>/img/icon/download-cloud-02.svg" style="user-select: text;">
                                    </a>
                                </div>

                            </div>

                        </div>

    <?endforeach;?>

        </div>
</div>
<?= $arResult["NAV_STRING"];?>



