<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class MediaCategory extends  ElementModel
{
	public static function iblockId()
	{
		return  Blocks::MediaCategories->value;
	}
}