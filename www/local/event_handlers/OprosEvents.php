<?php

namespace Adamcode\EventHandlers;

use Adamcode\Config\Blocks;
use Adamcode\Config\Misc;
use Bitrix\Main\Diag\Debug;
use CFile;
use CIBlockElement;
use CModule;
use CVote;

class OprosEvents
{
	public static function onAfterVoteAdd($id, $fields)
	{
		CModule::IncludeModule("iblock");
		$el = new CIBlockElement;
		$db_res = CVote::GetList(array(), array(), array("CHANNEL_ID" => Misc::Opros_group->value, "TITLE" => $fields["TITLE"]), true);
		if ($res = $db_res->Fetch())
		{
			$arLoadVoteArray = array(
				"NAME" => $fields["TITLE"],
				"IBLOCK_SECTION_ID" => false,
				"IBLOCK_ID" => Blocks::Opros->value,
				"DETAIL_TEXT" => "#VOTE_ID_" . $res["ID"] . "#",
				"PREVIEW_PICTURE" => CFile::MakeFileArray($res['IMAGE_ID']),
				"PROPERTY_VALUES" => array("DATE_TO" => $res["DATE_END"], "DATE_FROM" => $res["DATE_START"]));
			$el->Add($arLoadVoteArray);
			Debug::writeToFile(array('ID' => $id, 'fields' => $arLoadVoteArray), "", "prices.txt");

		}
	}


	public static function onAfterVoteUpdate($id, $fields)
	{
		CModule::IncludeModule("iblock");
		$id_vote = "";
		$el = new CIBlockElement;
		$arFilter = array("IBLOCK_ID" => Blocks::Opros->value, "DETAIL_TEXT" => "#VOTE_ID_" . $id . "#", "ACTIVE" => "Y");
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID"));
		while ($ob = $res->GetNext())
		{
			$id_vote = $ob["ID"];
		}
		$opros = CVote::GetByID($id);
		if ($vote = $opros->GetNext())
		{
			$arLoadVoteArray = array(
				"NAME" => $fields["TITLE"],
				"IBLOCK_SECTION_ID" => false,
				"IBLOCK_ID" => Blocks::Opros->value,
				"DETAIL_TEXT" => "#VOTE_ID_" . $id . "#",
				"PREVIEW_PICTURE" => CFile::MakeFileArray($vote['IMAGE_ID']),
			);
			$el->Update($id_vote, $arLoadVoteArray);
			CIBlockElement::SetPropertyValuesEx($id_vote, Blocks::Opros->value, array("DATE_TO" => $vote["DATE_END"], "DATE_FROM" => $vote["DATE_START"],));
			Debug::writeToFile(array('ID' => $id, 'fields' => $arLoadVoteArray), "", "prices.txt");
		}


	}

	public static function onAfterVoteDelete($id)
	{
		CModule::IncludeModule("iblock");
		$id_vote = "";
		$el = new CIBlockElement;
		$arFilter = array("IBLOCK_ID" => Blocks::Opros->value, "DETAIL_TEXT" => "#VOTE_ID_" . $id . "#", "ACTIVE" => "Y");

		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID"));
		while ($ob = $res->GetNext())
		{
			$id_vote = $ob["ID"];
		}

		$el->Delete($id_vote);
	}
}