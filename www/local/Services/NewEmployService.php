<?php

namespace Adamcode\Services;

use Adamcode\Models\NewEmployee;
use Adamcode\Util\EmployeeUtils;

class NewEmployService


{	private array  $employArr=[];
	private array $select;
	private int $limit;

	/**
	 * @param array $select
	 * @param int $limit
	 */
	public function __construct(array $select, int $limit=0)
	{
		$this->select = $select;
		$this->limit = $limit;
	}

	private    function  prepareArr()
{
	foreach ($this->employArr as $key => $emp)
	{ if (empty($emp["employee"]))
	{
		$empInfo = new EmployeeUtils(0);
	}
	else{

		$empInfo = new EmployeeUtils($emp["employee"]["ID"]);
	}
		$this->employArr [$key]["PHOTO"] = $empInfo->get_info()["PHOTO"];

	}
	return  $this->employArr;
}
 public  function getItems()
 {
	 $newEmployeesCollection=NewEmployee::query()->select($this->select)
		 ->sort(["PROPERTY_DATE"=>"DESC"])->with([
		 'employee' => function ($query) {
			 $query->select(["ID","DETAIL_PAGE_URL",""]);
		 }]);
	 if (!empty($this->limit))
	 {
		 $newEmployeesCollection=$newEmployeesCollection->limit($this->limit)->getList();
	 }
	 else
	 {
		 $newEmployeesCollection=$newEmployeesCollection->getList();
	 }
	 foreach ($newEmployeesCollection as $item)
	 {
		 $this->employArr[]=$item->toArray();
	 }

	 return self::prepareArr();
 }
}