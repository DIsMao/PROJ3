<?php
namespace Adamcode\Models;
use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;

class NewEmployee  extends ElementModel

{
	/**
	 * Corresponding iblock id.
	 *
	 * @return int
	 */
	public static function iblockId()
	{
		return  Blocks::NewEmployee->value;
	}
	public function employee()
	{
		return $this->hasOne(Employee::class, "ID","PROPERTY_ELEMENT_VALUE");
	}
}?>