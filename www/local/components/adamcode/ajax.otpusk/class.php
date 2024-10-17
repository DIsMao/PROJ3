<?namespace Prominado\Components;


use Bitrix\Main\Engine\Contract\Controllerable;

use CIBlockElement;

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
public function otpuskAction($datepicker,$id,$subst)
{
$PROP=[];
$PROP["OTPUSK_START"]=explode("- ",$datepicker)[0];
$PROP["OTPUSK_END"]=explode("- ",$datepicker)[1];
	$PROP["SUBST"]=$subst;

echo "<pre>"; print_r($datepicker); echo "</pre>";
CIBlockElement::SetPropertyValuesEx($id,false,$PROP);
//LocalRedirect("/user_profile/index.php");

}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}