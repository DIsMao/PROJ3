<? use Adamcode\Config\Blocks;
use Adamcode\Services\SearchService;

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

?>


	<?
	foreach ($arResult["ITEMS"] as $key => $arItem)
	{


		$OBJECT_ID = $arItem['ID'];
		$file_type = substr(strrchr($arItem['TITLE'], "."), 1);
		?>
        <div class="search-item">
            <a href="<? echo $arItem["URL"] ?>"><?
				if ($arItem["TYPE"] == 'Excel'):?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/XLSIcons.svg"/>
				<? elseif ($arItem["TYPE"] == 'Word' ):?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/DocIcons.svg"/>
				<? elseif ($arItem["TYPE"] == 'PDF'):?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/PDFIcon.svg"/>
				<? elseif ($file_type == 'PowerPoint'):?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/File icon-1.svg"/>
				<? elseif ($arItem["PARAM2"] !== Blocks::Docs->value):?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/Backspace.svg">
				<?endif; ?>

                <span><? echo $arItem["TITLE_FORMATED"] ?></span>

                <div class="search-item-date">
                    <label><? echo GetMessage("CT_BSP_DATE_CHANGE") ?></label><span><? echo $arItem["DATE_CHANGE"] ?></span>
                </div>

            </a>
            <div class="search-preview"><? echo $arItem["BODY_FORMATED"] ?></div>

        </div>
		<?

	} ?>
<?= $arResult["NAV_STRING"];?>



