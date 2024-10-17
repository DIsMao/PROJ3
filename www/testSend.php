
<?php

use Bitrix\Main\Mail\Event;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arEventField2 = array(
    "NAME" => "asdasd",// - здесь email - это <input type="email" name="email" placeholder="E-mail" value="" required>

);
Event::send(array(
    "EVENT_NAME" => "NEW_DEVICE_LOGIN",
    "LID" => "s1",
    "C_FIELDS" => $arEventField2,

));
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
