<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



//Все что находится в этом if кешируется
use Bitrix\Iblock\Component\Tools;
// класс для загрузки необходимых файлов, классов, модулей
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Loader;
// подключаем приложение для обращения к глобальным сущностям ядра
use \Bitrix\Main\Application;

class RouterComponent extends CBitrixComponent
{
	// список переменных, которых также нужно получить из GET параметров, но их нет в url-маске. К примеру мы указали маску server.com/test/#SECTION_CODE#/ и в $arComponentVariables указали "SECTION", при парсинге server.com/test/section-code/?SECTION=123 в $arVariables будет SECTION_CODE и SECTION, несмотря на отсутствие SECTION в маске
	protected array $arComponentVariables = array(
		"SECTION_ID",
		"SECTION_CODE",
		"ELEMENT_ID",
		"ELEMENT_CODE",
	);

	// выполняет основной код компонента, аналог конструктора (метод подключается автоматически)
	public function executeComponent()
	{
		// подключаем модуль «Информационные блоки»
		Loader::includeModule('iblock');
		// если выбран режим поддержки ЧПУ, вызываем метод sefMode()
		if ($this->arParams["SEF_MODE"] === "Y") {
			$componentPage = $this->sefMode();
		}
		// если отключен режим поддержки ЧПУ, вызываем метод noSefMode()
		if ($this->arParams["SEF_MODE"] != "Y") {
			$componentPage = $this->noSefMode();
		}
		$currentCode="";
		if($componentPage=="element")
		{
			$currentCode=$this->arResult['VARIABLES']['ELEMENT_CODE'];

		}
		elseif($componentPage=="section")
		{
			 $currentCode=$this->arResult['VARIABLES']['SECTION_CODE'];
		}
		// отдаем 404 статус если не найден шаблон
if (empty($componentPage)||(!$this->doesExist($componentPage,$currentCode))) {
			Tools::process404(
				$this->arParams["MESSAGE_404"],
				($this->arParams["SET_STATUS_404"] === "Y"),
				($this->arParams["SET_STATUS_404"] === "Y"),
				($this->arParams["SHOW_404"] === "Y"),
			);
			return; // Exit the method early if there's no component page to display
		}

		$this->arResult["PAGE"] = Application::getDocumentRoot() . $this->arParams["~SEF_FOLDER"] . $componentPage . ".php";
		$this->IncludeComponentTemplate();



		// подключается файл php из папки комплексного компонента по имени файла, если $componentPage=section, значит подключится section.php расположенный по пути templates/.default
	}
	protected function doesExist($componentPage,$code)
	{

	if ($componentPage=="element") {
		// Check if the element exists
		$resElement = ElementTable::getList(array(
			'order' => array('SORT' => 'ASC'),
			'filter' => array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"],"CODE"=>$code),
			'count_total' => 1,
		));
		return ($resElement->getSelectedRowsCount()>0);

	} elseif($componentPage=="section")  {
		// Check if the section exists
		$resSection = SectionTable::getList(array(
			'order' => array('SORT' => 'ASC'),
			'filter' => array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"],"CODE"=>$code),
			'count_total' => 1,
		));
		return ($resSection->getSelectedRowsCount()>0);


	}

}
	// метод обработки режима ЧПУ
	protected function sefMode()
	{
		// массив предназначен для обработки HTTP GET запросов из адреса страницы, используется в режиме ЧПУ. Предназначен для задания псевдонимов из массива arParams["SEF_URL_TEMPLATES"] в вызове комплексного компонента, если нужно прокинуть GET параметр server.com/test/?ELEMENT_COUNT=1 дальше в простой компонент, в массив $arDefaultVariableAliases404 нужно добавить псевдоним, указав ключ section/element для передачи в нужный файл section.php/element.php: 'section' => array('ELEMENT_COUNT' => 'ELEMENT_COUNT'). Если нужно, чтобы в адресной строке браузера передача параметра выглядела не так: server.com/test/?ELEMENT_COUNT=1 а вот так: server.com/test/?COUNT=1. Для этого задаем псевдоним 'ELEMENT_COUNT' => 'COUNT'
		$engine = new CComponentEngine($this);
		{
			$engine->addGreedyPart("#SECTION_CODE_PATH#");
			$engine->addGreedyPart("#SMART_FILTER_PATH#");
			$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
		}
		$arDefaultUrlTemplates404 = array();
		$arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404,  $this->arParams["SEF_URL_TEMPLATES"]);
		$arDefaultVariableAliases404 =array() ;
		$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $this->arParams["VARIABLE_ALIASES"]);

		$componentPage = $engine->guessComponentPath(
			$this->arParams["SEF_FOLDER"],
			$arUrlTemplates,
			$arVariables

		);
		CComponentEngine::initComponentVariables($componentPage, $this->arComponentVariables, $arVariableAliases, $arVariables);
		$this->arResult = array(
			"FOLDER" => $this->arParams["SEF_FOLDER"],
			"URL_TEMPLATES" => $arUrlTemplates,
			"VARIABLES" => $arVariables,
			"ALIASES" => $arVariableAliases
		);
		return $componentPage;
	}
	// метод обработки режима без ЧПУ
	protected function noSefMode()
	{
		// переменная в которую запишем название подключаемой страницы
		$componentPage = "";
		// массив предназначен для обработки HTTP GET запросов из адреса страницы, используется в режиме не ЧПУ. Предназначен для задания псевдонимов из массива arParams["VARIABLE_ALIASES"] в вызове комплексного компонента, если нужно прокинуть GET параметр server.com/test/?ELEMENT_ID=1 дальше в простой компонент, в массив $arDefaultVariableAliases нужно добавить псевдоним: 'ELEMENT_ID' => 'ELEMENT_ID'. Если нужно, чтобы в адресной строке браузера передача параметра выглядела не так: server.com/test/?ELEMENT_ID=1 а вот так: server.com/test/?ID=1. Для этого задаем псевдоним 'ELEMENT_ID' => 'ID'
		$arDefaultVariableAliases = [];
		// объединение дефолтных алиасов которые приходят в arParams["VARIABLE_ALIASES"] и из массива $arDefaultVariableAliases, для определения HTTP GET запросов из адреса страницы. Параметры из настроек arrParams заменяют дефолтные
		$arVariableAliases = CComponentEngine::makeComponentVariableAliases(
		// массив псевдонимов переменных по умолчанию
			$arDefaultVariableAliases,
			// массив псевдонимов из входных параметров
			$this->arParams["VARIABLE_ALIASES"]
		);
		// массив будут заполнен переменными, которые будут найдены по маске шаблонов url
		$arVariables = [];
		// получаем значения переменных в $arVariables
		CComponentEngine::initComponentVariables(
		// файл который будет подключен section.php, element.php, index.php, для режима ЧПУ
			false,
			// массив имен переменных, которые компонент может получать из GET запроса
			$this->arComponentVariables,
			// массив псевдонимов переменных из GET запроса
			$arVariableAliases,
			// востановленные переменные
			$arVariables
		);
		// получаем контекст текущего хита
		$context = Application::getInstance()->getContext();
		// получаем объект Request
		$request = $context->getRequest();
		// получаем директорию запрошенной страницы
		$rDir = $request->getRequestedPageDirectory();
		// если запрошенная директория равна переданой в arParams["CATALOG_URL"], определяем тип страницы стартовая
		if ($arVariableAliases["CATALOG_URL"] == $rDir) {
			$componentPage = "index";
		}
		// по найденным параметрам $arVariables определяем тип страницы элемент
		if ((isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0) || (isset($arVariables["ELEMENT_CODE"]) && $arVariables["ELEMENT_CODE"] <> '')) {
			$componentPage = $this->arParams["ELEMENT_PAGE_INCLUDE"];
		}
		// по найденным параметрам $arVariables определяем тип страницы секция
		if ((isset($arVariables["SECTION_ID"]) && intval($arVariables["SECTION_ID"]) > 0) || (isset($arVariables["SECTION_CODE"]) && $arVariables["SECTION_CODE"] <> '')) {
			$componentPage = $this->arParams["SECTION_PAGE_INCLUDE"];
		}
		// формируем arResult
		$this->arResult = [
			"VARIABLES" => $arVariables,
			"ALIASES" => $arVariableAliases
		];
		return $componentPage;
	}
}
?>

