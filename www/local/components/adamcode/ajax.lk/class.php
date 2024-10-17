<?namespace Prominado\Components;

use Adamcode\Config\Blocks;
use Adamcode\Models\Employee;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Mail\Event;
use CEvent;
use CIBlockElement;
use CModule;


class AjaxLk extends \CBitrixComponent implements Controllerable
{
// Обязательный метод
	public function configureActions(): array
	{
		return [
			'send' => [
				'prefilters' => [] // метод sendAction() будет работать без фильтров
			]
		];
	}

// Ajax-методы должны быть с постфиксом Action
public function LinkAction($mode,$name="",$sort="",$link="", $id=0)
{
	\CModule::IncludeModule("iblock");
	$el = new CIBlockElement;
	global $USER;
	$USERID = $USER->GetID();
	$PROP = array();
	$PROP['LINK'] = $link;
	$PROP['USER_ID'] = $USERID;

	$arLoadProductArray = array(
		"MODIFIED_BY" => $USERID, // элемент изменен текущим пользователем
		"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
		"IBLOCK_ID" => Blocks::Userlinks->value,
		"PROPERTY_VALUES" => $PROP,
		"NAME" => $name,
		"ACTIVE" => "Y",            // активен
		"SORT" => $sort
	);
	if ($mode == "add")
	{
		if ($el->Add($arLoadProductArray))
		{
			// echo "New ID: ".$PRODUCT_ID;
			echo json_encode($el->LAST_ERROR);;
		}
	} elseif ($mode == "update")
	{
		$el->Update($id, $arLoadProductArray);
}
	elseif ($mode == "delete")
	{ CIBlockElement::Delete($id);
	}
	return json_encode("");

}
	public function ModerAboutAction($id,$value)
	{

		CModule::IncludeModule("iblock");

		$el = new CIBlockElement;
		$PROP = array();
		$PROP["EMPLOYEE"] = $id;  // свойству с кодом 12 присваиваем значение "Белый"
		$about = Array(
			"MODIFIED_BY"    => CurrentUser::get()->getId(), // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => Blocks::AboutMe->value,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => "Обо мне ". CurrentUser::get()->getFullName(),
			"ACTIVE"         => "Y",
			"PREVIEW_TEXT"   => $value
		);
		$el->Add($about);

	}
	public function PropertyUpdateAction($id,$mode,$code,$value)
	{ if ($mode=="PROPERTY")
	{
		CModule::IncludeModule("iblock");

		CIBlockElement::SetPropertyValuesEx($id,false,[$code=>$value]);
	}

	}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}