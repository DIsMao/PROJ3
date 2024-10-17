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
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');
	//echo "<pre>";
 //print_r($arResult);
 //echo "</pre>";
if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
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
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

if ($showTopPager)
{
	?>
	<div data-pagination-num="<?=$navParams['NavNum']?>">
		<!-- pagination-container -->
		<?=$arResult['NAV_STRING']?>
		<!-- pagination-container -->
	</div>
	<?
}
// $fSections = CIBlockSection::GetList(
//     false,
//     Array("IBLOCK_ID" => 20, "ID" => $arResult['SECTION_ID'], "ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y", "SECTION_ACTIVE" => "Y"),
//     false,
//     Array("UF_*"),
//     false
// );
// // $flSections = $fSections->Fetch();
//  while($section = $fSections->GetNext())
//   {
//     // echo $ar_result['ID'].' '.$ar_result['NAME'].': '.$ar_result['ELEMENT_CNT'].'<br>';
//     $arResult['SECTION'] = $section;
//   }
// // if ($flSections['UF_TITLE']) {
// //     $APPLICATION->SetPageProperty("title", $flSections['UF_TITLE']);
// // }

// $res = CIBlockSection::GetByID($arResult['ORIGINAL_PARAMETERS']['SECTION_ID']);
// if($ar_res = $res->GetNext()){
//   $arResult['SECTION'] = $ar_res;
// }

$elem=[];
$filter = [
  /* @var int ID инфоблока */
  'IBLOCK_ID' => 46,
  /* @var int ID раздела */
  'ID' => $arResult["ORIGINAL_PARAMETERS"]["GLOBAL_FILTER"]["PROPERTY_OBJ_ID"]
];


$rsResult = CIBlockElement::GetList(
	array("SORT" => "ASC"),
    $filter,
  false,
  array(),
  array()
);
while($arResulteElem = $rsResult->GetNextElement())
{$elem=$arResulteElem->GetProperties();
    $fields=$arResulteElem->GetFields();
}

?>
 <h2 id="count_docs"></h2>
<? //echo "<pre>";
//print_r($elem);
//echo "</pre>";

	if ( !Loader::includeModule('disk') )
	{
	   throw new Exception("Не подклчюен модуль диска");
	}
	$driver = Disk\Driver::getInstance();
	$storage = \Bitrix\Disk\Storage::loadById(1462);//знаем идентификатор хранилища
   $securityContext = $driver->getFakeSecurityContext();
// $securityContext = $storage->getCurrentUserSecurityContext();


   $files = array();
   $folder = array();
   $arFolderList = [];
   $arFileList = [];
   $folder_test =[];
   if(!empty($elem['FILE_ID']["VALUE"]) && $elem['FILE_ID']["VALUE"][0] != 0):
   foreach ($elem['FILE_ID']["VALUE"] as $key => $value) {
			$files[] = \Bitrix\Disk\File::loadById($value, array('STORAGE'));
		
	}
endif;?>
	<?if(!empty($elem['FOLDER_ID']["VALUE"])):
		foreach ($elem['FOLDER_ID']["VALUE"] as $key => $value) {
	   ?>
	
		<?$folder[] = \Bitrix\Disk\Folder::loadById($value, array('STORAGE'));
		
		}
		?>
	
	   <?endif;?>
	   <?
	   if(!empty($folder)){
		foreach ($folder as $key => $value) {
		
			getRecurciveFolder( $value, $securityContext, $arFolderList );
			 }
	   }
// 	echo "<pre>";
//    print_r($arFolderList);
//    echo "</pre>";

	foreach ($arFolderList as $key => $folderList) {
		foreach ($folderList['CHILDRENS'] as $key => $file) {
			
		
		if(empty($file['IS_FOLDER'])){
			$arFileList[] = $file;
		}
		if(!empty($file['CHILDRENS'])){
			foreach ($file['CHILDRENS'] as $key => $value) {
				if(empty($value['IS_FOLDER'])){
					$arFileList[] = $value;
				}
				if(!empty($value['CHILDRENS'])){
					foreach ($value['CHILDRENS'] as $key => $second_file) {
						if(empty($second_file['IS_FOLDER'])){
							$arFileList[] = $second_file;
						}
					}
				}
			}
		}
	}
	}
// 	if ( $files[0] instanceof Disk\File )
// {
	
//    $urlManager = Disk\Driver::getInstance()->getUrlManager();
//    $downloadUrl = $urlManager->getUrlForShowFile($files[0]);
// }

//    echo "<pre>";
//    print_r($arFolderList);
//    echo "</pre>";
	?>
	<div class="files_container">
		<?foreach ($files as $key => $file) {
			$file_type = substr(strrchr($file->getName(), "."), 1);
			$userFieldsObject = Disk\Driver::getInstance()->getUserFieldManager()->getFieldsForObject($file);
// 			   echo "<pre>";
//    print_r($file);
//    echo "</pre>";
			$category = CUserFieldEnum::GetList(array(), array("ID" => $userFieldsObject['UF_FILE_CATEG']['VALUE']))->GetNext()["VALUE"];
			?>
			<a href="/disk/downloadFile/<?=$file->getId();?>/?&ncc=1&filename=<?=$file->getName();?>" class="card__document">
                                            <div class="document__img ui-icon ui-icon-file ui-icon-file-pdf">
                                            
                                            <?if($file_type == 'xls'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/XLSIcons.svg" />
                                            <?elseif($file_type == 'doc' || $file_type == 'docx'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/DocIcons.svg" />
                                            <?elseif($file_type == 'pdf'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/PDFIcon.svg" />
                                            <?else:?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/DocIconV2.svg" />
                                            <?endif;?>
                                            </div>
                                            <div class="document__block">
											<?if(!empty($category) && $category != 'Обычная'):?>
                                                <div class="document__header">
                                                    <p class="orange"><?=$category?></p>
                                                </div>
												<?endif;?>
                                                <div class="document__body">
                                                    <p><?=$file->getName();?></p>
                                                </div>
                                            </div>
											</a>
		<?}?>
		<?if(!empty($arFileList)):?>

			<?foreach ($arFileList as $key => $file) {
			$file_type = substr(strrchr($file['NAME'], "."), 1);
			// $userFieldsObject = Disk\Driver::getInstance()->getUserFieldManager()->getFieldsForObject($file);
// 			   echo "<pre>";
//    print_r($file);
//    echo "</pre>";
			$category = CUserFieldEnum::GetList(array(), array("ID" => $file['UF_FILE_CATEG']['VALUE']))->GetNext()["VALUE"];
			?>
			<a href="/disk/downloadFile/<?=$file['ID'];?>/?&ncc=1&filename=<?=$file['NAME'];?>" class="card__document">
                                            <div class="document__img ui-icon ui-icon-file ui-icon-file-pdf">
                                            
                                            <?if($file_type == 'xls'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/XLSIcons.svg" />
                                            <?elseif($file_type == 'doc' || $file_type == 'docx'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/DocIcons.svg" />
                                            <?elseif($file_type == 'pdf'):?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/PDFIcon.svg" />
                                            <?else:?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/img/icon/DocIconV2.svg" />
                                            <?endif;?>
                                            </div>
                                            <div class="document__block">
											<?if(!empty($category) && $category != 'Обычная'):?>
                                                <div class="document__header">
                                                    <p class="orange"><?=$category?></p>
                                                </div>
												<?endif;?>
                                                <div class="document__body">
                                                    <p><?=$file['NAME'];?></p>
                                                </div>
                                            </div>
											</a>
			<!-- <a href="/disk/downloadFile/<?=$file['ID'];?>/?&ncc=1&filename=<?=$file['NAME'];?>" class="file_view"><?=$file['NAME'];?></a> -->
		<?}?>

		<?endif;?>

	</div>
<?if ($USER->IsAdmin()):?>

	<button id="button" class="file_add_popup" data-page="<?=$fields["ID"]?>" data-iblock="<?=$fields['IBLOCK_ID']?>">Добавить документы</button>
	<?endif;?>
<?if ($arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y')
{?>
	<div class="bx-section-desc bx-<?=$arParams['TEMPLATE_THEME']?> page__block__text">
		<p class="bx-section-desc-post"><?=$arResult['DESCRIPTION']?></p>
	</div>
	<?
}
?>


<?IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/docs/shared/index.php");?>
<div id="overlay"></div>
<div id="popup">
    <div class="popupcontrols">
        <span id="popupclose">X</span>
    </div>
    <div class="popupcontent">
        <h1>Выберите документы</h1>
		<?$APPLICATION->IncludeComponent(
	"bitrix:disk.common",
	"disk1",
	array(
	"SEF_FOLDER" => "/docs/disk-viki/",
		"SEF_MODE" => "Y",
		"STORAGE_ID" => "1462",
		"COMPONENT_TEMPLATE" => "disk1"
	),
	false
);?>
    </div>
	<div class="picked_files">
		<h2>Выбранные файлы</h2>
		<?$files = array();
		$file_path = array();
   $arFolderList = [];
   foreach ($elem['FILE_ID']["VALUE"] as $key => $value) {
		$files[] = \Bitrix\Disk\File::loadById($value, array('STORAGE'));
		// $files[$key]['IS_FILE'] =  $arResult['SECTION']['UF_IS_FILE'][$key];
		// $files[$key]['IS_FOLDER'] =  $arResult['SECTION']['UF_IS_FOLDER'][$key];

		// $folder[] = \Bitrix\Disk\Folder::loadById($value, array('STORAGE'));
		// $folder[$key]['IS_FILE'] =  $arResult['SECTION']['UF_IS_FILE'][$key];
		// $folder[$key]['IS_FOLDER'] =  $arResult['SECTION']['UF_IS_FOLDER'][$key];



	// $files[] = \Bitrix\Disk\File::loadById($value, array('STORAGE'));
	// $file_path[] = $arResult['SECTION']['UF_FILE_PATH']['VALUE'][$key];
   }
   if(!empty($elem['FOLDER_ID']["VALUE"])):
	foreach ($elem['FOLDER_ID']["VALUE"] as $key => $value) {
   ?>

	<?
	// $folder[] = \Bitrix\Disk\Folder::loadById($value, array('STORAGE'));

	}
	?>

   <?endif;?>
   <?
   if(!empty($folder)){
	foreach ($folder as $key => $value) {

		getRecurciveFolder( $value, $securityContext, $arFolderList );
		 }
   }

//    echo "<pre>";
//    print_r($folder);
//    echo "</pre>";
	?>
		<?foreach ($files as $key => $file) {
			$file_type = substr(strrchr($file->getName(), "."), 1);
			$userFieldsObject = Disk\Driver::getInstance()->getUserFieldManager()->getFieldsForObject($file);
			$file_path =$elem['FILE_PATH']["VALUE"][$key];
			$category = CUserFieldEnum::GetList(array(), array("ID" => $userFieldsObject['UF_FILE_CATEG']['VALUE']))->GetNext()["VALUE"];
			?>
			<div class='file_item_container'><div class='bx-file-icon-container-small bx-disk-file-icon <?if($file_type == 'xls'):?>icon-xls<?elseif($file_type == 'doc' || $file_type == 'docx'):?>icon-doc<?elseif($file_type == 'pdf'):?>icon-pdf<?elseif($file_type == 'pptx'):?>icon-ppt<?else:?><?endif;?>'></div><div class='file_pick'data-is-file="true" data-is-folder="false" data-id="<?=$file->getId();?>"><?=$file->getName();?></div><div class='js-disk-breadcrumbs-folder-link'></div><div class='nav_file_item'><?=$file_path?></div><div class='file_del'>X</div></div>
		<?}?>
		<?if(!empty($folder)):?>
		<?foreach ($folder as $key => $file) {
			// $userFieldsObject = Disk\Driver::getInstance()->getUserFieldManager()->getFieldsForObject($file);
			$file_path =$elem['FOLDER_PATH']["VALUE"][$key];
			?>
			<div class='file_item_container'><div class='bx-file-icon-container-small  bx-disk-folder-icon'></div><div class='file_pick' data-is-folder="true" data-is-file="false" data-id="<?=$file['ID'];?>"><?=$file->getName();?></div><div class='js-disk-breadcrumbs-folder-link'></div><div class='nav_file_item'><?=$file_path?></div><div class='file_del'>X</div></div>
		<?}?>
		<?endif;?>

	</div>
	<button class="button_add_fele_on_page">Сохранить</button>
	<div class="results_file"></div>
</div>
<?
	/**
 * Один из примеров рекурсивной функции по созданию древовидной структуры
 * @param Disk\BaseObject $diskObject
 * @param Disk\SecurityContext $securitycontext 
 * @param array &$arFolderList 
 * @return void
 */
function getRecurciveFolder( $diskObject, $securitycontext, &$arFolderList )
{
   
   if ( $diskObject instanceof Disk\Folder )
   {
      $arFolder = [
        'ID' => $diskObject->getId(),
         'NAME'      => $diskObject->getName(),
         'PARENT_ID'      => $diskObject->getParentId(),
         'IS_FOLDER' => true,
         'CHILDRENS' => [],
      ];

      $arChildrens = $diskObject->getChildren($securitycontext);
      
      foreach ($arChildrens as $childObject)
      {
         getRecurciveFolder( $childObject, $securitycontext, $arFolder['CHILDRENS'] );
      }

      $arFolderList[] = $arFolder;
          

      
   }
   else
   {
    $userFieldsObject = Disk\Driver::getInstance()->getUserFieldManager()->getFieldsForObject($diskObject);
    
    $date = $diskObject->getCreateTime();
   $date_preview = $date->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "YYYY-MM-DD")));
   $str = strtotime($date_preview);
//    var_dump($date_preview);
   if(!empty($_GET['DATESTART']) && !empty($_GET['DATEEND'])){
    $start_date = str_replace('/','.', $_GET['DATESTART']);
    $end_date = str_replace('/','.', $_GET['DATEEND']);
    if ($arrStart = ParseDateTime($start_date, "MM.DD.YYYY"))
    {
        $normalStartDate = $arrStart["YYYY"].'-'.$arrStart["MM"].'-'. $arrStart["DD"];
        $strStart = strtotime($normalStartDate);
        // echo $normalStartDate;
        // var_dump($normalStartDate);
    }
    if ($arrEnd = ParseDateTime($end_date, "MM.DD.YYYY"))
    {
        $normalEndDate = $arrEnd["YYYY"].'-'.$arrEnd["MM"].'-'. $arrEnd["DD"];
        $strEnd = strtotime($normalEndDate);
        // echo $normalEndDate;
        // var_dump($normalEndDate);
    }
    // echo $date_preview. '-' .$normalStartDate;
    // if($normalStartDate < $date_preview){
    //     var_dump($date_preview);
    // }
    
    if($normalStartDate <= $date_preview && $normalEndDate >= $date_preview){
        // echo 'qqqqq';
        $arFolderList[] = [
            'ID'      => $diskObject->getId(),
             'NAME'      => $diskObject->getName(),
             'DATE'      => $diskObject->getCreateTime(),
             'IS_FOLDER' => false,
             'USER_PROP' => $userFieldsObject,
          ];
       }
   }else{
    $arFolderList[] = [
        'ID'      => $diskObject->getId(),
         'NAME'      => $diskObject->getName(),
         'DATE'      => $diskObject->getCreateTime(),
         'IS_FOLDER' => false,
         'USER_PROP' => $userFieldsObject,
      ];
   }
   
      
  
//       echo "<pre>";
// print_r($arFolderList);
// echo "</pre>";
   }
//    $resObjects = \Bitrix\Disk\Internals\ObjectTable::getList([
//     'select' => ['*'],
//     'filter' => [
//         '=ID' => 32,
//     ]
// ]);
// if ($arObject = $resObjects->fetch()) {
//        echo "<pre>";
//    print_r($arObject);
//    echo "</pre>";
// }

 
}

?>
<script>
   $("#count_docs").text("Документы и книги ("+ $('.card__document').length+")")
</script>
