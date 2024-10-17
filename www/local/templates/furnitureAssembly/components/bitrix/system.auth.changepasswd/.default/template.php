<?php

use Bitrix\Main\Web\Json;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if($arResult["PHONE_REGISTRATION"])
{
	CJSCore::Init('phone_auth');
}
global $APPLICATION;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
?>
<?
if (!empty($arParams["~AUTH_RESULT"]))
{
    ?>
        <main>
    <div class="authFormBlock">
        <p>Ваш пароль успешно изменен</p>
        <a href="/auth/">Вернуться к авторизации</a>
    </div>
        </main>
    <?
    return;
}

?>
<main>


    <div class="bx-auth">


<?if($arResult["SHOW_FORM"]):?>
    <div class="authFormBlock">
<form class="form_auth" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
	<?if ($arResult["BACKURL"] <> ''): ?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">


        <input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="hidden" autocomplete="off" />
        <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="hidden" />
    <div>
        <span>Пароль</span>
        <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
            <input name="USER_PASSWORD" class="border-none h-full outline-none w-full" type="password"
                   data-input="" value="" autocomplete="off" placeholder="Пароль">
        </div>
    </div>
    <div>
        <span>Подтверждение пароля</span>
        <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
            <input name="USER_CONFIRM_PASSWORD" class="border-none h-full outline-none w-full"
                   type="password" data-input="" value="" autocomplete="off" placeholder="Подтверждение пароля">
        </div>
    </div>
        <button type="submit" name="change_pwd" value="Изменить пароль"
                class="flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max"
                data-btn="save">
            Изменить пароль
        </button>

</form>

<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>


<?if($arResult["PHONE_REGISTRATION"]):?>

<script>
new BX.PhoneAuth({
	containerId: 'bx_chpass_resend',
	errorContainerId: 'bx_chpass_error',
	interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
	data:
		<?= Json::encode([
			'signedData' => $arResult["SIGNED_DATA"]
		]) ?>,
	onError:
		function(response)
		{
			var errorDiv = BX('bx_chpass_error');
			var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
			errorNode.innerHTML = '';
			for(var i = 0; i < response.errors.length; i++)
			{
				errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
			}
			errorDiv.style.display = '';
		}
});
</script>

<div id="bx_chpass_error" style="display:none"><?ShowError("error")?></div>

<?endif?>

<?endif?>

<p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>

</div>
</div>
</main>