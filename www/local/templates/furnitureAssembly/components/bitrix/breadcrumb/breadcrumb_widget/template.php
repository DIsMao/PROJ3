<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die() ?>

<? global $APPLICATION;
$arResult[0]['TITLE'] = 'Оргструктура';
$arResult[0]['LINK'] = '/structure/koulstar/';

//delayed function must return a string
if (empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if (!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css)) {
	$strReturn .= '<link href="' . CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css") . '" type="text/css" rel="stylesheet" />' . "\n";
}

$strReturn .= '<div  id="navigation" class="col p-0" itemprop="itemListElement"  itemscope itemtype="http://schema.org/ListItem">
<ul class="breadсrumbs"  id="navigation"  style="
display: block;
margin-top: 10px;
list-style: none;
">';
$itemSize = count($arResult);
$base = 0;
for ($index = 0; $index < $itemSize; $index++) {
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0 ? '<i class="fa fa-angle-right"></i>' : '');

	if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
		$strReturn .= '			
				<li style="margin-right:8px; margin-bottom:0;">
				<a class="breadcrumb" style=" margin-left:' . $base . '%" href='.htmlspecialcharsex($arResult[$index]["LINK"]).' title="' . $title . '" itemprop="item">
				' . $title . '
				</a>
				</li>
			
				<meta itemprop="position" content="' . ($index + 1) . '">
		';
	} else {
		$strReturn .= '<li style="margin-right:8px; margin-bottom:0;">

		<a class="breadcrumb" style=" margin-left:' . $base . '%" href='.htmlspecialcharsex($arResult[$index]["LINK"]).' title="' . $title . '" itemprop="item">
		' . $title . '</a>
				</li>
				</ul>
				</div>';

	}
	$base = $base + 5;
}
$strReturn .= '<div style="clear:both"></div></div>';

return  $strReturn;