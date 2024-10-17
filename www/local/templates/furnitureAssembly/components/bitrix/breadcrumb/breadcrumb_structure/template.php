<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die()?>


<?global $APPLICATION;

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

$strReturn .= '<div class=" p-0" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<ul class="breadcrumbs">
    <li  id="first" style=" margin-right:15px; user-select: auto;">
                        <a class="breadcrumb__home breadcrumb" href="/" style="user-select: auto;"> Главная</a>
                    </li>';

$itemSize = count($arResult);

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)


	{
		if ($title == "Москвич")
		{
			continue;
		}
		$strReturn .= '			
				<li> 
				<a class="breadcrumb " href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="item">
					' . $title . '</span>
				</a>
				</li>
			
				<meta itemprop="position" content="' . ($index + 1) . '">
		';
	}


	else {

		if ($title == "Москвич")
		{
			$strReturn .= '	
				</ul>
				</div>
			';;
		}
		else
		{
			$strReturn .= '	<li >
		<a class="breadcrumb active" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="item">
					 	'.$title.'</span> 
				</a>
				</li>
				</ul>
				</div>';
		}

	}


}

return $strReturn;

