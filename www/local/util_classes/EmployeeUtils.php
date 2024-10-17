<?php

namespace Adamcode\Util;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Adamcode\Models\Departament;
use Adamcode\Models\Employee;
use Adamcode\Models\User;
use CFile;
use CIBlockElement;
use CIBlockSection;
use CUser;



class EmployeeUtils
{
	private  int $id;

	/**
	 * @param int $id
	 */
	public function __construct(int $id)
	{
		$this->id = $id;
	}

	public  function get_info($check_by_user=false)
	{
		if ($check_by_user)
		{
			$arFilter = array("PROPERTY_USER"=>$this->id);

		}
		else
		{
			$arFilter = array("ID" => $this->id);

		}
		$emp=Employee::select(["ID", "NAME",'IBLOCK_SECTION_ID','DETAIL_PAGE_URL','PROPERTY_USER','PROPERTY_PHOTO',"PROPERTY_POSITION",'PROPERTY_EMAIL',"PROPERTY_PHONE"])->filter($arFilter)->filter($arFilter)->first();

		if ($check_by_user)
		{
			$arUser = new User($this->id);
		}
		else
		{
			$arUser = new User($emp["PROPERTY_USER_VALUE"]);

		}

		$info_array = array();

		$arUser->load();

		$arUser->refresh();
		$avatar = "";
		if (!empty($emp))
		{
			$info_array['POSITION']=$emp["PROPERTY_POSITION_VALUE"];
			$info_array['EMAIL']=$emp["PROPERTY_EMAIL_VALUE"];
			$info_array['PHONE']=$emp["PROPERTY_PHONE_VALUE"];
			$info_array['ID']=$emp["ID"];
			$name_array=explode(" ", $emp["NAME"]);
			array_pop($name_array);
			$info_array["NAME"] =implode(" ", array_reverse($name_array));
			$rsSection = Departament::query()->filter(["ID" => $emp['IBLOCK_SECTION_ID']])->first();

			$section = $rsSection;
			$info_array['SECTION']=$section;

		}

		if ($check_by_user)
		{
			$info_array["ID"] =$arUser["ID"];
			$info_array["NAME"] =$arUser["NAME"]." ".$arUser["LAST_NAME"];
		}

		if (empty($arUser['PERSONAL_PHOTO'])) {
			$avatar = CFile::GetPath($emp['PROPERTY_PHOTO_VALUE']);
		} else {
			$avatar = CFile::GetPath($arUser['PERSONAL_PHOTO']);
		}
		if (empty($avatar) || $avatar == '')
		{
			$avatar = SITE_TEMPLATE_PATH . '/img/people/no-user-photo.png';
		}
		$info_array["DETAIL_PAGE_URL"]=(!empty($emp["DETAIL_PAGE_URL"])?$emp["DETAIL_PAGE_URL"]:'#');
		$info_array["PHOTO"] = $avatar;



		return $info_array;
	}

}