<?php

namespace Adamcode\Services;

use Adamcode\Models\MainSliderItem;
use CFile;
class MainSliderService


{	private array  $slideArr=[];
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


    public  function getItems()
    {
        $slidelideeesCollection=MainSliderItem::query()->select($this->select)
            ->sort(["SORT"=>"ASC"]);
        if (!empty($this->limit))
        {
            $slidelideeesCollection=$slidelideeesCollection->limit($this->limit)->getList();
        }
        else
        {
            $slidelideeesCollection=$slidelideeesCollection->getList();
        }
        foreach ($slidelideeesCollection as $item)
        {
            $item["DETAIL_PICTURE"] = CFile::GetPath($item["DETAIL_PICTURE"]);
            $this->slideArr[]=$item->toArray();

        }

        return $this->slideArr;
    }
}