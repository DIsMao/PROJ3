<?php


use Bitrix\Main\Context;
use Bitrix\Main\SystemException;
use Bitrix\Main\UI\PageNavigation;

class ElementListComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        CPageOption::SetOptionString("main", "nav_page_in_session", "N");
        $this->getResult();


    }



    protected function getResult() {
        if ($this->arParams['PAGINATION']=="Y")
        {
            $rs = new CDBResult();
            $rs->InitFromArray($this->arParams["DATA"]);
            $rs->NavStart($this->arParams['ITEM_COUNT'], false);
            while ($item = $rs->Fetch())
            {
                $this->arResult['ITEMS'][] = $item;
            }
            $this->arResult['NAV_STRING'] = $rs->GetPageNavStringEx($rs, "", $this->arParams["PAGER_TEMPLATE"]);

        }
        else{
            if((array_key_exists("ITEM_COUNT",$this->arParams))&&(!empty($this->arParams["DATA"]))&&(!empty($this->arParams["ITEM_COUNT"])))
            {
                $this->arParams["DATA"] = array_slice($this->arParams["DATA"], 0, (int)$this->arParams['ITEM_COUNT']);

            }
            $this->arResult['ITEMS'] =$this->arParams["DATA"];
        }
        $this->arResult['ADIT']=$this->arParams["ADIT"];

        $this->includeComponentTemplate();
    }
}
