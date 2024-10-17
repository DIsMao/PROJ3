<?php
namespace Adamcode\EventHandlers;
use Adamcode\Config\Blocks;
use Bitrix\Main\Diag\Debug;
use CIBlockSection;
class GEN_links
{
// создаем обработчик события "OnAfterIBlockSectionAdd"
	public static function update_link(&$arFields)
	{


		if ($arFields["IBLOCK_ID"] == Blocks::Page->value)
		{
			$res = CIBlockSection::GetByID($arFields["ID"]);

			$ar_res = $res->GetNext();

			$link = array("UF_LINK" => $ar_res["SECTION_PAGE_URL"]);
			$GLOBALS["USER_FIELD_MANAGER"]->Update(
				"IBLOCK_".strval(Blocks::Page->value)."_SECTION",
				$arFields["ID"],
				$link
			);


		}
	}
}