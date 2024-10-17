<?php

namespace Adamcode\EventHandlers;

use Adamcode\Config\Blocks;
use Adamcode\Models\Employee;
use Adamcode\Models\ModerationPhoto;
use Adamcode\Models\User;
use Adamcode\Util\CommonUtils;

use CFile;
use CGroup;
use CIBlockElement;


class createFolderOrgstr
{
    public static function addFolderOrgstr(&$arFields)
    {
//        $res = ModerationPhoto::select(["ID","IBLOCK_ID","PREVIEW_PICTURE", "PROPERTY_STATUS", "PROPERTY_USER"])->filter(["ID" => $arFields["ID"]])->getList()->first();
//
//        $status = CommonUtils::getListOption($res["IBLOCK_ID"], "got")["ID"];

        if (($arFields["IBLOCK_ID"] == Blocks::Orgstr->value))
        {
//            $user = Employee::select(["ID"])->filter(["PROPERTY_USER" => $res["PROPERTY_USER_VALUE"]])->getList()->first()["ID"];
//
//
//            $arFile = CFile::MakeFileArray(CFile::GetPath($res["PREVIEW_PICTURE"]));

//            CIBlockElement::SetPropertyValueCode($user, "PHOTO", $arFile);

            $group = new CGroup;
            $arGroups = Array(
                "ACTIVE"       => "Y",
                "C_SORT"       => 100,
                "DESCRIPTION"  => "",
                "NAME"         => $arFields["NAME"],
                "STRING_ID"      => $arFields["CODE"]
            );
            $NEW_GROUP_ID = $group->Add($arGroups);
//            if (strlen($group->LAST_ERROR)>0) $error = $group->LAST_ERROR;
//            file_put_contents("/home/bitrix/www/upload/logs.txt", $error);
        }
    }

}