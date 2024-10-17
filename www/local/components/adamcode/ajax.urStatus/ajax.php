<?


require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
use Adamcode\Config\Blocks;
use Adamcode\Util\CommonUtils;

use \Bitrix\Main\Application;

    \CModule::IncludeModule("iblock");



$arr = Application::getInstance()->getContext()->getRequest()->toArray();

global $USER;
$user_id = $USER->GetID();
$rsUser = CUser::GetByID($user_id);

foreach ($_FILES["file"]["name"] as $key => $value) {

    $fileName = $_FILES["file"]["name"][$key];
    $fileTmpName = $_FILES["file"]["tmp_name"][$key];
    $fileType = $_FILES["file"]["type"][$key];

    $file = CFile::MakeFileArray($fileTmpName);
    $file['name'] = $fileName;

    $currentFiles[] = $file;
}

$arUser = $rsUser->Fetch();
$fields = Array(
    "UF_STATUS" => $arr["UF_STATUS"],
    "UF_UR_STATUS_DESC" => $arr["UF_UR_STATUS_DESC"],
    "UF_UR_STATUS_FILES" => $currentFiles,

);
$user = new CUser;
$user->Update($user_id, $fields);
if($user->LAST_ERROR){
    echo $user->LAST_ERROR;
}else{
    echo "true";
}

