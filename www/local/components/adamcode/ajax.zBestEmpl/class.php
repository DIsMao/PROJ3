<?namespace Prominado\Components;

use Adamcode\Config\Blocks;
use Adamcode\Models\Employee;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Mail\Event;
use CEvent;
use CFile;
use CIBlockElement;
use ZipArchive;


class AjaxzzBestEmpl extends \CBitrixComponent implements Controllerable
{

public function configureActions()
{

return [
'sendMessage' => [
'prefilters' => [],
],
];
}

// Ajax-методы должны быть с постфиксом Action

public function zBestEmplAction($group,$FIO,$doljn,$desc,$photo,$fio_zayav)
{
    \CModule::IncludeModule("iblock");
if($group == "" || $FIO == "" || $doljn == "" ||
    $desc == "" || $photo == "" || $fio_zayav == ""
){
return "emp";
}

global  $USER;
        $rsElement = new CIBlockElement;
        $arFields = array(
            "ACTIVE" => "Y",
            "NAME" => $FIO,
            "IBLOCK_ID" => Blocks::zBestEmloy->value,
            "DETAIL_TEXT" => $desc,
            "PROPERTY_VALUES" => array(

                "AUTHOR" =>  $USER->GetID(),
                "YEAR" => $fio_zayav,
                "MONTH" => $fio_zayav,
                "FIO_SOTR" => $FIO,
                "PHOTO" => $photo,

            )
        );
        if ($id = $rsElement->Add($arFields)) {

            return json_encode($id,JSON_UNESCAPED_UNICODE);
        }




}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}