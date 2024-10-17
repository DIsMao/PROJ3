<?php

namespace Adamcode\Services;
use Adamcode\Models\Employee;
use Adamcode\Config\Idea;
use Adamcode\Models\Comment;
use Adamcode\Models\Event;
use Adamcode\Models\NewEmployee;
use Adamcode\Util\EmployeeUtils;
use Bitrix\Bizproc\Workflow\Template\Packer\Result\Pack;
use Bitrix\Main\Type\DateTime;

class CommentsService

{
	private array $comments = [];

	public function findComments($id)
	{
		$this->comments = Comment::filter(["PROPERTY_OBJ_ID" => $id])->select(["PROPS", "DATE_CREATE","DETAIL_TEXT"])->sort(["DATE_CREATE"=>"DESC"])->getList()->toArray();
		return $this->prepareComments($this->comments);

	}

	public function prepareComments(&$arr)
	{
		foreach ($arr as &$comment)
		{


            $comment["AUTHOR_INFO"] = Employee::select(["NAME","DETAIL_PAGE_URL","ACTIVE","IBLOCK_SECTION_ID", "PROPERTY_PHOTO", "PROPERTY_USER"])->filter(["ID" => $comment["PROPERTY_USER_VALUE"]])->getList()->first();
			$date = new DateTime($comment["DATE_CREATE"]);


			$comment["DATE_CREATE"] = $date->format("d.m.Y H:i");
		}

		return $arr;
	}
}