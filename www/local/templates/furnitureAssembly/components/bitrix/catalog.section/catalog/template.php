<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Engine\UrlManager,
	\Bitrix\Main\Loader,
	\Bitrix\Disk;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

global $IBIDs;
$this->setFrameMode(true);
// 	echo "<pre>";
// print_r($arResult);
// echo "</pre>";
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/order_list.js");

if (!empty($arResult['NAV_RESULT']))
{
	$navParams = array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
} else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}


?>






<?
$offers = array();
function check__favor($value): bool
{
	global $IBIDs;
	global $USER;
	$arFilter = array(
		"IBLOCK_ID" => $IBIDs->favor,
		"PROPERTY_USER" => $USER->GetID()
	);
	$res = CIBlockElement::GetList(array(), $arFilter);
	if ($res->SelectedRowsCount() > 0)
	{
		{
			if ($ob = $res->GetNextElement())
			{$arprops=$ob->GetProperties();
				if (empty($arprops["GOOD"]["VALUE"]))
				{
					return false;
				} else
				{
					return in_array($value, $arprops["GOOD"]["VALUE"]);
				}
			}


		}
	} else
	{
		return false;
	}
}

if (!empty($arResult['ITEMS']))
{
?>
<div class="page__catalog__shop__block">
    <div class="page__catalog__shop__block__items">
		<?  ;foreach ($arResult['ITEMS'] as $key => $item)
		{
			foreach ($item["OFFERS"] as $key2 => $offer)
			{
				$offers[$item["ID"]][] = $offer;
				//echo "<pre>";
				//	print_r($item);
				//echo "</pre>";

			} ?>
            <div class="card shop">
                <div class="card__header">
                    <a href="<?= $item["DETAIL_PAGE_URL"] ?>">
                        <img class="card__img" src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>">
                    </a>
                </div>
                <div class="card__body">
                    <div class="card__body__box">
                        <a href="<?= $item["DETAIL_PAGE_URL"] ?>">
                            <p class="card__title"><?= $item["NAME"] ?></p>
                        </a>
                        <p class="card__text"><?= $item["PREVIEW_TEXT"] ?></p>
                        <div class="card__body__box__group">
                            <p class="text__rating"><?
								$current_rating = ($item["PROPERTIES"]["RATING"]["VALUE"]="")?0:(int)$item["PROPERTIES"]["RATING"]["VALUE"];
								$current_rating_ceil = ceil($current_rating);
								if ($current_rating > $current_rating_ceil + 0.5)
								{
									$current_rating = ceil($current_rating);
								} else if ($current_rating < $current_rating_ceil + 0.5)
								{
									$current_rating = floor($current_rating);
								}
								echo $current_rating; ?>
                            </p>
                            <p class="card__idea__money"><?= $item["MIN_PRICE"]["VALUE"] ?></p>
                        </div>
                        <a class="btn img" data-bs-toggle="modal" data-bs-target="#popUp" href="#"
                           data-id="<?= $item["ID"] ?>">
                            <p class="btn__text">Добавить в корзину</p>
                            <img src="<?= SITE_TEMPLATE_PATH ?>\img\icon\plus-square.svg">
                        </a>
                    </div>
                </div>
                <div class="card__footer">
                    <div class="card__footer__box">
						<? $favor_flag = check__favor($item["ID"]);
						?>

                        <a class="link delete <?=($favor_flag)?"":"d-none"?>" data-id="<?= $item["ID"] ?>">
                                <p>Удалить из избранного</p>
                            <div class="btn__panel favorites">
                                <div class="btn__panel bg__img grey">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/bookmark.svg">
                                </div>
                            </div>
                        </a>
                            <a class="link favor <?=($favor_flag)?"d-none":""?>" data-id="<?= $item["ID"] ?>">

                                <p>В избранное</p>
                            <div class="btn__panel favorites">
                                <div class="btn__panel bg__img grey">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/bookmark.svg">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
			<?
		}
		} ?>

        <div class="modal fade shop " id="popUp" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
             aria-modal="true" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="ModalLabel">Добавить товар в корзину</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var offers =<?echo json_encode($offers, JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR)?>;
    var arparams =<?echo json_encode($arParams, JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR)?>;


    console.log(arparams)
</script>

