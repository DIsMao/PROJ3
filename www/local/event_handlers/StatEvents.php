<?php

namespace Adamcode\EventHandlers;
use Arrilot\BitrixIblockHelper\HLblock;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
class StatEvents
{
	public static function addStat()
	{
//        file_put_contents("/home/bitrix/www/upload/logs.txt", "test12312312312");

		global $USER, $APPLICATION;
		$dir = $APPLICATION->GetCurPage();
		if ($USER->IsAuthorized())
		{
			if ((strripos($dir, 'statistics') === false) && (strripos($dir, 'auth') === false)&& (strripos($dir, '/bitrix/admin') === false))
			{
                \Bitrix\Main\Loader::includeModule("highloadblock");
//                file_put_contents("/home/bitrix/www/upload/logs.txt", "test111111111111111111");
                $arHLBlock = HighloadBlockTable::getById(3)->fetch();
//                file_put_contents("/home/bitrix/www/upload/logs.txt", "1");

                $obEntity = HighloadBlockTable::compileEntity($arHLBlock);


				$strEntityDataClass = $obEntity->getDataClass();
				$arElementFields = array(
					'UF_LINK_NAME' =>  $APPLICATION->GetTitle(),
					'UF_URL' => $APPLICATION->GetCurPage(),
					'UF_USER' => $USER->GetID(),
                    'UF_DATE' => date("d.m.Y H:i:s")

				);

				  $RES = $strEntityDataClass::add($arElementFields);


			}
		}
	}

}