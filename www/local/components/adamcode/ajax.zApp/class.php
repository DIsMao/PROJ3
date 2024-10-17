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

public function zAppAction($email,$email2,$fio,$pos,$komFio,$otdel,$date1,$date2,$org,$target)
{
    \CModule::IncludeModule("iblock");
if($email == "" || $fio == "" || $pos == "" ||
    $komFio == "" || $otdel == "" || $date1 == "" ||
    $date2 == "" || $org == "" || $target == ""
){
return "emp";
}
    $date1 = date("d.m.Y", strtotime($date1));
    $date2 = date("d.m.Y", strtotime($date2));

    $arEventField = array(
        "EMAIL_TO" => $email,// - здесь email - это <input type="email" name="email" placeholder="E-mail" value="" required>
        "TARGET" => $target,// - здесь textarea - это <input type="text" name="textarea" placeholder="Текст сообщения" value="">
        "FIO" => $fio,
        "POS" => $pos,
        "KOM_FIO" => $komFio,
        "OTDEL" => $otdel,
        "DATE" => "с " . $date1 . " по " . $date2,
        "ORG" => $org
    );
    $arEventField2 = array(
        "EMAIL_TO" => $email2,// - здесь email - это <input type="email" name="email" placeholder="E-mail" value="" required>
        "TARGET" => $target,// - здесь textarea - это <input type="text" name="textarea" placeholder="Текст сообщения" value="">
        "FIO" => $fio,
        "POS" => $pos,
        "KOM_FIO" => $komFio,
        "OTDEL" => $otdel,
        "DATE" => "с " . $date1 . " по " . $date2,
        "ORG" => $org
    );

    $template_file_name = '/home/bitrix/www/upload/wordTmp/tmpzapp.docx';

    $rand_no = rand(111111, 999999);
    $fileName = "results_" . $rand_no . ".docx";


    $full_path = '/home/bitrix/www/upload/wordTmp/' . $fileName;
    $abslt_path = 'upload/wordTmp/' . $fileName;
    try
    {


        //Copy the Template file to the Result Directory
        copy($template_file_name, $full_path);

        // add calss Zip Archive
        $zip_val = new ZipArchive;

        //Docx file is nothing but a zip file. Open this Zip File
        if($zip_val->open($full_path) == true)
        {
            // In the Open XML Wordprocessing format content is stored.
            // In the document.xml file located in the word directory.

            $key_file_name = 'word/document.xml';
            $message = $zip_val->getFromName($key_file_name);

            $timestamp = date('d.m.Y');

            // this data Replace the placeholders with actual values
            $message = str_replace("curdateisbry",      $timestamp,       $message);
            $message = str_replace("komstrisbry",      $komFio,       $message);
            $message = str_replace("otdelisbry",      $otdel,       $message);
            $message = str_replace("cityisbry",      $org,       $message);
            $message = str_replace("dateisbry",      "с " . $date1 . " по " . $date2,       $message);
            $message = str_replace("targetisbry",      $target,       $message);
            $message = str_replace("posisbry",      $pos,       $message);
            $message = str_replace("sotrisbry",      $fio,       $message);

            //Replace the content with the new content created above.
            $zip_val->addFromString($key_file_name, $message);
            $zip_val->close();
        }

        $fileArr = CFile::MakeFileArray ($full_path);



        $arEventField["DOC"] = $fileArr;
        $rsElement = new CIBlockElement;
        $arFields = array(
            "ACTIVE" => "Y",
            "NAME" => $fio,
            "IBLOCK_ID" => Blocks::zApp->value,
            "PROPERTY_VALUES" => $arEventField
        );
        if ($id = $rsElement->Add($arFields)) {


            $db_prop = CIBlockElement::GetProperty(Blocks::zApp->value, $id, array("sort" => "asc"), Array("CODE"=>"DOC"));
            if($ar_props = $db_prop->Fetch())
                $fileId = IntVal($ar_props["VALUE"]);

            Event::send(array(
                "EVENT_NAME" => "NEW_ZAYAVKA_NA_KOMANDIROVKU",
                "LID" => "s1",
                "C_FIELDS" => $arEventField,
                "FILE"=> array($fileId),

            ));

            Event::send(array(
                "EVENT_NAME" => "NEW_ZAYAVKA_NA_KOMANDIROVKU",
                "LID" => "s1",
                "C_FIELDS" => $arEventField2,
                "FILE"=> array($fileId),

            ));

            unlink($full_path);

            return json_encode($id,JSON_UNESCAPED_UNICODE);
        }

    }
    catch (Exception $exc)
    {
        $error_message =  "Error creating the Word Document";
        var_dump($exc);
    }



}

public function executeComponent()
{
$this->includeComponentTemplate();
}
}