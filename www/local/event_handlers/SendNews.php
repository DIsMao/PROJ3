<?php

namespace Adamcode\EventHandlers;

use Adamcode\Config\Blocks;
use Adamcode\Models\Employee;
use Adamcode\Models\NewsItem;
use Adamcode\Models\User;
use Adamcode\Util\CommonUtils;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Mail\Event;
use CFile;
use CIBlockElement;


class SendNews
{
    public static function SendNews(&$arFields)
    {
        $res = NewsItem::select(["ID","IBLOCK_ID","DETAIL_TEXT", "PROPERTY_SEND_SUBS", "PROPERTY_SEND_ALL"])->filter(["ID" => $arFields["ID"]])->getList()->first();

        $statusSub = CommonUtils::getListOption($res["IBLOCK_ID"], "subsYes")["ID"];

        if (($arFields["IBLOCK_ID"] == $res["IBLOCK_ID"]) && ($res["PROPERTY_SEND_SUBS_ENUM_ID"] == $statusSub))
        {
            $forLog = "";
            $arItems = [];
            \CModule::IncludeModule("iblock");
            \Bitrix\Main\Loader::includeModule("highloadblock");
            $arHLBlock = HighloadBlockTable::getById(Blocks::Subscribers->value)->fetch();
            $obEntity = HighloadBlockTable::compileEntity($arHLBlock);
            $strEntityDataClass = $obEntity->getDataClass();
//Получение записи из таблицы==================================================================================================

            $rsData = $strEntityDataClass::getList(array(

                'select' => array('ID', 'UF_EMAIL')
            ));
            while ($arItem = $rsData->Fetch()) {
                $forLog = $forLog . $arItem["UF_EMAIL"] . ", ";
                $arEventField = array(
                    "EMAIL_TO" => $arItem["UF_EMAIL"],
                    "MSG" => $res["DETAIL_TEXT"],
                );

//                Event::send(array(
//                    "EVENT_NAME" => "NEW_NEWS",
//                    "LID" => "s1",
//                    "C_FIELDS" => $arEventField
//                ));
            }

            file_put_contents("/home/bitrix/www/upload/logs.txt",$forLog);
        }
    }

}