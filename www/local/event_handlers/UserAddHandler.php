<?php

namespace Adamcode\EventHandlers;


use Adamcode\Config\Groups;
use CUser;

class UserAddHandler
{
	public  static function UserAdd( &$arFields)

	{
        if($arFields["ID"] > 0)
        {
            file_put_contents("/home/bitrix/www/upload/logs.txt", "true");
            if($arFields["UF_GROUP"] == Groups::ASSEMBLERS->value)  //Если поле UF_BAZA заполнено
            {
                $arGroups = CUser::GetUserGroup($arFields["ID"]);
                $arGroups[] = Groups::ASSEMBLERS->value;
                CUser::SetUserGroup($arFields["ID"], $arGroups);
            }else if($arFields["UF_GROUP"] == Groups::CUSTOMERS->value){
                $arGroups = CUser::GetUserGroup($arFields["ID"]);
                $arGroups[] = Groups::CUSTOMERS->value;
                CUser::SetUserGroup($arFields["ID"], $arGroups);
            }
        }
	}
}