<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;
use Bitrix\Main\Engine\CurrentUser;

class Event extends ElementModel
{
	public static $fetchUsing = 'GetNext';

	protected $appends = ['PREVIEW_PICTURE', "LIKES_COUNT", "USER_LIKED"];

	public function categories()
	{
		return $this->hasMany(EventCategory::class, "ID", "PROPERTY_CATEGORY_VALUE");
	}
	public function subbed()
	{
		return $this->hasMany(User::class, "ID", "PROPERTY_SUBBED_VALUE");
	}
	public static function iblockId()
	{
		return Blocks::Event->value;
	}


	public function getLikesCountAttribute(): int
	{
		return Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_OBJ_ID' => $this['ID']))->count();

	}

	public function getUserLikedAttribute(): ?string
	{
		$likeUser = Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_OBJ_ID' => $this['ID'], 'PROPERTY_USER_ID' => CurrentUser::get()->getId()))->count();
		return ($likeUser !== 0);
	}
}