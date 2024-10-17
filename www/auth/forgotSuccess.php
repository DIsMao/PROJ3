<?
$disHeaderFooter = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
global $APPLICATION;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
?>
<main>

    <div class="authFormBlock">
        <p>Ссылка для изменения пароля была отправлена к вам на почту (номер телефона)</p>
        <a href="/auth/">Вернуться к авторизации</a>
    </div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>