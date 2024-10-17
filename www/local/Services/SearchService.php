<?php

namespace Adamcode\Services;

use Adamcode\Config\Blocks;
use Bitrix\Main\HttpRequest;
use CSearch;
use PhpSpellcheck\Spellchecker\Hunspell;

class SearchService
{
	private array $doctypeNames = [
		"Word" => ["doc", "docx"],
		"Excel" => ["xls", "xlsx"],
		"PowerPoint" => ["pptx"],
		"PDF" => ["pdf"]
	];
	private HttpRequest $request;
	private array $types = [];

	private array $filter = [];
	private array $searchResults = [];

    private array $searchResultsCopy = [];
	/**
	 * @param HttpRequest $request
	 */
	public function __construct(HttpRequest $request)
	{
		$this->request = $request;
	}

	public static function format_by_count($count, $form1, $form2, $form3)
	{
		$count = abs($count) % 100;
		$lcount = $count % 10;


		if ($count >= 11 && $count <= 19) return ($form3);
		if ($lcount >= 2 && $lcount <= 4) return ($form2);
		if ($lcount == 1) return ($form1);
		return $form3;
	}

	public function getSearchResults(): array
	{
		return $this->searchResults;
	}

	public function populateTypes()
	{
		$types = [];
        if(empty($this->searchResultsCopy)){
            foreach ($this->searchResults as $key => $file)
            {
                $types[] = $file["TYPE"];

            }
        }else{
            foreach ($this->searchResultsCopy as $key => $file)
            {
                $types[] = $file["TYPE"];

            }
        }

		$this->doctypeNames = array_filter(
			$this->doctypeNames,
			function ($key) use ($types) { // Corrected to use $this to refer to the current object instance
				return in_array($key, $types); // Assuming $this->types contains the keys you want to filter by
			},
			ARRAY_FILTER_USE_KEY
		);

		$this->types = array_merge(["Контент-страницы" => Blocks::Page->value, "Новости" => Blocks::News->value,  "Библиотека документов" => Blocks::Docs->value], $this->doctypeNames);


	}

	public function prepareFilter()
	{
		$params = $this->request->getQueryList()->toArray();
		$this->filter = array(
			'QUERY' => $params['q'],
		);
		if (!empty($params['DATESTART']) && !empty($params['DATEEND']))
		{

			if ($arrStart = ParseDateTime($params['DATESTART'], "DD.MM.YYYY"))
			{
				$normalStartDate = $arrStart["DD"] . '.' . $arrStart["MM"] . '.' . $arrStart["YYYY"] . ' 00:00:00';

			}
			if ($arrEnd = ParseDateTime($params['DATEEND'] . "DD.MM.YYYY"))
			{
				$normalEndDate = $arrEnd["DD"] . '.' . $arrEnd["MM"] . '.' . $arrEnd["YYYY"] . ' 23:59:59';

			}
			$this->filter['<=DATE_CHANGE'] = $normalEndDate;
			$this->filter[">=DATE_CHANGE"] = $normalStartDate;
		}
		if (empty($params['where']))
		{
			$this->filter[] = array(
				"LOGIC" => "OR",
				array(
					"MODULE_ID" => "iblock",
					"PARAM2" => array_values(["Контент-страницы" => Blocks::Page->value, "Новости" => Blocks::News->value])
				),
				array(
					"MODULE_ID" => "main",
				)
			);
		}
		elseif(($params['where'] !== "") && ($params['where'] == Blocks::Docs->value))
		{

            $this->filter['%ITEM_ID'] = "/files/";
            $this->filter["MODULE_ID"] = "main";

		}

		elseif ($params['where'] !== "")
		{
			$section = $params['where'];
			$this->filter["MODULE_ID"] = "iblock";
			$this->filter["PARAM2"] = Blocks::from($section)->value;


		}
//        echo '<pre>';
//        print_r($this->filter);
//        echo '</pre>';
	}

//	public function queryCheck()
//	{
//
//		$hunspell = Hunspell::create();
//		$sentence = (empty($this->request->getQuery("q"))) ? '' : $this->request->getQuery("q");
//		$misspellings = $hunspell->check($sentence, ['ru_RU'], ['from_string']);
//		$correctedWords = []; // Initialize an array to hold the corrected words
//
//		foreach ($misspellings as $misspelling)
//		{
//			$suggestions = $misspelling->getSuggestions();
//			$correction = $suggestions[0] ?? $misspelling->getWord(); // Choose the first suggestion or keep the word as is
//			$correctedWords[] = $correction; // Add the corrected word to the array
//		}
//
//		$correctedSentence = implode(' ', $correctedWords);
//
//
//		return $correctedSentence;
//
//
//	}

	public function getTypes(): array
	{
		return $this->types;
	}

	public function findSearchResults()
	{
		$obSearch = new CSearch;
		$obSearch->Search($this->filter,
			array(),
			array(

				'STEMMING' => 'false',
			)
		);
		while ($arSearch = $obSearch->GetNext())
		{
			$this->searchResults[] = $arSearch;

		}
		$this->prepareSearchResults();
		if (!empty($this->request->getQuery("file_type")))
		{
			$this->filterByType($this->request->getQuery("file_type"));

		}
	}

	private function prepareSearchResults()
	{
		foreach ($this->searchResults as $key => &$file)
		{
			if (mb_substr($file["ITEM_ID"], 0, 6) !== "FOLDER")
			{
				$ext = strtolower(substr(strrchr($file['TITLE'], "."), 1));

				foreach ($this->doctypeNames as $key => $extensions)
				{

					if (in_array($ext, $extensions))
					{
						$file["TYPE"] = $key;

					}
				}
			}

		}
	}

	private function filterByType($type)
	{
        $this->searchResultsCopy = $this->searchResults;
		foreach ($this->searchResults as $key => $file)
		{
			if (mb_substr($file["ITEM_ID"], 0, 6) !== "FOLDER")
			{
				if ($file["TYPE"] != $type)
				{


					unset($this->searchResults[$key]);
				}
			}
		}
	}

	public function getRequest()
	{
		return $this->request;
	}

}