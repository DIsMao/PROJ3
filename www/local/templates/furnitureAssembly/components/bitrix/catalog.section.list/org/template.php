<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
global $IBIDs;
$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder() . '/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder() . '/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

$dir = $APPLICATION->GetCurDir();

//  echo '<pre>';
//   print_r($arResult);
//   echo '</pre>';
$inner = (substr_count($_SERVER["REQUEST_URI"], '/') > 2)
?>



	<?

    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*", "IBLOCK_SECTION_ID", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "SECTION_ID"=>$arResult['SECTION']['ID']);
if(isset($_GET["search"])){
    $arFilter["?NAME"] = $_GET["search"];
}
$res = CIBlockElement::GetList(Array("name"=>"ASC"), $arFilter, false, false, $arSelect);
    $arUsers = array ();
while($ob = $res->GetNextElement()){
    $data = $ob->GetFields();

    $SEC = CIBlockSection::GetByID($data['IBLOCK_SECTION_ID']);
    $ar_SEC = $SEC->GetNext();
    $data["SEC_NAME"] = $ar_SEC['NAME'];
    $data["SEC_URL"] = $ar_SEC['SECTION_PAGE_URL'];
    $data["PROPS"] = $ob->GetProperties();
    $arUsers[] = $data;
}
//      echo '<pre>';
//       print_r($arUsers);
//       echo '</pre>';
    ?>
    <div class="employees">
        <div class="employees__nav">
            <p class="text">Сотрудники<span><?= $res->SelectedRowsCount (); ?></span></p>
            <div class="input__search">
                <svg class="org-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input class="org-search" type="text" name="" value="<?= $_GET["search"] ?>" placeholder="Поиск по сотрудникам">
            </div>
        </div>

        <div class="employees__items">

            <? foreach ($arUsers as $item): ?>
<!--            --><?php
//            echo $item["PROPS"]["USER"]["VALUE"];
//                if (!str_contains($item["NAME"], $_GET["search"])) {
//                    continue;
//                }
                $photoPath = "";
                $photoID = CUser::GetByID($item["PROPS"]["USER"]["VALUE"])->Fetch()['PERSONAL_PHOTO']; //Получаем ID Фотографии по ID пользователя.
                $photoPath = CFile::GetPath($photoID); //Получаем путь к файлу.

            if($photoPath == ""){
                $photoPath = CFile::GetPath($item["PROPS"]["PHOTO"]["VALUE"]);
            }
                if($photoPath == ""){
                    $photoPath = SITE_TEMPLATE_PATH . "/img/people/no-user-photo.png";
                }
                ?>
                <hr>
                <div class="employees__block">
                    <div class="employees__card">
                        <div class="employees__img"><img src="<?= $photoPath ?>" alt="<?= $item["NAME"]; ?>"></div>
                        <div class="employees__box">
                            <div class="employees__header">
                                <a href="<?= $item["DETAIL_PAGE_URL"]; ?>" class="link">
                                    <p class="text text-fio"><?= $item["NAME"]; ?></p>
                                </a>
                                <p class="text text-job"><? if($item["PROPS"]["HEAD"]["VALUE"] == "Y"){echo "Руководитель отдела";}else{echo "Сотрудник";} ?></p>
                            </div>
                            <div class="employees__body">
                                <a href="<?= $item["SEC_URL"]; ?>" class="link link-img link-gray">
                                    <?= $item["SEC_NAME"]; ?>
                                    <svg class="org-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 12H20M20 12L14 6M20 12L14 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="employees__info">

                        <div class="employees__info-item">
                            <p class="text text-gray">Моб. тел.:</p>
                            <p class="text"><?= $item["PROPS"]["PHONE"]["VALUE"]; ?></p>
                        </div>
                        <div class="employees__info-item">
                            <p class="text text-gray">Email:</p>
                            <p class="text text-gray"><?= $item["PROPS"]["EMAIL"]["VALUE"]; ?></p>
                        </div>
                        <div class="employees__info-item">
                            <p class="text text-gray">Должность:</p>
                            <p class="text"><?= $item["PROPS"]["POSITION"]["VALUE"]; ?></p>
                        </div>

                    </div>
                </div>

            <? endforeach; ?>

        </div>
    </div>

