<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;
use Arrilot\BitrixModels\Queries\BaseQuery;
use Bitrix\Main\Engine\CurrentUser;
use CFile;
use CIBlockElement;

class NewsItem extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	protected $appends = ['PREVIEW_PICTURE',"LIKES_COUNT","USER_LIKED"];
	public function categories()
	{
		return $this->hasMany(NewsCategory::class, "ID","PROPERTY_CATEGORY_VALUE");
	}
	public static function iblockId()
	{
		return Blocks::News->value;
	}

	public function getpreviewPictureAttribute($value): ?string
	{
		return CFile::GetPath($value);
	}
	public function getLikesCountAttribute(): int
	{ return  Like::query()->filter(array( "ACTIVE" => "Y", 'PROPERTY_OBJ_ID' => $this['ID']))->count();

	}
	public function getUserLikedAttribute(): ?string
	{
		$likeUser=Like::query()->filter(array( "ACTIVE" => "Y", 'PROPERTY_OBJ_ID' => $this['ID'], 'PROPERTY_USER_ID' => CurrentUser::get()->getId()))->count();
		return  ($likeUser!==0);
	}
}