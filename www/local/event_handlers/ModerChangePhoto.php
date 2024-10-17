<?php

namespace Adamcode\EventHandlers;

use Adamcode\Models\Employee;
use Adamcode\Models\ModerationPhoto;
use Adamcode\Models\User;
use Adamcode\Util\CommonUtils;

use CFile;
use CIBlockElement;


class ModerChangePhoto
{
    public static function updatePhoto(&$arFields)
    {
        $res = ModerationPhoto::select(["ID","IBLOCK_ID","PREVIEW_PICTURE", "PROPERTY_STATUS", "PROPERTY_USER"])->filter(["ID" => $arFields["ID"]])->getList()->first();

        $status = CommonUtils::getListOption($res["IBLOCK_ID"], "got")["ID"];

        if (($arFields["IBLOCK_ID"] == $res["IBLOCK_ID"]) && ($res["PROPERTY_STATUS_ENUM_ID"] == $status))
        {
            $user = Employee::select(["ID"])->filter(["PROPERTY_USER" => $res["PROPERTY_USER_VALUE"]])->getList()->first()["ID"];


            $arFile = CFile::MakeFileArray(CFile::GetPath($res["PREVIEW_PICTURE"]));
            file_put_contents("/home/bitrix/www/upload/logs.txt", $user);
            CIBlockElement::SetPropertyValueCode($user, "PHOTO", $arFile);
        }
    }

}