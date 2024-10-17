<?
namespace Prominado\Components;
use Adamcode\Models\Employee;
use Adamcode\Config\Blocks;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use CIBlockElement;

\Bitrix\Main\Loader::includeModule("highloadblock");
class AjaxSubscribers extends \CBitrixComponent implements Controllerable
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
public function gratitudesAction($forName, $for, $text)
{
    \CModule::IncludeModule("iblock");
    global $USER;
    $res = Employee::select(["ID"])->filter(["PROPERTY_USER" => $USER->GetID()])->getList()->first();
    $user_from = $res["ID"];

        $rsElement = new CIBlockElement;
        $arFields = array(
            "ACTIVE" => "Y",
            "NAME" => $forName,
            "IBLOCK_ID" => Blocks::Gratitudes->value,
            "PROPERTY_VALUES" => array(
                "FOR" => $for,
                "FROM" => $user_from,
                "GRATITUDES" => $text,
                "DATE_TIME" => date("Y-m-d H:i:s"),

            )
        );
        $rsElement->Add($arFields);



}

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

}