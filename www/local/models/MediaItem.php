<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;
use Bitrix\Main\Engine\CurrentUser;
use CFile;

class MediaItem  extends  ElementModel
{
	public function categories()
{
	return $this->hasMany(MediaCategory::class, "ID","PROPERTY_TAGS_VALUE");
}
	public static function iblockId()
	{
		return  Blocks::Media->value;
	}
	public static $fetchUsing = 'GetNext';

	protected $appends = ['PREVIEW_PICTURE',"LIKES_COUNT","USER_LIKED"];


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