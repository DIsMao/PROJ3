<?php

namespace Adamcode\Services;

use Adamcode\Models\Like;
use Adamcode\Models\MediaItem;
use Bitrix\Main\Engine\CurrentUser;

class MediaService

{
	private array $media = [];

	public static function getPhotoInfo($id, $photo_array)
	{
		$likeUser = Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_FILE_ID' => $id, 'PROPERTY_USER_ID' => CurrentUser::get()->getId()))->count();

		$photo["USER_LIKED"] = ($likeUser !== 0);
		$photo["SRC"] = \CFile::GetPath($id);
		$photo["LIKES_COUNT"] = Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_FILE_ID' => $id))->count();
		$photo["INDEX"] = array_search($id, $photo_array);
		return $photo;
	}

	public static function preparePhotosList(&$photoArray, $length, $big_pictures)
	{
		$pages = array_chunk($photoArray["VALUE"], $length);


		foreach ($pages as $key => $page)
		{

			foreach ($page as $key_photo => $photoid)
			{
				{
					$big_array = [];

					foreach ($big_pictures as $big_picture)
					{
						self::add_to_big($big_picture, $big_array);

					}
					$likeUser = Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_FILE_ID' => $photoid, 'PROPERTY_USER_ID' => CurrentUser::get()->getId()))->count();

					$photoArray["PAGES"][$key][$photoid]["USER_LIKED"] = ($likeUser !== 0);
					$photoArray["PAGES"][$key][$photoid]["SRC"] = \CFile::GetPath($photoid);
					$photoArray["PAGES"][$key][$photoid]["BIG"] = (in_array($key_photo, $big_array) !== false);
					$photoArray["PAGES"][$key][$photoid]["LIKES_COUNT"] = Like::query()->filter(array("ACTIVE" => "Y", 'PROPERTY_FILE_ID' => $photoid))->count();
					$photoArray["PAGES"][$key][$photoid]["INDEX"] = $key_photo;
				}
			}

		}
	}

	public static function add_to_big($index, &$array)
	{
		$array[] = $index-1;

	}

	public function findCategories()
	{
		$uniqueCategories = [];
		foreach ($this->media as $item)
		{
			foreach ($item["categories"] as $category)
			{
				$uniqueCategories[$category['NAME']]["ID"] = $category["ID"];
				if (!isset($uniqueCategories[$category['NAME']]))
				{
					$uniqueCategories[$category['NAME']] = ['COUNT' => 1];
				} else
				{
					$uniqueCategories[$category['NAME']]['COUNT']++;
				}
			}
		}
		return $uniqueCategories;

	}

	public function findMedia($filter = ["ACTIVE" => "Y"])
	{
		$mediaCollection = MediaItem::query()->select(["NAME", 'SHOW_COUNTER', "DETAIL_PAGE_URL", "PROPERTY_TAGS", "PROPERTY_MEDIA_DATE", "PROPERTY_TAGS", "PROPERTY_MEDIA_FILES", "PROPERTY_PHOTOS", "PREVIEW_PICTURE"])->filter($filter)->sort(["DATE_CREATE" => "DESC"])->with([
			'categories' => function ($query) {
				$query->select(["NAME"]);
			}]);
		if (!empty($limit))
		{
			$mediaCollection = $mediaCollection->limit($limit)->getList();
		} else
		{
			$mediaCollection = $mediaCollection->getList();
		}
		$media = array();
		foreach ($mediaCollection as $item)
		{
			$media[] = $item->toArray();
		}
		$this->media = $media;
		return $media;
	}

	public function getMounthArray()
	{
		$monthsArray = array();
		$months = array('01' => "Январь", '02' => "Февраль", '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');
		foreach ($this->media as $item)
		{
			if (!empty($item["PROPERTY_MEDIA_DATE_VALUE"]))
			{
				$date = $item["PROPERTY_MEDIA_DATE_VALUE"];
				$year = date("Y", strtotime($date));
				$monthId = date("m", strtotime($date));
				$monthName = $months[$monthId];
				$newMounth = ["monthName" => $monthName,
					"year" => $year,
					"monthId" => $monthId];
				if (!in_array($newMounth, $monthsArray))
				{
					$monthsArray[] = $newMounth;
				}
			}


		}
		return $monthsArray;
	}

}