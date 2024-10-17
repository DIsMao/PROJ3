<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$strTitle = "";
?>
<?
$TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
$CURRENT_DEPTH = $TOP_DEPTH;

foreach($arResult["SECTIONS"] as $key=>$arSection)
{
$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
if ($key === array_key_first($arResult["SECTIONS"]))
{
	echo "\n","<ul class='p-0 mt-3'>";
}

else  if($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
{
	$class= ($arSection["DEPTH_LEVEL"]>3 )?"<ul class='ps-2 collapse'>":"<ul class='ps-2'>";
	echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH), $class;

}
elseif($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
{
	echo "</a>";
}
else
{
	while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"])
	{
		echo "</a class='link'>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</a>";
}

$count = $arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? "&nbsp;(".$arSection["ELEMENT_CNT"].")" : "";

if ($_REQUEST['SECTION_ID']==$arSection['ID'])
{
	$link =  '<a  class="link orange" href="'."?SECTION_ID=".$arSection["ID"].'">'.$arSection["NAME"]. $count.'</a>';;
	$strTitle = $arSection["NAME"];
}
else if ($key === array_key_first($arResult["SECTIONS"]))
{ 	$class= ($_GET["SECTION_FIRST"]=="Y")?"<a class='link orange' href='?SECTION_FIRST=Y'>" :"<a class='link' href='?SECTION_FIRST=Y'>";

	$link = $class.$arSection["NAME"].'</a>';;
}
else
{
	$link =  '<a  class="link"  href="'."?SECTION_ID=".$arSection["ID"].'">'.$arSection["NAME"]. $count.'</a>';
}

echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
?>
<?

$arFilter = array(
        'IBLOCK_ID' => $arSection["IBLOCK_ID"],
    'ID' => $arSection["ID"],
    );
$arSelect = array('ID', "UF_GUID_DEP");
$rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect);
while($item = $rsSection->Fetch()) {

    $GUID = $item["UF_GUID_DEP"];
}

$rsGroups = CGroup::GetList($by = "c_sort", $order = "asc", array("STRING_ID"=>$GUID));
$id="";
if(intval($rsGroups->SelectedRowsCount()) > 0)
{
}
while($arGroups = $rsGroups->Fetch())
{
    if ($arGroups["STRING_ID"]==$GUID)
        {    echo $arSection["NAME"];

			$id=$arGroups["ID"];
		}

}

?>
<li  class="mb-0" id="<?=$id?>" style="list-style: none"><?=$link?>

    <?

	$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
	$id="";
	}


	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "</a>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
    <script>
        let active=$(".orange");
        active.next("ul").removeClass('collapse')
        active.parents("ul").removeClass('collapse')
        console.log(<?= json_encode ($arResult)  ?>)
    </script>
