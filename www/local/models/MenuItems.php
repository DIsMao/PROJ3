<? namespace Adamcode\Models;
use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\ElementModel;


class MenuItems  extends ElementModel

{
/**
* Corresponding iblock id.
*
* @return int
*/
	public static function iblockId()
	{
		return  Blocks::Menu->value;
	}

}?>