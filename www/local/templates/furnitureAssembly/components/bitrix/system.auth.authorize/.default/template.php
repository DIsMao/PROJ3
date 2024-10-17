<?php
/*
 * Файл local/templates/.default/components/bitrix/system.auth.authorize/.default/template.php
 */
use Bitrix\Main\Diag\Debug;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/pages/auth/style.css");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/pages/auth/js/script.js");
?>


<main>

                            <div class="authFormBlock">
<!--                                <a class="logo logoAuth" href="/">-->
<!--                                    <img src="--><?php //= SITE_TEMPLATE_PATH ?><!--/img/Other/Logo.png" class="logo__img"-->
<!--                                         style="height: 52px;">Назад-->
<!--                                </a>-->
                                <h2 class="page__authorization__block__title">Авторизация </h2>

                                <h2><?= GetMessage('SYS_AUTH_AUTHORIZE_TITLE'); /* заголовок формы */ ?></h2>

								<?php
								// сообщение, как прошла операция авторизации
								ShowMessage($arParams["~AUTH_RESULT"]);
								// сообщение об ошибке при авторизации
								ShowMessage($arResult['ERROR_MESSAGE']);

								?>

                                <form class="form_auth" name="form_auth"  method="post" target="_top"
                                      action="<?= $arResult["AUTH_URL"]; ?> " id="login_form">

                                    <input type="hidden" name="AUTH_FORM" value="Y"/>
                                    <input type="hidden" name="TYPE" value="AUTH"/>

									<?php if (strlen($arResult["BACKURL"]) > 0): ?>
                                        <input type="hidden" name="backurl" value="/"/>
									<?php endif; ?>

									<?php foreach ($arResult["POST"] as $key => $value): /* передача полученных POST-параметров */ ?>
                                        <input type="hidden" name="<?= $key; ?>" value="<?= $value; ?>"/>
									<?php endforeach; ?>
                                    <div>
                                        <div>
                                            <p class="capitalize text-right">
                                                Способ авторизации
                                            </p>
                                            <div class="flex items-center gap-3">
                                                <label class="mailReg flex items-center gap-2">
                                                    <p>По Email</p>
                                                    <label for="radio16" class="relative inline-block w-4 h-4">
                                                        <input data-check="GEN" value="16" class="opacity-0 w-0 h-0 peer" checked="" type="radio" id="radio16" name="pol">
                                                        <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                                                        <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                                                    </label>
                                                </label>
                                                <label class="phoneReg flex items-center gap-2">
                                                    <p>По телефону</p>
                                                    <label for="radio15" class="relative inline-block w-4 h-4">
                                                        <input data-check="GEN" value="15" class="opacity-0 w-0 h-0 peer" type="radio" id="radio15" name="pol">
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
                                    </div>
                                    <div class="phoneInput hidden">
                                        <p class="input__form__title">Телефон</p>
                                        <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                                            <input name="" class="border-none h-full outline-none w-full changeLogin" type="text" value="" data-input="" maxlength="255">
                                        </div>
                                    </div>
                                    <p class="input__form__title">Пароль</p>
                                    <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                                        <input name="USER_PASSWORD" class="border-none h-full outline-none w-full" type="password" value="" data-input="<?= $arResult["LAST_LOGIN"]; ?>" maxlength="255">
                                    </div>



									<?php if ($arResult["SECURE_AUTH"]): /* безопасная авторизация (зашифрованная передача пароля) */ ?>
                                        <!-- код удален -->
									<?php endif; ?>

                                    <button type="submit" class="flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max" data-btn="save">
                                        <?= GetMessage('AUTH_AUTHORIZE'); ?>
                                    </button>

                                </form>

                                <br>


                                    <a href="/auth/?forgot_password=yes" rel="nofollow">
										<?= GetMessage('SYS_AUTH_AUTHORIZE_FORGOT'); ?>
                                    </a>

                                    <a href="/auth/register_assembler" rel="nofollow">
										Регистрация (для сборщиков)
                                    </a>
                                <a href="/auth/register_partner" rel="nofollow">
                                    Регистрация (для заказчиков)
                                </a>

                            </div>

</main>


<script type="text/javascript">
    var auth = 1;
    var suc=<?=$suc?>;
 if (suc=="1")
 {
     // window.location.href="/"
 }
	<?php if (strlen($arResult["LAST_LOGIN"]) > 0): ?>
    try {
        document.form_auth.USER_PASSWORD.focus();
    } catch (e) {
    }
	<?php else: ?>
    try {
        document.form_auth.USER_LOGIN.focus();
    } catch (e) {
    }
	<?php endif; ?>
</script>

