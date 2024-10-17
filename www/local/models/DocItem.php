<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class DocItem extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	public static function iblockId()
	{
		return Blocks::Docs->value;
	}
}