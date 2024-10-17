<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

if (!empty($arParams["~AUTH_RESULT"]))
{
    LocalRedirect("/auth/forgotSuccess.php");
}
global $APPLICATION;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/pages/forgot/js/script.js");
?>
<main>

    <div class="authFormBlock">
<form class="form_auth" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if ($arResult["BACKURL"] <> '')
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">

	<p>Изменение пароля</p>

	<div style="margin-top: 16px">
		<div><b>Введите email или номер телефона:</b></div>
		<div>
            <div>
                <div>

                    <div class="flex items-center gap-3">
                        <label class="mailReg flex items-center gap-2">
                            <p>По Email</p>
                            <label for="radio16" class="relative inline-block w-4 h-4">
                                <input data-check="" value="16" class="opacity-0 w-0 h-0 peer" checked="" type="radio" id="radio16" name="pol">
                                <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                                <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                            </label>
                        </label>
                        <label class="phoneReg flex items-center gap-2">
                            <p>По телефону</p>
                            <label for="radio15" class="relative inline-block w-4 h-4">
                                <input data-check="" value="15" class="opacity-0 w-0 h-0 peer" type="radio" id="radio15" name="pol">
                                <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                                <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                            </label>
                        </label>
                    </div>

                </div>
            </div>
            <input name="USER_LOGIN" class="border-none h-full outline-none w-full regLogin" type="hidden" value="" data-input="" maxlength="255">
            <div class="mailInput">
                <p class="input__form__title">Email</p>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="" class="border-none h-full outline-none w-full changeLogin" type="text" value="" data-input="" maxlength="255">
                </div>
                <div>Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по email.</div>
            </div>
            <div class="phoneInput hidden">
                <p class="input__form__title">Телефон</p>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="" class="border-none h-full outline-none w-full changeLogin" type="text" value="" data-input="" maxlength="255">
                </div>
                <div>Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по номеру телефона.</div>
            </div>

			<input type="hidden" name="USER_EMAIL" />
		</div>

	</div>

<?if($arResult["PHONE_REGISTRATION"]):?>

		<input type="text" name="USER_PHONE_NUMBER" class="hidden" value="<?=$arResult["USER_PHONE_NUMBER"]?>" />

<?endif;?>

<?if($arResult["USE_CAPTCHA"]):?>
	<div style="margin-top: 16px">
		<div>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		</div>
		<div>Введите символы с картинки</div>
		<div><input type="text" name="captcha_word" maxlength="50" value="" /></div>
	</div>
<?endif?>

    <button type="submit" name="send_account_info" value="Выслать" class="flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max" data-btn="save">
        Выслать
    </button>
</form>

<div style="margin-top: 16px">
	<p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b>Вернуться к авторизации</b></a></p>
</div>
    </div>
</main>
<script>
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>
