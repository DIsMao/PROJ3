<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Engine\UrlManager,
	\Bitrix\Main\Loader,
	\Bitrix\Disk;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

global $IBIDs;

$this->setFrameMode(true);
// 	echo "<pre>";
// print_r($arResult);
// echo "</pre>";
if (!empty($arResult['NAV_RESULT']))
{
	$navParams = array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
} else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

if ($showTopPager)
{
	?>
    <div data-pagination-num="<?= $navParams['NavNum'] ?>">
        <!-- pagination-container -->
		<?= $arResult['NAV_STRING'] ?>
        <!-- pagination-container -->
    </div>
	<?
}

$select = [
	"UF_*"

];

$sort = [
	"SORT" => "ASC"
];

$filter = [
	/* @var int ID инфоблока */
	'IBLOCK_ID' => 19,

	/* @var string Символьный код раздела */
	'CODE' => $arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'],

	/* @var int ID раздела */
	'ID' => $arResult['ORIGINAL_PARAMETERS']['SECTION_ID'],
];


$rsResult = CIBlockSection::GetList(
	$sort,
	$filter,
	false,
	$select
);
while ($arResultSection = $rsResult->GetNext())
{
	$arResult['SECTION'] = $arResultSection;
	// echo $arResultSection['US_SLIDER'];
}

?>
<?

//get documents
$arFilter = array(
	'ACTIVE' => 'Y',
	'IBLOCK_ID' => $IBIDs->Docs
);
$arSelect = array('IBLOCK_ID', 'ID', 'NAME', "SECTION_PAGE_URL", 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID');
$arOrder = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
$sectionLinc = array();
$Result['ROOT'] = array();
$sectionLinc[0] = &$Result['ROOT'];

$jsTree=[];
while ($arSection = $rsSections->Fetch())
{
//echo 'got['.$arSection["ID"].']'.$arSection["NAME"];
	$arSection['id'] = $arSection["ID"];
	$arSection['text'] = $arSection["NAME"];
	$arSection['type'] = 'folder';
	$arSection['sort'] = 1;
	$arSection['state'] = (object)[
		'checked' => false,
		'disabled' => false,
		'opened' => false,
		'selected' => false
	];
	$arSection['children'] = array();
    $rsElements = CIBlockElement::GetList(
				array("NAME"=>"ASC"),
				array('ACTIVE' => 'Y','IBLOCK_ID' => $IBIDs->Docs,'SECTION_ID'=>$arSection["ID"]),
				false,
				false,
				array("ID", "NAME", "DETAIL_PAGE_URL")
			);
			while($arFile = $rsElements->Fetch()){
				$sel = false;
				if (!empty($arResult["SECTION"]['UF_FILE_ID'] && in_array($arFile["ID"], $arResult["SECTION"]['UF_FILE_ID']))){
					$sel = true;
				}

				$fileObj = (object) [
					'id' => $arFile["ID"],
					'text' => $arFile["NAME"],
					'children' => array(),
					'type'=>'file',
					'data'=> $arFile["DETAIL_PAGE_URL"],
					'sort' => 2,
					'state' => (object) [
						'checked' => false ,
						'disabled' => false,
						'opened'=> false,
						'selected'=> $sel
					]
				];
				$arSection['children'][] = $fileObj;
			}

			$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
			$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['children'][] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
			$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
			usort($sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['children'], function($a,$b){
				return $a->sort-$b->sort;
			});




}	foreach ($sectionLinc[0]['CHILD'] as $fold){
	$jsTree[] = $fold;
} if ($USER->IsAdmin()&&($arResult["DESCRIPTION"]!="")): ?>
<!--    <input type="button" id="button" class="file_add_popup  mb-5" onclick="showFilesModal()" data-page="--><?php //= $arResult['SECTION']['ID'] ?><!--"-->
<!--           value="Добавить документы"  data-iblock="--><?php //= $arResult['SECTION']['IBLOCK_ID'] ?><!--">-->
    <div class="modal common fade" id="filesModal" tabindex="-1" role="dialog" aria-labelledby="filesModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: fit-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orgModalLabel">Выберите документы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="user-select: auto;"></button>
                </div>
                <div class="modal-body">
                    <div id="filesTree">

                    </div>
                    <div class="picked_files">

                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn img "  onclick="saveModalFiles(<?= $arResult['SECTION']['ID'] ?>)" style="user-select: auto;">
                        <p class="btn__text" style="user-select: auto;">Сохранить</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?endif;

if (!empty($arResult['SECTION']['UF_FILE_ID'])):

		$files = array();
		$folder = array();
		$arFolderList = array();
		$arFileList = array();


		if (!empty($arResult['SECTION']['UF_FILE_ID'])  && $arResult['SECTION']['UF_FILE_ID'][0] != 0)
		{
			foreach ($arResult['SECTION']['UF_FILE_ID'] as $fileElemID)
			{
				//elements of Documents IB
				$res = CIBlockElement::GetByID($fileElemID);
				if ($ar_file = $res->GetNext())
				{
					//echo $ar_file['NAME'];
					$files[] = $ar_file;
				}
			}?>
            <div class="page__type__page__documents">
			<?
			foreach ($files as $file) :
				if ($file) :
					$fn = $file["NAME"];
					$link4 = $file["DETAIL_PAGE_URL"];
                        $date= ConvertDateTime($file["DATE_CREATE"], "YYYY.MM.DD", "ru");
;
					$file_type = strtolower(substr(strrchr($fn, "."), 1));
					?>
                    <div class="card__document">
                        <div class="card__document__img">
							<? if ($file_type == 'xls' || $file_type == 'xlsx'):?>
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/XLSIcons.svg"/>
							<? elseif ($file_type == 'doc' || $file_type == 'docx'):?>
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/DocIcons.svg"/>
							<? elseif ($file_type == 'pdf'):?>
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/PDFIcon.svg"/>
							<? else:?>
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/DocIconV2.svg"/>
							<? endif; ?>
                        </div>
                        <div class="card__document__block">
                            <div class="card__document__body">
                            <p>
									<?= $fn ?>
                                </p>
                            </div>
                        <div class="card__document__footer">
                            <p style="user-select: none;"><?=$date?> </p>
                            <a class="link" href="<?=$link4?>">
                                <p>Скачать</p>
                                <img class="link__img" src="<?=SITE_TEMPLATE_PATH ?>/img/icon/download-cloud-02.svg">
                            </a>
                        </div>
                    </div>
                    </div>

				<? endif; ?>
			<?endforeach; ?>
        </div>
	<?	}?>



<? endif; ?>




<? if (!empty($arResult['SECTION']['UF_SLIDER'])): ?>

    <div class="carousel">
        <div class="carousel desktop">
            <div class="carousel__top owl-carousel owl-theme">
				<? foreach ($arResult['SECTION']['UF_SLIDER'] as $key => $picture)
				{
					$slide = CFile::GetPath($picture);

					?>
                    <div class="carousel__item" data-hash="slide<?= $key ?>"
                         data-description="Подготовка новой дороги к эксплуатации в Ростовской области ">
                        <img src="<?= $slide ?>"/>
                        <div class="carousel__item__block">

                        </div>
                    </div>
				<? } ?>

            </div>
            <div class="carousel__bottom">
                <div class="carousel__bottom__items">
					<? foreach ($arResult['SECTION']['UF_SLIDER'] as $key => $picture)
					{
						$slide = CFile::GetPath($picture);

						?>
                        <a class="carousel__link" href="#slide<?= $key ?>">
                            <img src="<?= $slide ?>"/>
                        </a>
					<? } ?>
                </div>
                <!-- 	<p id="carouselImgDescription" class="carousel__description">
			Подготовка новой дороги к эксплуатации в Ростовской области
		</p> -->
            </div>
        </div>
        <div class="carousel mob">
            <div class="carousel__box owl-carousel owl-theme">
				<? foreach ($arResult['SECTION']['UF_SLIDER'] as $key => $picture)
				{
					$slide = CFile::GetPath($picture);

					?>
                    <div class="carousel__item"
                         data-description="Подготовка новой дороги к эксплуатации в Ростовской области ">
                        <img src="<?= $slide ?>"/>
                    </div>
				<? } ?>

            </div>
            <!-- <p id="carouselImgDescriptionMob" class="carousel__description">
			Подготовка новой дороги к эксплуатации в Ростовской области
		</p> -->
        </div>
    </div>


<? endif; ?>




<?
if (!empty($arResult['ITEMS']))
{
//    echo '<pre>';
//    print_r($arResult['ITEMS']);
//    echo '</pre>';
?>
<div class="page__navigation">

    <div class="page__navigation__items">

		<? foreach ($arResult['ITEMS'] as $key => $value)
		{
// 			echo "<pre>";
// print_r($value);
// echo "</pre>";
			// if($arResult['SECTION_ID'] == $value['IBLOCK_SECTION_ID']){

			$pic = CFile::GetPath($value['PROPERTIES']['ICON']['VALUE']);


			?>

            <a class="link card nav" id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
               href="<?= $value['PROPERTIES']['LINK']['VALUE'] ?>">
                <img src="<?= $pic ?>">
                <p><?= $value["NAME"] ?></p>
            </a>


			<?
			// }
		}?>


    </div>

</div>
       <? }?>
<?if ($USER->IsAdmin()&&($arResult["DESCRIPTION"]!="")):?>
<a class="btn img"  style="width: fit-content" href="/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=<?=$arResult["IBLOCK_ID"]?>&type=lists&lang=ru&ID=<?=$arResult["ID"]?>&find_section_section=-1">
    <p class="btn__text">Редактировать раздел</p>
    <img src="<?=SITE_TEMPLATE_PATH?>/img/icons/linkPage.svg">
</a>
<?endif?>
<script src="<?= SITE_TEMPLATE_PATH ?>/libs/jstree/jstree.js"></script>
<link href="<?= SITE_TEMPLATE_PATH ?>/libs/jstree/themes/default/style.css" rel="stylesheet" />

<script>
    var jsTreeFiles = <?= json_encode($jsTree)?>;
    var jsTreeFilesLine = <?= json_encode($sectionLinc)?>;
    var selectedFiles = [];
	<? if(!empty($arResult["SECTION"]['UF_FILE_ID'])&&($arResult["SECTION"]['UF_FILE_ID'][0]!="0")):  ?>
    selectedFiles = <?= json_encode($arResult["SECTION"]['UF_FILE_ID'])?>;
	<? endif;?>
    console.log("jsTreeFiles", <?= json_encode($jsTree)?>);

    function showFilesModal() {
        $('#filesTree')  .on('select_node.jstree deselect_node.jstree', function (ev, node) {
            //console.log("node lms",ev);
            //console.log("node",node.node, jsTreeFilesLine);
            var mode = "select";
            if (ev.type == "deselect_node") {
                mode = "deselect";
            }
            var obj = node.node.type;

            //console.log(mode, obj);

            if (mode == "select") {
                //add to selected array
                if (obj == "file") {
                    selectedFiles.push(node.node.id);
                } else {
                    recursiveSelect(jsTreeFilesLine[node.node.id]);
                }
            } else {
                //remove from selected
                if (obj == "file") {
                    selectedFiles = selectedFiles.filter(el => el != node.node.id);
                } else {
                    recursiveDeselect(jsTreeFilesLine[node.node.id]);
                }
            }
            //unique
            selectedFiles = selectedFiles.filter(function (item, pos, self) {
                return self.indexOf(item) == pos;
            });
            console.log(selectedFiles);
        }).jstree({
            'core': {
                'data': jsTreeFiles,
            },
            'checkbox': {
                'three_state': false,
                'cascade': 'down+undetermined'
            },"types" : {
                "folder" : {
                    "icon" : "/local/templates/moskvich/img/icon/Folder.svg"
                },
                "file" : {
                    "icon" : "/local/templates/moskvich/img/icon/file-04.svg"
                }
            },
            'plugins': ['types', 'checkbox']
        })


        $("#filesModal").modal('show');
    }

    function saveModalFiles(lid) {
        $.ajax({
            type: "POST",
            url: '/content/add_files.php',
            data: {
                'lessonID': lid,
                'files': selectedFiles
            },
            success: function (response) {
                console.log(response)
                var jsonData = JSON.parse(response);
                if (jsonData.success == "1") {
                    hideModal();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('Ошибка ' + jsonData.success);
                }
            }
        });
    }

    function hideModal() {
        $("#filesModal").modal('hide');
    }

    function recursiveSelect(treeNode) {
        if (treeNode.children.length == 0) {
            return;
        } else {
            treeNode.children.forEach(el => {
                if (el.type == "file") {
                    selectedFiles.push(el.id);
                } else {
                    recursiveSelect(jsTreeFilesLine[el.id]);
                }
            })
        }
    }

    function recursiveDeselect(treeNode) {
        if (treeNode.children.length == 0) {
            return;
        } else {
            treeNode.children.forEach(el => {
                if (el.type == "file") {
                    selectedFiles = selectedFiles.filter(el2 => el2 != el.id);
                } else {
                    recursiveDeselect(jsTreeFilesLine[el.id]);
                }
            })
        }
    }
</script>
