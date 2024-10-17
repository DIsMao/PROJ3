<?php
namespace Adamcode\Models;
use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class Gratitudes  extends ElementModel

{
	/**
	 * Corresponding iblock id.
	 *
	 * @return int
	 */
	public static function iblockId()
	{
		return  Blocks::Gratitudes->value;
	}
	public function employeeFor()
	{
		return $this->hasOne(Employee::class, "ID","PROPERTY_FOR_VALUE");
	}
    public function employeeFrom()
    {
        return $this->hasOne(Employee::class, "ID","PROPERTY_FROM_VALUE");
    }
}?>