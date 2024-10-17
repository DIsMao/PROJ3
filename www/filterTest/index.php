<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости банка");
require ($_SERVER["DOCUMENT_ROOT"]."/local/config/Blocks.php");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/main.css", true);
?>

<main>

    <div class="filter">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            ".default",
            array(
                "COMPONENT_TEMPLATE" => ".default",
                "IBLOCK_TYPE" => "books",
                "IBLOCK_ID" => \Adamcode\Config\Blocks::News->value,
                "SECTION_ID" => "0",
                "SECTION_CODE" => "",
                "FILTER_NAME" => "arrFilter",
                "HIDE_NOT_AVAILABLE" => "Y",
                "TEMPLATE_THEME" => "blue",
                "FILTER_VIEW_MODE" => "horizontal",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "SEF_MODE" => "Y",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "SAVE_IN_SESSION" => "N",
                "INSTANT_RELOAD" => "Y",
                "PAGER_PARAMS_NAME" => "arrPager",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "CONVERT_CURRENCY" => "Y",
                "XML_EXPORT" => "N",
                "SECTION_TITLE" => "-",
                "SECTION_DESCRIPTION" => "-",
                "POPUP_POSITION" => "left",
                "SEF_RULE" => "/filterTest/#SMART_FILTER_PATH#/apply/",
                "SECTION_CODE_PATH" => "",
                "SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
                "CURRENCY_ID" => "RUB",
                "SHOW_ALL_WO_SECTION" => "Y",
                "PREFILTER_NAME" => "smartPreFilter"
            ),
            false
        );

        global $arrFilter;
        print_r($arrFilter);
        ?>
    </div>
    <div class="side">
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "newsList",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "Y",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FILTER_NAME" => "arrFilter",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => \Adamcode\Config\Blocks::News->value,
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "100",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array(
                    0 => "LINK",
                    1 => "OPEN_NEW",
                ),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "COMPONENT_TEMPLATE" => "main_menu_footer",
            )
        );?>
    </div>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>