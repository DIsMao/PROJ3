<? namespace Prominado\Components;

use Adamcode\Config\Blocks;
use Adamcode\Config\Idea;
use Adamcode\Models\Employee;
use Adamcode\Models\Like;
use Adamcode\Models\Rating;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Mail\Event;
use CBitrixComponent;
use CEvent;
use CIBlockElement;
use CModule;


class AjaxCongrat extends CBitrixComponent implements Controllerable
{
// Обязательный метод
	public function configureActions()
	{
// Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
// Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
		return [
			'sendMessage' => [ // Ajax-метод
				'prefilters' => [],
			],
		];
	}

// Ajax-методы должны быть с постфиксом Action
	public function ratingAction($objId, $rating, $parent)
	{
        CModule::IncludeModule("iblock");
		$res = Rating::filter(["PROPERTY_OBJ_ID" => $objId, "PROPERTY_USER_ID" => CurrentUser::get()->getId()])->select(["ID"])->getList();
		if (!$res->isEmpty())
			$PROP = array();
		$PROP['USER_ID'] = CurrentUser::get()->getId();
		$PROP['OBJ_ID'] = $objId;
		$PROP['RATING'] = $rating;
		$PROP['PARENT'] = $parent;

		$PROP['DATE'] = date('d.m.Y');
		$el = new CIBlockElement;
		if ($res->isEmpty())
		{

			$arLoadProductArray = array(
				"MODIFIED_BY" => CurrentUser::get()->getId(),
				"IBLOCK_SECTION_ID" => false,
				"IBLOCK_ID" => Blocks::Rating->value,
				"PROPERTY_VALUES" => $PROP,
				"NAME" => "Рейтинг",
				"ACTIVE" => "Y",
			);
			$PRODUCT_ID = $el->Add($arLoadProductArray);
		} else
		{
			$ratingElement = $res->first()->toArray();
			$ELEMENT_ID = $ratingElement["ID"];

			CIBlockElement::SetPropertyValues($ELEMENT_ID, Blocks::Rating->value, $PROP);
		}
		$ratingOb = Rating::filter(["ACTIVE" => "Y", 'PROPERTY_OBJ_ID' => $objId])->getList()->toArray();
		$arrayRating = [];

		foreach ($ratingOb as $rating)
		{
			$arrayRating[] = $rating["PROPERTY_RATING_VALUE"];
		}
		$rating = 0;
		if (!empty($arrayRating))
		{
			$rating = array_sum($arrayRating) / count($arrayRating);

		}
		return json_encode($rating);

	}

	function likeAction($objId, $parent, $status)
	{
		CModule::IncludeModule('iblock');
		$el = new CIBlockElement;
		if ($status == "Поставить лайк")
		{
			$PROP = array();
			$PROP['USER_ID'] = CurrentUser::get()->getId();
			$PROP['OBJ_ID'] = $objId;
			$PROP['BLOG_ID'] = $parent;
			$PROP['DATE'] = date('d.m.Y');
			$arLoadProductArray = array(
				"MODIFIED_BY" => CurrentUser::get()->getId(),
				"IBLOCK_SECTION_ID" => false,
				"IBLOCK_ID" => Blocks::IdeaLikes->value,
				"PROPERTY_VALUES" => $PROP,
				"NAME" => "Лайк",
				"ACTIVE" => "Y"
			);
			$PRODUCT_ID = $el->Add($arLoadProductArray);

		} elseif ($_POST['status'] == "Убрать лайк")
		{

			$res =  Like::filter([ "PROPERTY_USER_ID" => CurrentUser::get()->getId(), 'PROPERTY_OBJ_ID' => $objId, "PROPERTY_PARENT" => Idea::Blog->value])->first();
			CIBlockElement::Delete($res['ID']);
		}


	}

	public function executeComponent()
	{
		$this->includeComponentTemplate();
	}
}