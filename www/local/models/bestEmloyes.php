<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class bestEmloyes extends ElementModel
{
    public static function iblockId()
    {
        return  Blocks::zBestEmloy->value;
    }
    public function GROUP()
    {
        return $this->hasOne(BestEmployesGroups::class, "ID","PROPERTY_GROUP_VALUE");
    }
}