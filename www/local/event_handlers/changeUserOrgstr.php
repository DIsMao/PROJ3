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
use CUser;


class changeUserOrgstr
{
    public static function updateUserOrgstr(&$arFields)
    {
//        $res = ModerationPhoto::select(["ID","IBLOCK_ID","PREVIEW_PICTURE", "PROPERTY_STATUS", "PROPERTY_USER"])->filter(["ID" => $arFields["ID"]])->getList()->first();
//
//        $status = CommonUtils::getListOption($res["IBLOCK_ID"], "got")["ID"];


//        if (($arFields["IBLOCK_ID"] == Blocks::Orgstr->value))
//        {

//$user = Employee::select(["ACTIVE","IBLOCK_SECTION_ID", "PROPERTY_USER"])->filter(["ID" => $arFields["ID"]])->getList()->first();
//$folderId = $user["IBLOCK_SECTION_ID"];
//
//            $userId = $user["PROPERTY_USER_VALUE"];
//            $arGroups = CUser::GetUserGroup($userId);
//
//        $res = CIBlockSection::GetByID($folderId);
//        if($ar_res = $res->GetNext())
//            $code =  $ar_res['CODE'];
//
//            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $code));
//            $groupId = $rsGroups->Fetch()["ID"];
//
//        $my_new_groops = array(3,4,6, $groupId);
//        if(in_array(1, $arGroups)){
//            $my_new_groops = array(1,3,4, $groupId);
//        }else if(in_array(24, $arGroups)){
//            $my_new_groops = array(24, $groupId);
//        }
//            CUser::SetUserGroup($userId, $my_new_groops);
//
//            $rsUser = CUser::GetByID($userId);
//            $arUser = $rsUser->Fetch();
//
//            $Buser = new CUser;
//            $fields = [
//                "ACTIVE" => $user["ACTIVE"]
//            ];
//            if($arUser["ID"] != 1){
//                $Buser->Update($arUser["ID"], $fields);
//            }
//
//
//
//        }
    }

}