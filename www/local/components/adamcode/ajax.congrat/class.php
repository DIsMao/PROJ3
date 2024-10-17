<?namespace Prominado\Components;

use Adamcode\Models\Employee;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Mail\Event;
use CEvent;
use CIBlockElement;


class AjaxCongrat extends \CBitrixComponent implements Controllerable
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
public function congratAction($email,$position,$msg,$fio,$bal,$new_emp)
{
	$name = CurrentUser::get()->getFullName();
	$user_to = "";
	$res = Employee::select(["ID","PROPERTY_USER","PROPERTY_EMAIL"])->filter(["PROPERTY_EMAIL" => $email])->getList()->first();
		$user_to = $res["PROPERTY_USER_VALUE"];
    $id = $res["ID"];

	$arEventField = array(
		"EMAIL_TO" => $email,// - здесь email - это <input type="email" name="email" placeholder="E-mail" value="" required>
		"MSG" => $msg,// - здесь textarea - это <input type="text" name="textarea" placeholder="Текст сообщения" value="">
		"USER_NAME" => $name,
		"EMPLOY" => $fio,
		"BAL" => $bal,
		"USER" => $user_to,
		"POSITION" => $position,// - здесь textarea - это <input type="text" name="textarea" placeholder="Текст сообщения" value="">
		"SENDER" => CurrentUser::get()->getId()
	);
	if ($new_emp !== "Y")
	{
		Event::send(array(
			"EVENT_NAME" => "EMPLOY",
			"LID" => "s1",
			'MESSAGE_ID' => 93,
			"C_FIELDS" => $arEventField
		));
	} else
	{
		Event::send(array(
			"EVENT_NAME" => "EMPLOY",
			"LID" => "s1",
			'MESSAGE_ID' => 94,
			"C_FIELDS" => $arEventField
		));

	}

	return json_encode($arEventField);

}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}