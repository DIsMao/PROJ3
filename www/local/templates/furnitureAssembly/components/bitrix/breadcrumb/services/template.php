<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die()?>


<?global $APPLICATION;
$new_link=array('TITLE'=> "Сервисы",'LINK'=>"/pages/services/");
$service = array_pop($arResult);
$arResult[1] = $new_link;
$arResult[2] = $service;
//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}

$strReturn .= '<div class="col p-0" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<ul class="breadсrumbs" style="
display: inline-flex;
padding: 0;
white-space: nowrap;
margin-bottom: 20px;
list-style: none;

">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '			
				<li style="
					margin-right: 8px;
					margin-bottom: 0;
				">
				<a class="breadсrumb" href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<a class="breadсrumb">/</a>
				</li>
			
				<meta itemprop="position" content="'.($index + 1).'">
		';
	} else {
		$strReturn .= '	<li style="
		margin-right: 8px;
		margin-bottom: 0;
	">
		<a class="breadсrumb" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="item">
					<span itemprop="name">' . $title . '</span>
				</a>
				</li>
				</ul>
				</div>';
			
	}
}


return $strReturn;


