<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Adamcode\Services\StructureService;
use Arrilot\BitrixModels\Models\ElementModel;
class AboutMe extends ElementModel
{
	public static function iblockId()
	{
		return  Blocks::AboutMe->value;
	}

}