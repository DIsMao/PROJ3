<?php
namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class ModerationPhoto  extends ElementModel

{	public static $fetchUsing = 'GetNext';

    /**
     * Corresponding iblock id.
     *
     * @return int
     */
    public static function iblockId()
    {
        return  Blocks::ModerationPhoto->value;
    }
    public function scopeActive($query)
    {
        $query->filter['ACTIVE'] = 'Y';

        return $query;
    }

}?>