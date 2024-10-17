<?php


namespace Adamcode\Services;



use Adamcode\Models\DocFolder;
use Adamcode\Models\DocItem;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Main\HttpRequest;

class DocLibraryServices

{	public HttpRequest   $request;

	private ?array $tree = [];
	private array $files=[];
	private array $order=[];

	public function getRequest(): HttpRequest
	{
		return $this->request;
	}

	private array $filter=[];

	private array $typeNames= [
	"Word" => ["doc", "docx"],
	"Excel" => ["xls", "xlsx"],
	"PowerPoint" => ["pptx"],
	"PDF" => ["pdf"]
];

	/**
	 * @param $request
	 */
	public function __construct($request)
	{
		$this->request = $request;
	}

	public function getTypeNames(): array
	{
		return $this->typeNames;
	}

	private  function  filterDocsBytype($type,&$arr)
	{
		foreach ($arr as $key=>$file)
		{
			if ($file["TYPE"]!=$type)
			{
				unset($arr[$key]);
			}
		}
	}
public function prepareDocuments(&$arr)
	{

		foreach ($arr as &$file)
		{
			$file["EXTENSION"] = (strtolower(substr(strrchr($file['NAME'], "."), 1)));

				foreach ($this->typeNames as $key => $extensions) {
					if (in_array(	$file["EXTENSION"] , $extensions)) {
						$file["TYPE"] =$key;
					}
				}

			$file["DATE_CREATE"]  = ConvertDateTime($file['DATE_CREATE'], "DD.MM.YYYY", "ru"); // 2003-12-25
			$file["UPLOADER_INFO"]= (new EmployeeUtils($file['CREATED_BY']))->get_info(true);

		}
		return $arr;
	}


	public function filterTypes($arr) {
		$types=[];
		foreach ($arr as $key => $file) {
			$types[]=$file["TYPE"];
		}
		$this->typeNames = array_filter(
			$this->typeNames,
			function ($key) use ($types) { // Corrected to use $this to refer to the current object instance
				return in_array($key, $types); // Assuming $this->types contains the keys you want to filter by
			},
			ARRAY_FILTER_USE_KEY
		);
		return $this->typeNames;
	}




	public function findDocuments($limit='')
	{
//        echo '<pre>';
//        print_r($this->filter);
//        echo '</pre>';
		$docsCollection = DocItem::filter($this->filter)->select(["NAME", 'CREATED_BY','DATE_CREATE', "DETAIL_PAGE_URL", "PROPERTY_CATEGORY", "PROPERTY_DATE_START","PROPERTY_DATE_START" ])->sort($this->order);
		if (!empty($limit))
		{
			$docsCollection = $docsCollection->limit($limit)->getList();
		} else
		{
			$docsCollection = $docsCollection->getList();
		}
		$files = array();
		foreach ($docsCollection as $item)
		{
			$files[] = $item->toArray();
		}

		$this->prepareDocuments($files);
		$this->filterTypes($files);
if (!empty($this->request->getQuery("type")))
{
	$this->filterDocsBytype($this->request->getQuery("type"),$files);

}
		$this->files = $files;

		return $files;
	}

	public function getDocsSort()
	{ $getParams=$this->request->getQueryList()->toArray();
		$order="";

		if ($getParams["ORDER"]=="")
		{
			$order="asc";
		}
		else{
			$order=$getParams["ORDER"];
		}
		if ($getParams["SORT"]!="")
		{
			$this->order[$getParams["SORT"]]=$order;
		}


	}

	 public function getDocsFilter()
	{$getParams=$this->request->getQueryList()->toArray();
		$this->filter["ACTIVE"]="Y";
		$this->filter["SECTION_ID"]=$getParams["SECTION_ID"];
        $this->filter["CHECK_PERMISSIONS"]="Y";
		if(isset($getParams['DATESTART']) && isset($getParams['DATEEND'])){

			$start_date = str_replace('/','.', $getParams['DATESTART']);
			$end_date = str_replace('/','.', $getParams['DATEEND']);
			if ($arrStart = ParseDateTime($start_date, "MM.DD.YYYY"))
			{
				$normalStartDate =  date($getParams['DATESTART']. ' 00:00:00');

			}
			if ($arrEnd = ParseDateTime($end_date, "MM.DD.YYYY"))
			{
				$normalEndDate = date($_GET['DATEEND']. ' 23:59:59');

			}


			$this->filter[">=DATE_CREATE"] = $normalStartDate;
			$this->filter["<=DATE_CREATE"] = $normalEndDate;
		}
		if(isset($getParams['ARCHIVE'])){

			$arrEnd=date("Y-d-m");
			$archive =$arrEnd.' 23:59:59';
			$this->filter["<=PROPERTY_DATE_END"] = $archive;

		}

		if (isset($getParams['CATEGORY_ID']))
		{
			$this->filter['PROPERTY_CATEGORY'] = $getParams['CATEGORY_ID'];
		}

		
	}
public function  getTree()
{

	$rsSections = DocFolder::query()->filter(['ACTIVE' => 'Y'])->select(['IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID'])->sort(['DEPTH_LEVEL'=>'ASC','SORT'=>'ASC'])->getList()->toArray();

	$sectionLinc = [];
	$Result['ROOT'] = [];
	$sectionLinc[0] = &$Result['ROOT'];
	foreach ($rsSections as $arSection)
	{
		$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
		$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
	}

	$this->tree=$Result["ROOT"]["CHILD"];
	return $Result["ROOT"]["CHILD"];
}

	public static function printList($tree,$currentSection="") {

	echo "<ul class='two__tier__list'>\n";
	foreach ($tree as $key => $value) {
        if ($currentSection==$value['ID'])
        {
		echo "<li class='active'>\n";

			echo "<p class='link active'>";
		}
		else{
            echo "<li >\n";
			echo "<p class='link'>";

		}
		if (!isset($value['CHILD'])) {
			echo "<img class='link__img' style='visibility: hidden' src='/local/templates/moskvich/img/icon/CaretRight.svg'>\n";
		}
		if (isset($value['CHILD'])) {
			echo "<img class='link__img' src='/local/templates/moskvich/img/icon/CaretRight.svg'>\n";
		}
		echo "<img class='link__img' src='/local/templates/moskvich/img/icon/Folder.svg'>\n";
		echo "<a href='" .'/documents/?SECTION_ID='. $value['ID'] . "' class='link__title'>" . $value['NAME'] . "</a>\n";
		echo "</p>\n";
		if (isset($value['CHILD'])) {
			echo "<ul class='two__tier__list__col'>\n";
			self::printList($value['CHILD'],$currentSection);
			echo "</ul>\n";
		}
		echo "</li>\n";
	}
	echo "</ul>\n";
}

}