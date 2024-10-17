<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\SectionModel;

class MenuSections extends  SectionModel
{
	public static function iblockId()
	{
		return  Blocks::Menu->value;
	}
}
