<?php

namespace Adamcode\Services;

use Adamcode\Models\Gratitudes;
use Adamcode\Util\EmployeeUtils;

class GratitudesService


{	private array  $employArr=[];
	private array $select;
	private int $limit;

	/**
	 * @param array $select
	 * @param int $limit
	 */
	public function __construct(array $select,array $filter, int $limit=0)
	{
		$this->select = $select;
        $this->filter = $filter;
		$this->limit = $limit;
	}

	private    function  prepareArr()
{
	foreach ($this->employArr as $key => $emp)
	{ if (empty($emp["employeeFor"]))
	{
		$empInfo = new EmployeeUtils(0);
	}
	else{
		$empInfo = new EmployeeUtils($emp["employeeFor"]["ID"]);
	}

        if (empty($emp["employeeFrom"]))
        {
            $empInfo2 = new EmployeeUtils(0);
        }
        else{
            $empInfo2 = new EmployeeUtils($emp["employeeFrom"]["ID"]);
        }

		$this->employArr [$key]["employeeFor"]["EPHOTO"] = $empInfo->get_info()["PHOTO"];
        $this->employArr [$key]["employeeFrom"]["EPHOTO"] = $empInfo2->get_info()["PHOTO"];
	}
	return  $this->employArr;
}
 public  function getItems()
 {
	 $userCollection=Gratitudes::query()->select($this->select)
         ->filter($this->filter)
		 ->sort(["PROPERTY_DATE_TIME"=>"DESC"])->with(['employeeFor', "employeeFrom"]);
	 if (!empty($this->limit))
	 {
		 $userCollection=$userCollection->limit($this->limit)->getList();
	 }
	 else
	 {
		 $userCollection=$userCollection->getList();
	 }
	 foreach ($userCollection as $item)
	 {
		 $this->employArr[]=$item->toArray();
	 }

	 return self::prepareArr();
 }
}