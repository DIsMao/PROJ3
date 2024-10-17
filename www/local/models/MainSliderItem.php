<?php

namespace Adamcode\models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;
use Arrilot\BitrixModels\Queries\BaseQuery;
use Bitrix\Main\Engine\CurrentUser;
use CFile;
use CIBlockElement;

class MainSliderItem extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	protected $appends = ['PREVIEW_PICTURE',"LIKES_COUNT","USER_LIKED"];

	public static function iblockId()
	{
		return Blocks::SiderMain->value;
	}

	public function getpreviewPictureAttribute($value): ?string
	{
		return CFile::GetPath($value);
	}


}