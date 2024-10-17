<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class Rating  extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	public static function iblockId()
	{
		return Blocks::Rating->value;
	}
}