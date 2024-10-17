<?php

namespace Adamcode\EventHandlers;

 use Adamcode\Models\AboutMe;
 use Bitrix\Main\Diag\Debug as Debug;
use Adamcode\Config\Blocks;

class AboutMeEvents
{
	public  static function OnApply( &$arFields)

	{
		// Сохраняем текущее значение свойства в глобальную переменную или в базе данных
		if ( $arFields["IBLOCK_ID"]==Blocks::AboutMe->value)
		{			$about = AboutMe::filter(["ID"=>$arFields["ID"]])->select(["PROPERTY_ALLOW","PROPERTY_EMPLOYEE","ID"])->first()->toArray();
			if ($about["PROPERTY_ALLOW_VALUE"]=="Y")
			{
				\CModule::IncludeModule("iblock");
				\CIBlockElement::SetPropertyValuesEx($about["PROPERTY_EMPLOYEE_VALUE"],false,["ABOUT_ME"=>$arFields["PREVIEW_TEXT"]]);

			}
		}
	}
}