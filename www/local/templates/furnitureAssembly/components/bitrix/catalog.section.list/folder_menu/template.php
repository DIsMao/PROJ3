123<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
	if ((($arSection['RIGHT_MARGIN'] - $arSection['LEFT_MARGIN']) <1)||($key===array_key_first($arResult["SECTIONS"])))
	{
		echo "\n","<ul class='two__tier__list'>";
	}
        else if ((($arSection['RIGHT_MARGIN'] - $arSection['LEFT_MARGIN']) >1))
    {
			echo "\n","<ul class='two__tier__list__col'>";
    }

    
		elseif($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
		{
			echo "</li>";
		}
		else
		{
			while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"])
			{
				echo "</a class='link'>";
				echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul></li>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
				$CURRENT_DEPTH--;
			}
			echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</a>";
		}

		$count = $arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? "&nbsp;(".$arSection["ELEMENT_CNT"].")" : "";
	$arFilter = Array(
		"IBLOCK_ID"=>$arResult["IBLOCK_ID"],
		"SECTION_ID"=>$arSection['ID']
	);
    $count_sec=CIBlockSection::GetCount($arFilter);
		if ($_REQUEST['SECTION_ID']==$arSection['ID'])
		{if ($count_sec>0)
		{
			$link = '<p  class="link  active">'.
				'<img class="link__img" src="/local/templates/moskvich/img/icon/CaretRight.svg" style="user-select: text;">'.
				'<img class="link__img" src="/local/templates/moskvich/img/icon/Folder.svg" style="user-select: text;">'.
				 '<a  class="link__title " href="'.$arSection["SECTION_PAGE_URL"].'"> '.$arSection["NAME"].'</a>'.

				'</p>';
		}
        else{
			$link = '<p  class="link  active">'.
				'<img class="link__img" src="/local/templates/moskvich/img/icon/CaretRight.svg" style="user-select: text;">'.
				'<img class="link__img" src="/local/templates/moskvich/img/icon/Folder.svg" style="user-select: text;">'.
				'<a  class="link__title " href="'.$arSection["SECTION_PAGE_URL"].'"> '.$arSection["NAME"].'</a>'.

				'</p>';
        }

		}
		else
		{
				if ($count_sec > 0)
				{
					$link = '<p  class="link">'.
						'<img class="link__img" src="/local/templates/moskvich/img/icon/CaretRight.svg" style="user-select: text;">'.
						'<img class="link__img" src="/local/templates/moskvich/img/icon/Folder.svg" style="user-select: text;">'.
						'<a  class="link__title " href="'.$arSection["SECTION_PAGE_URL"].'"> '.$arSection["NAME"].'</a>'.
                        '</p>';
				} else
				{
					$link = '<p  class="link">'.
						'<img class="link__img" src="/local/templates/moskvich/img/icon/CaretRight.svg" style="user-select: text;">'.
						'<img class="link__img" src="/local/templates/moskvich/img/icon/Folder.svg" style="user-select: text;">'.
						'<a  class="link__title " href="'.$arSection["SECTION_PAGE_URL"].'"> '.$arSection["NAME"].'</a>'.

						'</p> 

'
                   ;
				}
		}
		echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
		?><li  class="" id="<?=$this->GetEditAreaId($arSection['ID']);?>" style="list-style: none"><?=$link?><?

		$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
	}


	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "</a>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
<script>
   $("a.link.active").parents("li").each(function (){
        $(this).addClass("active")
    })
	</script>