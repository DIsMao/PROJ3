<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
	'GROUPS' => [
		'SETTINGS' => [
			'NAME' =>"Общие параметры"
		],
	],
	'PARAMETERS' => [
		'LOGIN_LINK' => [
			'PARENT' => 'SETTINGS',
			'NAME' => "Ссылка на форму входа",
			'TYPE' => 'STRING',
			'MULTIPLE' => 'N',
		],
		'LK_LINK' => [
			'PARENT' => 'SETTINGS',
			'NAME' => "Ссылка на  личный кабинет",
			'TYPE' => 'STRING',
			'MULTIPLE' => 'N',
		],
		'CACHE_TIME' => [],
	]
];