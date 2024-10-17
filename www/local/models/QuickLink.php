<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;


class QuickLink extends ElementModel
{
	public static function iblockId()
	{
		return  Blocks::QuickLink->value;
	}
}