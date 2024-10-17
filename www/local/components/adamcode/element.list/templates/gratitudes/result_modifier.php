<?
	global  $IBIDs;
$new_arr=array();
    foreach ($arResult['ITEMS'] as $key => $arItem)
    {     $arSelect = Array("ID", "IBLOCK_ID", "NAME","DETAIL_PAGE_URL","IBLOCK_SECTION_ID". "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		$arFilter = Array("IBLOCK_ID"=>$IBIDs->Orgstr, "ID"=>$arItem["PROPERTIES"]["ELEMENT"]["VALUE"], "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		while($ob = $res->GetNextElement()){
			$arFields = $ob->GetFields();

			$arProps = $ob->GetProperties();
			$arItem ["PROPERTIES"]["USER"]["VALUE"]=$arProps["USER"]["VALUE"];
				$arItem["DETAIL_PAGE_URL"]=$arFields["DETAIL_PAGE_URL"];

			$res2 = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
			if ($ar_res = $res2->GetNext())
			{
				$arItem["SECTION_PAGE_URL"] = $ar_res['SECTION_PAGE_URL'];
			}
		}

		$arItem['PROPERTIES']["PHOTO"]["VALUE"]="op";
        $new_arr[]=$arItem;
    }
    $arResult['ITEMS']=$new_arr;
