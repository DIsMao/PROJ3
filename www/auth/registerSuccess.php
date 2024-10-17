<?
$disHeaderFooter = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
global $APPLICATION;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
?>
<main>

    <div class="authFormBlock">
        <p>Вы успешно зарегистрировались, подтвердите свои данные перейдя по ссылке которая была отправлена на ваш Email (телефон)</p>
        <a href="/auth/">Вернуться к авторизации</a>
    </div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>