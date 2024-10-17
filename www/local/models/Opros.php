<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;
use Arrilot\BitrixModels\Queries\BaseQuery;
use Bitrix\Main\Engine\CurrentUser;
use CFile;
use CIBlockElement;

class Opros extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	public static function iblockId()
	{
		return Blocks::Opros->value;
	}

}