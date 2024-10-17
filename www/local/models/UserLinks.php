<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class UserLinks extends ElementModel
{
	public static function iblockId()
	{
		return  Blocks::Userlinks->value;
	}
}