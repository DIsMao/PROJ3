<?php

namespace Adamcode\Services;

use Adamcode\Models\NewsItem;

class NewsService

{ private  array $news=[];

	public    function findCategories()
{$uniqueCategories = [];
	foreach ($this->news as $item)
	{
		foreach ($item["categories"] as $category)
		{	$uniqueCategories[$category['NAME']]["ID"]=$category["ID"];
				if (!isset($uniqueCategories[$category['NAME']]))
				{
					$uniqueCategories[$category['NAME']] = ['COUNT' => 1];
				} else
				{
					$uniqueCategories[$category['NAME']]['COUNT']++;
				}
		}
	}
 return $uniqueCategories;

}

	public    function findNews($filter=[],$limit="")
	{
		$newsCollection=NewsItem::query()->select(["NAME",'SHOW_COUNTER',"DETAIL_PAGE_URL","PROPERTY_CATEGORY","PROPERTY_DATE","PREVIEW_PICTURE"])->filter($filter)->sort(["PROPERTY_DATE"=>"DESC"])->with([
			'categories' => function ($query) {
				$query->select(["NAME"]);
			}]);
		if (!empty($limit))
		{
			$newsCollection=$newsCollection->limit($limit)->getList();
		}
		else
		{
			$newsCollection=$newsCollection->getList();
		}
		$news=array();
		foreach ($newsCollection as $item)
		{
			$news[]=$item->toArray();
		}
		$this->news= $news;
		return $news;
	}


	public function getMounthArray()
	{
		$monthsArray = array();
		$months = Array('01' => "Январь", '02' => "Февраль", '03'=> 'Март' , '04'=> 'Апрель' , '05'=> 'Май', '06'=> 'Июнь' , '07'=> 'Июль', '08' => 'Август' , '09' => 'Сентябрь' , 10 => 'Октябрь' , 11 => 'Ноябрь' , 12 => 'Декабрь' );
		foreach ($this->news as $item)
		{
			if (!empty($item["PROPERTY_DATE_VALUE"])) {
				$date=$item["PROPERTY_DATE_VALUE"];
				$year = date("Y", strtotime($date));
				$monthId = date("m", strtotime($date));
				$monthName =$months[$monthId];
				$newMounth=["monthName" => $monthName,
					"year" => $year,
					"monthId" => $monthId];
				if( !in_array($newMounth,$monthsArray))
				{
					$monthsArray[] = $newMounth;
				}
	}


}
		return $monthsArray;
}
}