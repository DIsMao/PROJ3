<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class NewsCategory extends ElementModel
{
	public static function iblockId()
	{
		return  Blocks::NewsCategories->value;
	}
}