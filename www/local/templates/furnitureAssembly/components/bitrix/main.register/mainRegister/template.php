<?
/*
* Файл local/templates/название_сайта/components/bitrix/main.register/.default/template.php
*/
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/pages/anketaStart/css/style.css", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/pages/register/js/script.js");

global $groupId;
global $formName;
?>
<? if ($USER->IsAuthorized()): /* если пользователь уже авторизован */ ?>
   <?php LocalRedirect("/"); ?>
    <? return ?>
<? endif; ?>
<main>
    <div class="flex flex-col gap-3">
        <h1 class="text-xl ">Регистрация для <?= $formName ?></h1>
    <div class="authFormBlock">

        <? if (count($arResult["ERRORS"]) > 0): /* сообщения об ошибках при заполнении формы */ ?>
            <?
            foreach ($arResult["ERRORS"] as $key => &$error) {
                if ($key == "LOGIN") {
                    unset($error);

                }
                if (intval($key) == 0 && $key !== 0) {
                    $arResult["ERRORS"][$key] = str_replace(
                        "#FIELD_NAME#",
                        '«' . GetMessage('MAIN_REGISTER_' . $key) . '»',
                        $error
                    );
                }
            }
            ShowError(implode("<br />", $arResult["ERRORS"]));
            ?>
        <? endif;?>
        <form class="form_auth" method="post" action="/auth/register.php" name="regform" enctype="multipart/form-data">

            <input size="20" class="fields string " name="UF_GROUP" tabindex="0" type="hidden" value="<?= $groupId ?>">
                <input name="REGISTER[LOGIN]" class="border-none h-full outline-none w-full regLogin" type="hidden" data-input="" value="" placeholder="">
            <div>
                <div>
                    <p class="capitalize text-right">
                        Способ регистрации
                    </p>
                    <div class="flex items-center gap-3">
                        <label class="mailReg flex items-center gap-2">
                            <p>По Email</p>
                            <label for="radio16" class="relative inline-block w-4 h-4">
                                <input data-check="GEN" value="16" class="opacity-0 w-0 h-0 peer" checked type="radio" id="radio16" name="pol">
                                <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                                <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                            </label>
                        </label>
                        <label class="phoneReg flex items-center gap-2">
                            <p>По телефону</p>
                            <label for="radio15" class="relative inline-block w-4 h-4">
                                <input data-check="GEN" value="15" class="opacity-0 w-0 h-0 peer"  type="radio" id="radio15" name="pol">
                                <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                                <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                            </label>
                        </label>
                    </div>

                </div>
            </div>
            <div class="mailInput">
                <span>E-mail</span>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="REGISTER[EMAIL]" class="border-none h-full outline-none w-full changeLogin inputEmail" type="text"
                           data-input="" value="" placeholder="E-mail">
                </div>
                <p>На указанный в форме e-mail придет запрос на подтверждение регистрации.</p>
            </div>
            <div class="phoneInput hidden">
                <span>Телефон</span>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="REGISTER[PERSONAL_PHONE]" class="border-none h-full outline-none w-full changeLogin" type="text"
                           data-input="" value="" placeholder="Телефон">
                </div>
                <p>На указанный в форме телефон придет запрос на подтверждение регистрации.</p>
            </div>
            <div>
                <span>Пароль</span>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="REGISTER[PASSWORD]" class="border-none h-full outline-none w-full" type="password"
                           data-input="" value="" autocomplete="off" placeholder="Пароль">
                </div>
            </div>
            <div>
                <span>Подтверждение пароля</span>
                <div class="h-12 border rounded-md overflow-hidden bg-white pt-[0.75rem] pr-4 pl-4 pb-4">
                    <input name="REGISTER[CONFIRM_PASSWORD]" class="border-none h-full outline-none w-full"
                           type="password" data-input="" value="" autocomplete="off" placeholder="Подтверждение пароля">
                </div>
            </div>
            <?if ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>

            <? endif; ?>
            <button type="submit" name="register_submit_button" value="Зарегистрироваться"
                    class="flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max"
                    data-btn="save">
                Зарегистрироваться
            </button>

        </form>
        <p><?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; /* предупреждение о min длине пароля */ ?></p>
        <a href="/auth/">Вернуться к авторизации</a>
    </div>
    </div>
</main>
