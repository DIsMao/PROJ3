<?php

namespace Adamcode\Services;

use Adamcode\Models\Opros;

class OprosService
{
	public static function getCurrentActiveOpros(): int
	{
		$activeOpros= Opros::query()->select(["DETAIL_TEXT","PROPERTY_SHOW_ON_MAIN","ID","PROPERTY_DATE_TO"])->filter(["!PROPERTY_SHOW_ON_MAIN"=>false,">=PROPERTY_DATE_TO"=>date('Y-m-d H:i:s')])->sort('TIMESTAMP_X', 'DESC')->first();
		return (int)substr(explode("_", $activeOpros["DETAIL_TEXT"])[2], 0, -1);
	}
}