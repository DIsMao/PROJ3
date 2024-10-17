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


class AjaxzNewEmpl extends \CBitrixComponent implements Controllerable
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

public function zNewEmplAction($tabNum,$fam,$name,$otch,$yurLico,$filial,
                               $otdel,$doljn,$rukovod,$zdanieINum,$rabPhone,
                               $mobPhone,$dostKSetRes,$dostK1C,$dostupKNavisionC,
                               $dostupKNavisionT,$dr,$dataNachRab,$propuskVCO,
)
{
    \CModule::IncludeModule("iblock");
if($tabNum == "" || $fam == "" || $name == "" ||
    $otch == "" || $yurLico == "" || $filial == "" ||
    $otdel == "" || $doljn == "" || $rukovod == "" || $zdanieINum == "" ||
    $rabPhone == "" || $mobPhone == "" || $dostKSetRes == "" ||
    $dostK1C == "" || $dostupKNavisionC == "" || $dostupKNavisionT == "" ||
    $dr == "" || $dataNachRab == "" || $propuskVCO == ""
){
return "emp";
}
    $arEventField = array(
        "TABNUM" => $tabNum,
        "FAM" => $fam,
        "NAME" => $name,
        "OTCH" => $otch,
        "YUR_LICO" => $yurLico,
        "FILIAL" => $filial,
        "OTDEL" => $otdel,
        "DOLJN" => $doljn,
        "RUKOVOD" => $rukovod,
        "ZSANIE_I_NUM" => $zdanieINum,
        "RAB_PHONE" => $rabPhone,
        "MOB_PHONE" => $mobPhone,
        "DOSTUP_KSR" => $dostKSetRes,
        "DOST_K_1C" => $dostK1C,
        "NAVISION_C" => $dostupKNavisionC,
        "NAVISION_TEXT" => $dostupKNavisionT,
        "DR" => $dr,
        "DATA_NACH_RAB" => $dataNachRab,
        "PROPUSK_V_CO" => $propuskVCO
    );

$DETAIL_TEXT =
    "
Табельный номер:
". $tabNum ." 

Фамилия:
". $fam ."  

Имя:
". $name ." 

Отчество:
". $otch ." 

Наименование юр. лица, в котором работает сотрудник:
". $yurLico ." 

Филиал:
". $filial ." 

Отдел:
". $otdel ." 

Должность:
". $doljn ." 

Руководитель нового сотрудника:
". $rukovod ." 

Здание и № комнаты:
". $zdanieINum ." 

Номер телефона рабочий:
". $rabPhone ." 

Номер телефона мобильный:
". $mobPhone ." 

Доступ к сетевым ресурсам:
". $dostKSetRes ." 

Доступ к базам 1С:
". $dostK1C ." 

Нужен ли доступ к Navision?:
". $dostupKNavisionC ." 

Navision – базы:
". $dostupKNavisionT ." 

День рождения:
". $dr ." 

Дата начала работы сотрудника на новом рабочем месте:
". $dataNachRab ." 

Пропуск в ЦО Лужники:
". $propuskVCO ." 
    ";

        $rsElement = new CIBlockElement;
        $arFields = array(
            "ACTIVE" => "Y",
            "NAME" => "Заявка на сотрудника - " . $fam . " " . $name . " " . $otch,
            "IBLOCK_ID" => Blocks::zNewEmpl->value,
            "DETAIL_TEXT" => $DETAIL_TEXT
        );
        if ($id = $rsElement->Add($arFields)) {



            Event::send(array(
                "EVENT_NAME" => "ZAYAVKA_NA_NOVOGO_SOTRUDNIKA",
                "LID" => "s1",
                "C_FIELDS" => $arEventField,
            ));

            return json_encode($id,JSON_UNESCAPED_UNICODE);
        }




}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}