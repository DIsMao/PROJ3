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
			echo "\n","<ul class='ps-0'>";
    }
       else  if($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
		{
			echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH),"<ul>";
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
			$link =  '<a  class="link orange" href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a>';;
			$strTitle = $arSection["NAME"];
		}
		else
		{
			$link = '<a  class="link" href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a>';
		}

		echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
		?><li  class="mb-0" id="<?=$this->GetEditAreaId($arSection['ID']);?>" style="list-style: none"><?=$link?><?

		$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
	}
	

	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "</a>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
