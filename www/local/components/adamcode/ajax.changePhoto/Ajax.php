<?php

use Adamcode\Config\Blocks;
use Adamcode\Models\ModerationPhoto;
use Adamcode\Util\CommonUtils;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (!empty($_FILES)) {
    \CModule::IncludeModule("iblock");
    global $USER;

    $rsElement = new CIBlockElement;

    $status = CommonUtils::getListOption(Blocks::ModerationPhoto->value, "not_got")["ID"];

    $arFields = array(
        "ACTIVE" => "Y",
        "IBLOCK_ID" => Blocks::ModerationPhoto->value,
        "NAME" => $USER->GetFullName(),
        "PREVIEW_PICTURE" => $_FILES["croppedImage"],
        "PROPERTY_VALUES" => array(

            "USER" => $USER->GetID(),
            "STATUS" => $status

        )
    );
    $id = $rsElement->Add($arFields);

    $res = ModerationPhoto::select(["ID","PREVIEW_PICTURE"])->filter(["ID" => $id])->getList()->first();
echo CFile::GetPath($res["PREVIEW_PICTURE"]);
}

?>