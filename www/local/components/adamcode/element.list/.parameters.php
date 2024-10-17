<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
Loader::includeModule("iblock");

$arComponentParameters = [
    "PARAMETERS" => [
        "DATA" => [
            "NAME" => "Данные",
            "PARENT" => "BASE",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
            "DESCRIPTION" => "Массив данных",
        ],
        "ADIT" => [
            "NAME" => "Доп Данные",
            "PARENT" => "BASE",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
            "DESCRIPTION" => "Массив данных",
        ],
        "PAGINATION" => [
            "NAME" => "Использовать пагинацию",
            "PARENT" => "BASE",
            "TYPE" => "CHECKBOX",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
            "DESCRIPTION" => "Использовать пагинацию",
        ],
        "ITEM_COUNT" => [
            "NAME" => "Количество элементов",
            "PARENT" => "BASE",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
            "DESCRIPTION" => "Количество  элементов на странице",
        ],
    ],
];
CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    "", //$pager_title
    true, //$bDescNumbering
    true, //$bShowAllParam
    true, //$bBaseLink
    "Y" //$bBaseLinkEnabled
);

?>