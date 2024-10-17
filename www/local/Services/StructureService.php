<?php

namespace Adamcode\Services;
use Adamcode\Config\Blocks;
use Adamcode\Models\Departament;
use Adamcode\Models\Employee;
use Adamcode\Models\UserLinks;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Type\Date;
use CIBlockSection;

class   StructureService
{

//	public static function getEmployee($filter=[], $select=[])
//	{
//		$users = [];
//		$arFilter_users = array("IBLOCK_ID" => $IBIDs->Orgstr, "!PROPERTY_USER" => false, "ACTIVE" => "Y");
//		$i = 0;
//		$res_users = Employee::filter($filter)->select($select)->getList()->toArray();
//
//		{
//			$users[$i]["name"] = $fields["NAME"] . "," . $props["IPN"]["VALUE"];
//			$users[$i]["id"] = $props["USER"]["VALUE"];
//			$users[$i]["email"] = $props["EMAIL"]["VALUE"];
//
//		}
//		return array_values($res_users);

	public static function findRoot()
	{
		$root = Departament::select(["ID"])->filter(["DEPTH_LEVEL" => 1])->first();
		return $root["ID"];
	}

	public  static function getDepHead($depid=null, $head_id=null,$check_by_position=false)
	{
		if ($check_by_position)
		{
			$head = Employee::query()->filter(["IBLOCK_ID" => Blocks::Orgstr->value,"PROPERTY_TABEL"=>117])->first();
		}
		else
		{
			$head = Employee::query()->filter([["IBLOCK_ID" => Blocks::Orgstr->value],
			[
				"LOGIC" => "OR",
				["PROPERTY_GUID_EMPLOY" => $head_id],
				["PROPERTY_HEAD" => "Y", "IBLOCK_SECTION_ID" => $depid]]])->first();}

		if (!empty($head))
		{
			$headArr = $head->toArray();
			$headUser = new EmployeeUtils($headArr["ID"]);
			$headArr["USER"] = $headUser->get_info();
			return $headArr;
		} else
		{
			return [];
		}


	}

	public function getSubsections($depid)
	{
		$section = Departament::query()->filter(["SECTION_ID" => $depid])->getList();
		if (!empty($section))
		{
			$sectionAr = $section->toArray();
			$sectionAr["HEAD"] = self::getDepHead($depid, $sectionAr["UF_HEADER"]);
			return $sectionAr;
		} else
		{
			return [];
		}
	}

	public function getSectionElements($depid, $head)
	{
		return Employee::query()->sort(array("SORT" => "asc"))->filter(["SECTION_ID" => $depid, "!ID" => $head])->getList()->toArray();


	}

	public static function PrepareSectionThree()
	{
		$arFilter = array(
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => Blocks::Orgstr->value

		);
		$arSelect = array('IBLOCK_ID', 'ID', 'NAME', "SECTION_PAGE_URL", 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID');
		$arOrder = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
		$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
		$sectionLinc = array();
		$Result['ROOT'] = array();
		$sectionLinc[0] = &$Result['ROOT'];
		$I = 0;
		while ($arSection = $rsSections->GetNext())
		{
			$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
			$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
		}
		return $Result;
	}

	public static function printSectionTree($array)
	{
		global $APPLICATION;
		echo "<ul class='two__tier__list'>\n";
		foreach ($array as $key => $value)
		{
			echo "<li>\n";
			if (($APPLICATION->GetCurDir() == $value['SECTION_PAGE_URL']) && (isset($value['CHILD'])))
			{
				echo "<p class='link active parent'>";
			} elseif ($APPLICATION->GetCurDir() == $value['SECTION_PAGE_URL'])
			{
				echo "<p class='link active'>";
			} elseif (isset($value['CHILD']))
			{
				echo "<p class='link  parent'>";
			} else
			{
				echo "<p class='link'>";

			}


			echo "<a href='" . $value['SECTION_PAGE_URL'] . "' class='link__title'>" . $value['NAME'] . "</a>\n";
			echo "<img class='link__img' src='/local/templates/moskvich/img/icon/arrow-right-circle.svg'>\n";

			echo "</p>\n";
			if (isset($value['CHILD']))
			{
				echo "<ul class='two__tier__list__col'>\n";
				self::printSectionTree($value['CHILD']);
				echo "</ul>\n";
			}
			echo "</li>\n";
		}
		echo "</ul>\n";
	}

	public static function getCurentUserInfo($select = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "IBLOCK_SECTION_ID", "PROPERTY_*"))
	{
		$arFilter = array( "ACTIVE" => "Y", "PROPERTY_USER" => CurrentUser::get()->getId());
		$emp = Employee::select($select)->filter($arFilter)->first();
		if (!empty($emp))

		{	$emp=$emp->toArray();
			$emp["PHOTO"] = (new EmployeeUtils($emp["ID"]))->get_info()["PHOTO"];


			$emp["EMPLOYEE_NAME"]=$emp["NAME"];

//			$emp["NAME"] =  CurrentUser::get()->getFullName();
		}
		else
		{
			$emp["EMPLOYEE_NAME"] =  CurrentUser::get()->getFullName();
				$emp["PHOTO"] = (new EmployeeUtils(0))->get_info()["PHOTO"];
//			$emp["NAME"] =  CurrentUser::get()->getFullName();

		}
		return $emp;
	}

	public static function getColleague($section_id, $id)
	{
		$colleagu_users = array();
		$colleagues = Employee::filter(["SECTION_ID" => $section_id, "!ID" => $id])->active()->limit(5)->getList()->toArray();;
		if (!empty($colleagues))
		{
			foreach ($colleagues as $colleague)
			{
				$colleagu_users[] = (new EmployeeUtils($colleague["ID"]))->get_info();
			}
		}
		return $colleagu_users;
	}

	public static function getSectionInfo($id, $select = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "IBLOCK_SECTION_ID", "SECTION_PAGE_URL","UF_*"))
	{
		$arFilter = array("ID" => $id);
		$departament = Departament::select($select)->filter($arFilter)->first()->toArray();
		return $departament;
	}
	public static function getHBPR($ipn)
	{
		$hbpr = Employee::filter(["ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_IPN" =>$ipn])->select(["NAME", "DETAIL_PAGE_URL"])->first();
	if (!empty($hbpr))
	{
		return $hbpr;

	}
	}
	public static  function getUserLinks()
	{
	 return	UserLinks::filter(['ACTIVE' => 'Y', 'PROPERTY_USER_ID' => CurrentUser::get()->getId() ])->sort(["SORT"=>"asc"])->select(["ID","NAME","PROPERTY_LINK"])->getList()->toArray();
	}
public static function getReplacer($id)
{
	$replacerEmployee = Employee::filter([ "PROPERTY_IPN" =>$id])->active()->select(["ID"])->first();
	if (!empty($replacerEmployee))
	{
		return new EmployeeUtils($replacerEmployee["ID"]);

	}
}
}