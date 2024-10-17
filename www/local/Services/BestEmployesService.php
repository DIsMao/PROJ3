<?php

namespace Adamcode\Services;

use Adamcode\Models\bestEmloyes;

use Adamcode\Util\EmployeeUtils;

class BestEmployesService

{
	public function getList($select, $filter)
	{


        $list = bestEmloyes::query()->filter($filter)->select($select)->sort(["PROPERTY_YEAR"=>"DESC", "PROPERTY_MONTH"=>"DESC"])->with(['GROUP'])->getList()->toArray();

        $res = [];
        foreach ($list as $key => $item) {
            $res[$item["PROPERTY_YEAR_VALUE"]][$item["PROPERTY_MONTH_VALUE"]][] = $item;
        }

		return $res;
	}
    public function getListMain($select, $filter)
    {

        $list = bestEmloyes::query()->filter($filter)->select($select)->sort(["PROPERTY_YEAR"=>"DESC", "PROPERTY_MONTH"=>"DESC"])->with(['GROUP'])->getList()->toArray();

        return $list;
    }

}