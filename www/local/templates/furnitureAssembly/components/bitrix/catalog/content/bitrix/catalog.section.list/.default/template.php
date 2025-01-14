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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?><?
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	?>
<!--		--><?// $arResult['SECTION']["DESCRIPTION"] = str_replace('&nbsp;', '',  $arResult['SECTION']["DESCRIPTION"]);



        global $IBIDs;



        $editLink = "/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=" . $arParams["IBLOCK_ID"] . "&type=" . $arResult['SECTION']['IBLOCK_TYPE_ID'] . "&ID=" . $arResult['SECTION']['ID'];
        $APPLICATION->IncludeComponent(
            "sprint.editor:blocks",
            "myEditor",
            [
                "SECTION_ID" => $arResult['SECTION']['ID'],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "PROPERTY_CODE" => "UF_SPRINT",
                "USE_JQUERY" => "N",
                "USE_FANCYBOX" => "N",
                'SHOW_AREAS' => 'Y',
                'editLink' => "$editLink",
            ],
            $component,
            [
                "HIDE_ICONS" => "N",
            ]
        );




        echo $arResult['SECTION']["DESCRIPTION"]?>



	<?

}
?>