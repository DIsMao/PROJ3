<?php
namespace Adamcode\Models;
use Adamcode\Config\Blocks;
use Adamcode\Services\StructureService;
use Arrilot\BitrixModels\Models\UserModel;
use Bitrix\Highloadblock\HighloadBlockTable;

class User  extends UserModel

{
    public static function current()
    {
        $arItems = [];
        $curUser=StructureService::getCurentUserInfo(true);
        $arItems["CURUSER"] = $curUser;
        \Bitrix\Main\Loader::includeModule("highloadblock");
        $arHLBlock = HighloadBlockTable::getById(Blocks::Subscribers->value)->fetch();
        $obEntity = HighloadBlockTable::compileEntity($arHLBlock);
        $strEntityDataClass = $obEntity->getDataClass();
//Получение записи из таблицы==================================================================================================

        $rsData = $strEntityDataClass::getList(array(

            'select' => array('ID', 'UF_EMAIL'),
            'filter' => array('=UF_EMAIL' => $curUser["PROPERTY_EMAIL_VALUE"])
        ));
        while ($arItem = $rsData->Fetch()) {
            $arItems["EMAIL"] = $arItem;
        }

        return $arItems;
    }
}
?>