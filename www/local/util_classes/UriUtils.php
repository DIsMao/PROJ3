<?php
namespace Adamcode\Util;
use Bitrix\Main\Web\Uri;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
class  UriUtils
{
	 public  static  function updateUrl($request, $params)
	{
		$uri = new Uri($request->getRequestUri());

		$addParams = [];
		$deleteParams = [];

		foreach ($params as $key => $value)
		{
			if (is_int($key))
			{
				$deleteParams[] = $value;
			} else
			{
				$addParams[$key] = $value;
			}
		}

		$uri->addParams($addParams);

		$uri->deleteParams($deleteParams);

		return $uri->getUri();
	}
}