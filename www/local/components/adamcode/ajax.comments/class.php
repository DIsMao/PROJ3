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
public function commentAction($parent,$text="",$objID="")
{
	\CModule::IncludeModule("iblock");
	$el = new CIBlockElement;
	global $USER;
	$USERID = $USER->GetID();
	$PROP = array();
	$PROP['OBJ_ID'] = $objID;
	$PROP['USER'] = $USERID;
	$PROP['PARENT_OBJ'] = $parent;

	$arLoadProductArray = array(
		"MODIFIED_BY" => $USERID, // элемент изменен текущим пользователем
		"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
		"IBLOCK_ID" => Blocks::Comment->value,
		"DETAIL_TEXT" => $text,
		"PROPERTY_VALUES" => $PROP,
		"NAME" => "Комментарий",
		"ACTIVE" => "Y",            // активен
	);

		if ($el->Add($arLoadProductArray))
		{
			// echo "New ID: ".$PRODUCT_ID;
			echo json_encode($el->LAST_ERROR);;
		}
	return json_encode("Комментарий добавлен");

}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}