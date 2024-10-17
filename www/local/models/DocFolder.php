<?



namespace Adamcode\Models;

use Adamcode\Config\Blocks;
use Arrilot\BitrixModels\Models\SectionModel;
class DocFolder extends SectionModel
{
	public static $fetchUsing = 'GetNext';

	public static function iblockId()
	{
		return Blocks::Docs->value;
	}
}