<?
namespace Prominado\Components;

use Adamcode\Models\Employee;

use Bitrix\Main\Engine\Contract\Controllerable;
use CFile;

\Bitrix\Main\Loader::includeModule("highloadblock");
class AjaxsearchUsers extends \CBitrixComponent implements Controllerable
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
public function searchUsersAction($name)
{
    \Bitrix\Main\Loader::includeModule("iblock");
    $users = Employee::select(["NAME","PROPERTY_PHOTO"])->filter(array("?NAME" => $name))->getList();
    foreach ($users as $key => &$item){
        if($item["PROPERTY_PHOTO_VALUE"] != ""){
            $item["PROPERTY_PHOTO_VALUE"] = CFile::GetPath($item["PROPERTY_PHOTO_VALUE"]);
        }else{
            unset($users[$key]);
        }

    }

return $users;

}

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

}