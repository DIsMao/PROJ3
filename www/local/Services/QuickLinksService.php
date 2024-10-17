<?php

namespace Adamcode\Services;

use Adamcode\Models\QuickLink;

class QuickLinksService
{
	public  static  function findItems($filter=[])
	{
		$linksCollection=QuickLink::query()->active()->select(["CODE","NAME","PROPERTY_ICON","PROPERTY_LINK","PREVIEW_PICTURE"])->filter($filter);

			$linksCollection=$linksCollection->getList()->toArray();

		return $linksCollection;
	}
}