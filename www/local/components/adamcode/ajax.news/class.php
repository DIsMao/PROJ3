<?namespace Prominado\Components;

use Adamcode\Config\Blocks;
use Adamcode\Models\Like;
use Bitrix\Main\Engine\Contract\Controllerable;
use CIBlockElement;

class Ajaxnews extends \CBitrixComponent implements Controllerable
{
// Обязательный метод
public function configureActions()
{
// Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
// Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
return [
'sendMessage' => [ // Ajax-метод
'prefilters' => [],
],
];
}

// Ajax-методы должны быть с постфиксом Action
public function likeAction($status,$id)
{\CModule::IncludeModule("iblock");

	global $USER;

	if ($status == "Поставить лайк")
	{
		$el = new \CIBlockElement();
		$PROP = array();
		$PROP['USER_ID'] = $USER->GetID();
		$PROP['OBJ_ID'] = $id;
		$PROP['DATE'] = date('d.m.Y');
		$likeArray = array(
			"MODIFIED_BY" => $USER->GetID(),
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_ID" => Blocks::IdeaLikes->value,
			"PROPERTY_VALUES" => $PROP,
			"NAME" => "Лайк",
			"ACTIVE" => "Y",
		);
		$el->Add($likeArray);

	} elseif ($status == "Убрать лайк")
	{

		$res = Like::query()->filter(array("PROPERTY_USER_ID" => $USER->GetID(), 'PROPERTY_OBJ_ID' => $id))->first();
		CIBlockElement::Delete($res['ID']);
		return "Лайк удален";
	}
}
public  function  subAction()
{

}
public function executeComponent()
{
$this->includeComponentTemplate();
}
}