<?


require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
use Adamcode\Config\Blocks;
use Adamcode\Util\CommonUtils;

use \Bitrix\Main\Application;

    \CModule::IncludeModule("iblock");

        $arr = Application::getInstance()->getContext()->getRequest()->toArray();


    if($arr["COMRAD"] == "yes"){
        $arr["COMRAD"] = CommonUtils::getListOption(Blocks::anceti->value, "comradYes")["ID"];
    }

    if($arr["COR_WORK"] == "on"){
        $arr["COR_WORK"] = CommonUtils::getListOption(Blocks::anceti->value, "cwYes")["ID"];;
    }
    if($arr["ELECTR"] == "on"){
        $arr["ELECTR"] = CommonUtils::getListOption(Blocks::anceti->value, "eYes")["ID"];;
    }
    if($arr["EVROAZAP"] == "on"){
        $arr["EVROAZAP"] = CommonUtils::getListOption(Blocks::anceti->value, "evrYes")["ID"];;
    }

    if($arr["RESTOR"] == "on"){
        $arr["RESTOR"] = CommonUtils::getListOption(Blocks::anceti->value, "resYes")["ID"];;
    }
    if($arr["ROCK_WORK"] == "on"){
        $arr["ROCK_WORK"] = CommonUtils::getListOption(Blocks::anceti->value, "rwYes")["ID"];;
    }
    if($arr["SANT"] == "on"){
        $arr["SANT"] = CommonUtils::getListOption(Blocks::anceti->value, "santYes")["ID"];;
    }

        $for_unlink = [];
$currentFiles = [];
foreach ($_FILES["file"]["name"] as $key => $value) {

    $fileName = $_FILES["file"]["name"][$key];
    $fileTmpName = $_FILES["file"]["tmp_name"][$key];
    $fileType = $_FILES["file"]["type"][$key];

    $file = CFile::MakeFileArray($fileTmpName);
    $file['name'] = $fileName;

    $currentFiles[] = $file;
}



    global  $USER;
    $arr["USER"] = $USER->GetID();
    $rsElement = new CIBlockElement;
    $arFields = array(
        "ACTIVE" => "Y",
        "NAME" => "Анета старт - " . date("d.m.Y H:i"),
        "IBLOCK_ID" => Blocks::anceti->value,
        "PROPERTY_VALUES" => $arr
    );
    if ($id = $rsElement->Add($arFields)) {
//        foreach( $for_unlink as $key => $file){
//
//            unlink ($file);
//
//        }
        CIBlockElement::SetPropertyValueCode($id, 'GALLERY', $currentFiles);

        echo "true";
}

