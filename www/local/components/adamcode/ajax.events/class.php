<?namespace Prominado\Components;

use Adamcode\Config\Blocks;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use CIBlockElement;
use CModule;
use CUser;


class Ajaxbirth extends \CBitrixComponent implements Controllerable
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
public function subAction($id,$status)
{
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetProperty(Blocks::Event->value, $id, "sort", "asc", array("CODE" => "SUBBED"));
	while ($ob = $res->GetNext())
	{
		$fields[] = $ob['VALUE'];
	}
	$rsUser = CUser::GetByID(CurrentUser::get()->getId());

	if ($status=="Учавствую")
	{
		$fields[]= CurrentUser::get()->getId();
	}
	else
	{
		$fields=array_diff($fields ,array(CurrentUser::get()->getId())); // removing 401 returns [312, 15, 3]

	}
	if (empty($fields))
	{
		$fields=false;
	}
	CIBlockElement::SetPropertyValuesEx($id,Blocks::Event->value, array("SUBBED"=>$fields) );
	return json_encode($fields);


}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}