<?php
namespace Adamcode\Services;

use Adamcode\Models\MenuItems;
use Adamcode\Models\MenuSections;

class  MenuService
{
	public static function getItems()
	{

		$Sections = MenuSections::select(['NAME','UF_LINK'])->sort(["SORT" => "ASC"])->filter(['ACTIVE' => 'Y',"MIN_PERMISSION" => "R","CHECK_PERMISSIONS" => "Y"])->getList()->toArray();
		$elements = MenuItems::query()->filter(['ACTIVE' => 'Y',"MIN_PERMISSION" => "R","CHECK_PERMISSIONS" => "Y"])->getList()->toArray();
		$newArr = array();
		foreach ($Sections as $section)
		{
			$newArr[$section['ID']] = $section;
			foreach ($elements as  $element)
			{
				if ($section["ID"] == $element['IBLOCK_SECTION_ID'])
				{
					$newArr[$section["ID"]]['ELEMENTS'][$element['PROPERTIES_GROUP_VALUE']][] = $element;
				}
			}
		}
		return $newArr;
	}
}