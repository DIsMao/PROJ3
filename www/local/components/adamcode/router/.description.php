<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); $arComponentDescription = array(
"NAME" => "Роутер",
"DESCRIPTION" => "Роутер",
"SORT" => 20,
"PATH" => array(
  "ID" => "content",
  "CHILD" => array(
    "ID" => "sections",
    "NAME" => "Роутер",
    "SORT" => 40,
			"CHILD" => array(
			"ID" => "router",
		),
  ),
),
);
?>