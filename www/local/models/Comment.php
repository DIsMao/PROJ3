<?php

namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class Comment extends ElementModel
{
    public static function iblockId()
    {
        return  Blocks::Comment->value;
    }
}