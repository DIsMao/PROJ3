<?php

namespace Adamcode\Util;

use CIBlockPropertyEnum;

class CommonUtils
{ public  static function getkey($array, $key, $searchBy, $getkey = 'ID')
{
	$matches = [];
	foreach ($array as $subArray)
	{
		if (isset($subArray[$key]) && $subArray[$key] == $searchBy)
		{
			$matches[] = $subArray[$getkey];
		}
}

if (empty($matches)) {
	return null;
}

return count($matches) > 1 ? $matches : $matches[0]; // Return the array if multiple matches, or the single match if only one
}


    public  static function getListOption($iblockid, $xml_id, $code = null)
    {
        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblockid, "XML_ID"=>$xml_id));
        if($enum_fields = $property_enums->GetNext());


        return $enum_fields; // Return the array if multiple matches, or the single match if only one
    }

}