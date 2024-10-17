<?
namespace Prominado\Components;

use Bitrix\Highloadblock\HighloadBlockTable;
use Adamcode\Config\Blocks;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
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
public function subscribersAction($email)
{
    $arItems = [];
    \Bitrix\Main\Loader::includeModule("highloadblock");
    $arHLBlock = HighloadBlockTable::getById(Blocks::Subscribers->value)->fetch();
    $obEntity = HighloadBlockTable::compileEntity($arHLBlock);
    $strEntityDataClass = $obEntity->getDataClass();
//Получение записи из таблицы==================================================================================================

    $rsData = $strEntityDataClass::getList(array(

        'select' => array('ID', 'UF_EMAIL'),
        'filter' => array('=UF_EMAIL' => $email)
    ));
    while ($arItem = $rsData->Fetch()) {
        $arItems = $arItem;
    }
    if($arItems["UF_EMAIL"] == $email){
        //Удаление из таблицы==================================================================================================
        $result = $strEntityDataClass::Delete($arItems["ID"]);
    }else{
        //Добавление в таблицу==================================================================================================

    $arElementFields = array(
        'UF_EMAIL' => $email,

    );
    $obResult = $strEntityDataClass::add($arElementFields);

    $ID = $obResult->getID();
    $result = $obResult->isSuccess();
    }
return $result;

}

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

}