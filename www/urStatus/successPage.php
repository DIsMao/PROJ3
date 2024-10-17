<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/pages/successPage/css/style.css", true);
$APPLICATION->SetTitle("Анкета успешно отправлена");
CModule::IncludeModule("iblock");
?>
<main>
<div class="successMesg">
    <div >
        <img class="icon" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/CheckSquare.svg">
    </div>
    <div class="flex flex-col gap-1">
        <p class="text-xl">Анкета успешно отправлена.</p>
        <a class="flex gap-2 w-max font-montserrat font-semibold text-base text-primary hover:text-[#7a5bca]" href="/">Вернуться на главную</a>
    </div>
</div>
</main>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>