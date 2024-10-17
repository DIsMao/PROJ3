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

class deleteFolderOrgstr
{
    public static function delFolderOrgstr(&$arFields)
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


            $strError = "";
            $DB = array();
            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $arFields["CODE"]));
            $del_id = $rsGroups->Fetch()["ID"];
            file_put_contents("/home/bitrix/www/upload/logs.txt", $rsGroups->Fetch()["ID"]);
            if($del_id>11)
            {

            $group = new CGroup;
            $group->Delete($del_id);

            }

        }
    }

}