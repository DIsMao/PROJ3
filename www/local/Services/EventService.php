<?php

namespace Adamcode\Services;

use Adamcode\Models\Event;
use Adamcode\Models\NewEmployee;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Bizproc\Workflow\Template\Packer\Result\Pack;
use DateTime;

class EventService

{ private  array $events=[];
public    function findCategories()
{$uniqueCategories = [];
	foreach ($this->events as $item)
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
	public    function prepareEvents(&$arr)
	{

		foreach ($arr as &$event)
		{

			$event["PROPERTY_DATE_OPEN_FORMATTED_VALUE"] = FormatDate("d.m.Y", MakeTimeStamp($event['PROPERTY_DATE_OPEN_VALUE']));
			$event["PROPERTY_DATE_CLOSE_FORMATTED_VALUE"] = FormatDate("d F", MakeTimeStamp($event['PROPERTY_DATE_CLOSE_VALUE']));
			$event["PROPERTY_DATE_TIME_CLOSE_VALUE"] = ConvertDateTime($event['PROPERTY_DATE_CLOSE_VALUE'], "HH:Mi", "ru");
			$event["PROPERTY_DATE_TIME_OPEN_VALUE"] = ConvertDateTime($event['PROPERTY_DATE_OPEN_VALUE'], "HH:Mi", "ru");
			foreach ($event["PROPERTY_SUBBED_VALUE"] as  $key=>$item)
			{ if ($key>=3)
			{
				break;
			}
				$event["PROPERTY_SUBBED_INFO"][] = (new EmployeeUtils($item))->get_info(true);

			}
		}

		return $arr;
	}
	public    function findTypeEvents( $limit="")
	{$events=[];
			$events["ACTIVE"]=$this->findEvents([ ">=PROPERTY_DATE_CLOSE" => date("Y-m-d")],$limit);
$this->prepareEvents($events["ACTIVE"]);
		$events["ARCHIVE"]=$this->findEvents([ "<PROPERTY_DATE_OPEN" => date("Y-m-d")],$limit);
		$this->prepareEvents($events["ARCHIVE"]);
		return $events;

	}

	public    function findEvents($filter=[],$limit="")
{
	$eventsCollection=Event::query()->select(["NAME",'SHOW_COUNTER',"DETAIL_PAGE_URL","PROPERTY_CATEGORY","PROPERTY_DATE_OPEN","PROPERTY_DATE_CLOSE","PROPERTY_SUBBED","PREVIEW_PICTURE"])->filter($filter)->sort(["PROPERTY_DATE_CLOSE"=>"ASC"])->with([
		'categories' => function ($query) {
			$query->select(["NAME"]);
		}]);
	if (!empty($limit))
	{
		$eventsCollection=$eventsCollection->limit($limit)->getList();
	}
	else
	{
		$eventsCollection=$eventsCollection->getList();
	}
	$events=array();
	foreach ($eventsCollection as $item)
	{
		$events[]=$item->toArray();
	}
	$this->events= $events;
	return $events;
}
	static public function getSubbed(  int $id)
	{
 $subbed=[];
 $event=Event::getById($id);
		$event->load();
 $event->refresh();
		foreach ($event->subbed as $item)
		{
$subbed[]= (new EmployeeUtils($item["ID"]))->get_info(true);
		}
		return $subbed;
	}

	 static public function getEventsFilter(array $getParams) {
	

		if (isset($getParams['CATEGORY_ID'])) {
			$arrFilterEvents['PROPERTY_CATEGORY'] = $getParams['CATEGORY_ID'];
		}

		if (!empty($getParams['DATESTART']) &&!empty($getParams['DATEEND'])) {
			$arrStart = ParseDateTime($getParams['DATESTART'], "YYYY-MM-DD");
			$normalStartDate = date($getParams['DATESTART']. ' 00:00:00');

			$arrEnd = ParseDateTime($getParams['DATEEND']. "YYYY-MM-DD");
			$normalEndDate = date($getParams['DATEEND']. ' 23:59:59');

			$arrFilterEvents['>=PROPERTY_DATE_OPEN'] = $normalStartDate;
			$arrFilterEvents['<=PROPERTY_DATE_CLOSE'] = $normalEndDate;
		}

		if (isset($getParams['year']) && isset($getParams['month'])) {
			$monthStart = $getParams['month'];

			if ($monthStart === '02') {
				$start = $getParams['year']. '-'. $monthStart. '-01';
				$end = $getParams['year']. '-'. $monthStart. '-29';
			} else {
				$start = $getParams['year']. '-'. $monthStart. '-01';
				$end = $getParams['year']. '-'. $monthStart. '-31';
			}

			$arrFilterEvents['>=PROPERTY_DATE_OPEN'] = $start;
			$arrFilterEvents['<=PROPERTY_DATE_OPEN'] = $end;
		}

		return $arrFilterEvents;
	}
	public function getMounthArray()
{
	$monthsArray = array();
	$months = Array('01' => "Январь", '02' => "Февраль", '03'=> 'Март' , '04'=> 'Апрель' , '05'=> 'Май', '06'=> 'Июнь' , '07'=> 'Июль', '08' => 'Август' , '09' => 'Сентябрь' , 10 => 'Октябрь' , 11 => 'Ноябрь' , 12 => 'Декабрь' );
	foreach ($this->events as $item)
	{
		if (!empty($item["PROPERTY_DATE_OPEN_VALUE"])) {
			$date=$item["PROPERTY_DATE_OPEN_VALUE"];
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