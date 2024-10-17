<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class EventCategory extends ElementModel
{
	public static function iblockId()
	{
		return  Blocks::EventCategories->value;
	}
}