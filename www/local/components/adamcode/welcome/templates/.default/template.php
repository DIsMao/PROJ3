<?php

use Bitrix\Main\Engine\CurrentUser;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>

    <?if(CurrentUser::get()->getId()):?>
    <a class="widget__lk__info" href="<?=$arParams["LK_LINK"]?>">
        <div  class="widget__lk__img header">
            <img src="<?=$arResult["USER_INFO"]["PHOTO"]?>">
        </div>
        <div class="widget__lk__block">
            <p style="margin-bottom: 5px; font-weight: 600;">Здравствуйте,</p>
            <div class="widget__lk__fio header"><?=$arResult["USER_INFO"]["NAME"]?></div>
        </div>
    </a>
    <div class="  d-inline-flex ">
        <div class="tooltip__cust outRtn">
            <a class="link" title="Выход"  href="/?logout=yes&<?=bitrix_sessid_get()?>">

                <img class="btn img outBtnImg filter-0"    src="<?=SITE_TEMPLATE_PATH?>/img/icon/logout.svg">
            </a>

            <div class="tooltip_arrow"></div>
            <p class="tooltip__info">Выход</p>
        </div>

    </div>

<?else:?>
    <div class="ms-auto d-inline-flex ">
        <a  href="<?=$arParams["LOGIN_LINK"]?>" class="btn submit ">Войти</a>
    </div>


<?endif;?>