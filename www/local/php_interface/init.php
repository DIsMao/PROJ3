<?

use Bitrix\Main\EventManager;
CModule::IncludeModule('iblock');
require "/home/bitrix/combin/vendor/autoload.php";
//require "/home/bitrix/vendor/PHPWord-master/bootstrap.php";

Arrilot\BitrixModels\ServiceProvider::register();
EventManager::getInstance()->addEventHandler(
    "main",
    "OnAfterUserAdd",
    array(
        "Adamcode\\EventHandlers\\UserAddHandler",
        "UserAdd"
    )
);

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserAddHandler");
function OnAfterUserAddHandler(&$arFields)
{

    if($arFields["ID"] > 0)
    {
        file_put_contents("/home/bitrix/www/upload/logs.txt", $arFields["UF_GROUP"]);
        if($arFields["UF_GROUP"] == 6)  //Если поле UF_BAZA заполнено
        {
            $arGroups = CUser::GetUserGroup($arFields["ID"]);
            $arGroups[] = 6;
            CUser::SetUserGroup($arFields["ID"], $arGroups);
        }else if($arFields["UF_GROUP"] == 7){
                $arGroups = CUser::GetUserGroup($arFields["ID"]);
                $arGroups[] = 7;
                CUser::SetUserGroup($arFields["ID"], $arGroups);
        }
    }
}

