<?
namespace Prominado\Components;
use Adamcode\Models\Employee;
use Adamcode\Config\Blocks;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use CIBlockElement;

\Bitrix\Main\Loader::includeModule("highloadblock");
class AjaxChangePhoto extends \CBitrixComponent implements Controllerable
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
public function changePhotoAction($photo)
{
    \CModule::IncludeModule("iblock");
    global $USER;

        $rsElement = new CIBlockElement;
        $arFields = array(
            "ACTIVE" => "Y",
            "IBLOCK_ID"      => Blocks::ModerationPhoto->value,
            "NAME" => $USER->GetFullName(),
            "PREVIEW_PICTURE" => $photo["croppedImage"],
            "PROPERTY_VALUES" => array(

                "USER" => $USER->GetID()

            )
        );
        $rsElement->Add($arFields);



}

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

}