<?

use Adamcode\Config\Blocks;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/pages/anketaStart/css/style.css", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/pages/anketaStart/js/script.js");
$APPLICATION->SetTitle("Анкета старт");
CModule::IncludeModule("iblock");
?>
    <main class="py-20">
        <div class="container mx-auto grid grid-cols-[78%_20%] gap-7">
            <div class="flex flex-col gap-8">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "breadcrumb",
                    array(
                        "START_FROM" => "1",
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "COMPONENT_TEMPLATE" => "breadcrumb"
                    ),
                    false
                );?>

                <?
                global $USER;
                $arr = [];
                $arSelect = array("ID", "IBLOCK_ID",'ACTIVE', "NAME", "PROPERTY_*");
                $arFilter = [
                    "IBLOCK_ID" => Blocks::anceti->value, 'ACTIVE' => "Y", 'PROPERTY_USER' => $USER->GetID()
                ];
                $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
                while($ob = $res->GetNextElement()) {
                    $Fields = $ob->GetFields();
                    $Prop = $ob->GetProperties();

                    $arr = $Prop;
                }
                if(!empty($arr)){
                    require("anketaData.php");
                }else{
                    require("anketaForm.php");
                }

                ?>
            </div>
            <div class="flex flex-col gap-16 mt-[4.25rem]">
                <div class="flex flex-col gap-6">
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Package.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Заказы</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Phone.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Диспетчерская</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Coins.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Зарплаты</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Garage.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Склад</a>
                    </div>
                    <div class="flex gap-3"><img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/ClipboardText.svg"><a class="font-montserrat font-semibold text-base hover:text-[#7a5bca]" href="#">Справочник</a>
                    </div>
                </div>
            </div>
        </div>
    </main>


<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>