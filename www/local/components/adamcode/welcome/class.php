<?php

use Adamcode\Services\StructureService;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Main\Engine\CurrentUser;

class WelcomeComponent extends \CBitrixComponent
{
	public function executeComponent()
	{

		$this->arResult["USER_INFO"]=StructureService::getCurentUserInfo(true);
		$this->includeComponentTemplate();
	}
}