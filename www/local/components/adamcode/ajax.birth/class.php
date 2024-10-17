<?namespace Prominado\Components;

use Adamcode\Models\Employee;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Mail\Event;
use CEvent;
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

public function birthAction($email,$msg,$fio,$bal)
{
    \CModule::IncludeModule("iblock");
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
        "USER" => $user_to,
        "FROM" => ( new EmployeeUtils(CurrentUser::get()->getId()))->get_info(true)["NAME"]
    );
	Event::send(array(
		"EVENT_NAME" => "BIRTHDAYS_MSG",
		"LID" => "s1",
		"C_FIELDS" => $arEventField
	));

        setcookie('brthSendMails[' . $id . ']', 'true', strtotime('+30 days'), "/");

	return json_encode($arEventField,JSON_UNESCAPED_UNICODE);

}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}