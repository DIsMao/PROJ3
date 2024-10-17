<?php

namespace Adamcode\EventHandlers;

use Adamcode\Models\Employee;
use Adamcode\Models\User;
use Bitrix\Main\Diag\Debug;
use CIBlockElement;

class BindUsers
{
	public static function bind(&$arFields)
	{

		if ($arFields["USER_ID"] != 0)
		{
			$allEmployees = Employee::query()->select(["PROPERTY_EMAIL", "ID"])->getList()->toArray();
			$user = User::getById($arFields["USER_ID"])->toArray();
			foreach ($allEmployees as &$employee)
			{

				if (strtolower($employee["PROPERTY_EMAIL_VALUE"]) == strtolower($user['EMAIL']))
				{
					CIBlockElement::SetPropertyValuesEx($employee["ID"], false, ["USER" => $arFields["USER_ID"]]);
					break; // Break the loop once the matching employee is found
				}
			}
		}
	}

}