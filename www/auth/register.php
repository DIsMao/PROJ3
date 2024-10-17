<?

use Adamcode\Config\Groups;

$disHeaderFooter = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
$APPLICATION->SetTitle("Регистрация");
if($_GET["GROUP_ASSEMBLER"] == "true"){
    $groupId =  Groups::ASSEMBLERS->value;
    $formName = "сборщиков";
}else if($_GET["GROUP_CUSTOMER"] == "true"){
    $groupId =  Groups::CUSTOMERS->value;
    $formName = "заказчиков";
}

?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:main.register",
    "mainRegister",
    array(
        "AUTH" => "Y",
        "COMPONENT_TEMPLATE" => "mainRegister",
        "REQUIRED_FIELDS" => array(
//            0=>"EMAIL",
//            1=>"NAME",
//            2=>"LAST_NAME",
//            0=>"PERSONAL_PHONE",
        ),
        "SET_TITLE" => "Y",
        "SHOW_FIELDS" => array(
//            0=>"EMAIL",
//            1=>"NAME",
//            2=>"LAST_NAME",
            0=>"PERSONAL_PHONE",
//            4=>"WORK_COMPANY",
//            5=>"WORK_PHONE",
        ),
        "SUCCESS_PAGE" => "/auth/registerSuccess.php",
        "USER_PROPERTY" => array(0 => "UF_GROUP",),
        "USER_PROPERTY_NAME" => "UF_GROUP",
        "USE_BACKURL" => "N"
    )
);

?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>