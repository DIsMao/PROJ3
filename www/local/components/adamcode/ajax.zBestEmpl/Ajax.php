<?php

use Adamcode\Config\Blocks;
use Adamcode\Models\ModerationPhoto;
use Adamcode\Util\CommonUtils;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';


    \CModule::IncludeModule("iblock");
    if($_POST["FIO"] == "" || $_POST["desc"] == "" || $_POST["fio_zayav"] == "" ||
        $_POST["group"] == "" || (empty($_FILES) && $_POST["poralPhoto"] == "")
    ){
        echo "emp";
        return;
    }

    if(empty($_FILES)){
        $photo = CFile::MakeFileArray($_POST["poralPhoto"]);;
    }else{
        $photo = $_FILES["croppedImage"];
    }

    global  $USER;
    $rsElement = new CIBlockElement;
    $arFields = array(
        "ACTIVE" => "N",
        "NAME" => $_POST["FIO"],
        "IBLOCK_ID" => Blocks::zBestEmloy->value,
        "DETAIL_TEXT" => $_POST["desc"],
        "PROPERTY_VALUES" => array(

            "AUTHOR" =>  $USER->GetID(),
            "FIO_ZAYAV" => $_POST["fio_zayav"],
            "FIO_SOTR" => $_POST["FIO"],
            "GROUP" => $_POST["group"],
            "DOLJN" => $_POST["doljn"],
            "YEAR" => date("Y"),
            "MONTH" => date("m"),
            "PHOTO" => $photo,
        )
    );
    if ($id = $rsElement->Add($arFields)) {

        echo "success";
    }




?>