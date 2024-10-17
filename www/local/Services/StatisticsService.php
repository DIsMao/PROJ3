<?php

namespace Adamcode\Services;
use Adamcode\Models\User;
use Arrilot\BitrixIblockHelper\HLblock;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\HttpRequest;
use CUser;
use DateTimeImmutable;

class StatisticsService
{
	private array $filter = [];
	private  array $filteredLinks;
	private  array $allLinks;
	private array $userlist = [];

	private HttpRequest $request;

	public function getRequest(): HttpRequest
	{
		return $this->request;
	}

	public function setFilteredLinks(array $filteredLinks): void
	{
		$this->filteredLinks = $filteredLinks;
	}

	public function setAllLinks(array $allLinks): void
	{
		$this->allLinks = $allLinks;
	}



	/**
	 * @param HttpRequest $request
	 */
	public function __construct(HttpRequest $request)
	{
		$this->request = $request;
	}

	public function getFilter(): array
	{
		return $this->filter;
	}

	public  function findUsers()
	{
		 return $this->userlist=User::filter(["ACTIVE"=>"Y"])->select(["ID", "NAME", "LAST_NAME"])->getList()->toArray();
	}

	public function findStatistics()
	{$statistics=[];
        \Bitrix\Main\Loader::includeModule("highloadblock");
        $arHLBlock = HighloadBlockTable::getById(3)->fetch();
        $obEntity = HighloadBlockTable::compileEntity($arHLBlock);
// обращаемся к DataManager
		$strEntityDataClass = $obEntity->getDataClass();
		$dbResults = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_LINK_NAME', 'UF_URL', "UF_USER", "UF_DATE"),
			'filter' => $this->filter
		))->fetchAll();
		foreach ($dbResults as $arItem)
		{
			$statistics[] = $arItem;
		}
		return $statistics;
	}

	public function prepareFilter($all="N"): void
	{
		global $DB;
		$reset = !empty($this->request->getQuery('reset')) ? empty($this->request->getQuery('reset')) : ''; //инпут сброса фильтров

		if(($reset === 'Y')||($all=="Y"))
		{
			$this->filter = [];
		} else
		{



			$searchPeriodStart = !empty($this->request->getQuery('searchPeriodStart')) ? trim($this->request->getQuery('searchPeriodStart')) : ''; //инпут периода начала

			$searchPeriodEnd = !empty($this->request->getQuery('searchPeriodEnd')) ? trim($this->request->getQuery('searchPeriodEnd')) : ''; //инпут периода конца

			if ($searchPeriodStart && $searchPeriodEnd)
			{
				$this->filter['>=UF_DATE'] = $DB->FormatDate($searchPeriodStart, "YYYY-MM-DD", "DD.MM.YYYY"). " 00:00:00";
				$this->filter['<=UF_DATE'] = $DB->FormatDate($searchPeriodEnd, "YYYY-MM-DD", "DD.MM.YYYY") . " 23:59:59";
			}
			$searchUser = !empty($this->request->getQuery('searchUser')) ? $this->request->getQuery('searchUser') : ''; //инпут выбранного пользователя

			if (!empty($searchUser))
			{

				foreach ($this->userlist as $user)
				{

					$userName = $user['NAME'] . ' ' . $user['LAST_NAME'];

					if ($userName === $searchUser)
					{
						$userId = $user['ID'];
						$this->filter["UF_USER"] = $userId;
					}
				}
			}

			$searchPage = !empty($this->request->getQuery('searchPage')) ? trim($this->request->getQuery('searchPage')) : ''; //инпут определенной страницы

			if ($searchPage)
			{
				$this->filter["UF_LINK_NAME"] = $searchPage;

			}
		}

	}
	public static  function compareDates($a, $b)
	{
		$timeA = strtotime($a['UF_DATE']);
		$timeB = strtotime($b['UF_DATE']);
		return $timeA - $timeB;
	}


	public function formatResult($result)
	{ $processedResults=[];

			foreach ($result as $row)
			{

				$userInfo = $this->getUserInfo($row['UF_USER']);
				$date =     date('d.m.Y', strtotime($row['UF_DATE']));
				$processedResults[] = [
					'ID' => $row['ID'],
					'UF_URL' => $row['UF_URL'],

					'UF_LINK_NAME' => $row['UF_LINK_NAME'],
					'UF_USER' => $userInfo,
					'UF_DATE' => $date
				];
			}

		return $processedResults;
	}

	private function getUserInfo($userId) {
		$userInfo =User::filter(["ID"=>$userId])->select(["NAME","LAST_NAME","ID"])->first();
		if (!empty($userInfo))
		{
			return $userInfo->toArray();
		}
	}
	public function processLinks(): array
	{
		$this->cleanDates();
		$linksByAllDates = $this->filteredLinks;
		$this->sortLinks($linksByAllDates);
		$checkDates = $this->createCheckDates($linksByAllDates);
		$missingDates = $this->findMissingDates($checkDates);
		$this->populateMissingDates($missingDates);
		$linksByAllDates = array_merge($linksByAllDates, $missingDates);
		$this->sortLinks($linksByAllDates);
		$allNamesLinks = $this->getAllUniqueLinkNames();


		return [
			'linksByAllDates' => $linksByAllDates,
			'allNamesLinks' => $allNamesLinks
		];
	}

	private function cleanDates() {
		foreach ($this->filteredLinks as $i => $link) {
			$date = explode(' ', $link['UF_DATE'])[0];
			$this->filteredLinks[$i]['UF_DATE'] = $date;
		}
	}

	private function sortLinks(array &$links) {
		usort($links, ["Adamcode\\Services\\StatisticsService", "compareDates"]);
	}

	private function createCheckDates(array $linksByAllDates) {
		$checkDates = [];
		foreach ($linksByAllDates as $item) {
			$time = strtotime($item['UF_DATE']);
			$checkDates[date('d.m.Y', $time)] = $item;
		}
		return $checkDates;
	}

	private function findMissingDates(array $checkDates) {
		$missingDates = [];
		$firstDate = strtotime(reset($checkDates)['UF_DATE']);
		$lastDate = strtotime(end($checkDates)['UF_DATE']);

		for ($i = $firstDate; $i <= $lastDate; $i += 86400) {
			$date = date('d.m.Y', $i);
			if (!isset($checkDates[$date])) {
				$missingDates[] = ['UF_DATE' => $date, 'count' => 0];
			}
		}
		return $missingDates;
	}

	private function populateMissingDates(array &$missingDates) {
		foreach ($missingDates as $key => $item) {
			$missingDates[$key]['ID'] = '';
			$missingDates[$key]['UF_LINK_NAME'] = '';
			$missingDates[$key]['UF_USER'] = ['ID' => ''];
			$missingDates[$key]['UF_URL'] = '';

			$time = new DateTimeImmutable($missingDates[$key]['UF_DATE']);
			$missingDates[$key]['UF_DATE'] = $time->format('d.m.Y');
		}
	}

	private function getAllUniqueLinkNames() {
		$allNamesLinks = [];
		foreach ($this->allLinks as $link) {
			$allNamesLinks[] = $link['UF_LINK_NAME'];
		}
		return array_unique($allNamesLinks);
	}

}