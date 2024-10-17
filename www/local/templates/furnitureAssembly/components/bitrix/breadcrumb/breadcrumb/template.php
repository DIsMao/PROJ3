<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die()?>


<?global $APPLICATION;
//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();


$strReturn .= '<div class="flex gap-2">
    <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-primary" href="/">Главная</a>
        <p class="font-montserrat font-semibold text-base">/</p>
    </div>';

$itemSize = count($arResult);

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)


			$strReturn .= '
			    <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-primary" 
			    href="'.$arResult[$index]["LINK"].'"
			    title="'.$title.'"
			    >'.$title.'</a>
        <p class="font-montserrat font-semibold text-base">/</p>
    </div>
			
				<meta itemprop="position" content="'.($index + 1).'">
		';


	else {

		$strReturn .= '
				    <div class="flex gap-1"><a href="' . $arResult[$index]["LINK"] . '"
				     class="font-montserrat font-semibold text-base text-gray-400"
				     title="' . $title . '"
				     
				     >'.$title.'</a>
				     </div>
    </div>
				';;
	}


}

return $strReturn;

?>

<!--<div class="flex gap-2">-->
<!--    <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-primary" href="#">Главная</a>-->
<!--        <p class="font-montserrat font-semibold text-base">/</p>-->
<!--    </div>-->
<!--    <div class="flex gap-1"><a class="font-montserrat font-semibold text-base hover:text-primary" href="#">Заказы</a>-->
<!--        <p class="font-montserrat font-semibold text-base">/</p>-->
<!--    </div>-->
<!--    <div class="flex gap-1"><a class="font-montserrat font-semibold text-base text-gray-400">№ СП4815</a>-->
<!--    </div>-->
<!--</div>-->
