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
use CIBlockSection;


class changeFolderOrgstr
{
    public static function updateFolderOrgstr(&$arFields)
    {
//        $res = ModerationPhoto::select(["ID","IBLOCK_ID","PREVIEW_PICTURE", "PROPERTY_STATUS", "PROPERTY_USER"])->filter(["ID" => $arFields["ID"]])->getList()->first();
//
//        $status = CommonUtils::getListOption($res["IBLOCK_ID"], "got")["ID"];
        $res = CIBlockSection::GetByID($arFields["ID"]);
        if($ar_res = $res->GetNext())
            $old =  $ar_res['CODE'];
        if (($arFields["IBLOCK_ID"] == Blocks::Orgstr->value))
        {
//            $user = Employee::select(["ID"])->filter(["PROPERTY_USER" => $res["PROPERTY_USER_VALUE"]])->getList()->first()["ID"];
//
//
//            $arFile = CFile::MakeFileArray(CFile::GetPath($res["PREVIEW_PICTURE"]));

//            CIBlockElement::SetPropertyValueCode($user, "PHOTO", $arFile);


            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $old));

            $group = new CGroup;
            $arEdit = Array(
                "STRING_ID"       => $arFields["CODE"],
                "ACTIVE"       => $arFields["ACTIVE"],
            );
            $group->Update($rsGroups->Fetch()["ID"], $arEdit);



            file_put_contents("/home/bitrix/www/upload/logs.txt", json_encode($rsGroups->Fetch()));
        }
    }

}