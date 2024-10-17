<?php
$arUrlRewrite=array (
    3 =>
        array (
            'CONDITION' => '#^/filterTest/(.+?)/apply/#',
            'RULE' => 'SMART_FILTER_PATH=$1',
            'ID' => '',
            'PATH' => '/filterTest/index.php',
            'SORT' => 99,
        ),
    2 =>
        array (
            'CONDITION' => '#^/filterTest#',
            'RULE' => '',
            'ID' => 'bitrix:news.list',
            'PATH' => '/filterTest/index.php',
            'SORT' => 100,
        ),
    0 =>
        array (
            'CONDITION' => '#^/rest/#',
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/bitrix/services/rest/index.php',
            'SORT' => 100,
        ),
    1 =>
        array (
            'CONDITION' => '#^/news/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/news/index.php',
            'SORT' => 100,
        ),
    4 =>
        array (
            'CONDITION' => '#^/auth/register_assembler#',
            'RULE' => '',
            'ID' => 'bitrix:main.register',
            'PATH' => '/auth/register.php?GROUP_ASSEMBLER=true',
            'SORT' => 100,
        ),
    5 =>
        array (
            'CONDITION' => '#^/auth/register_partner#',
            'RULE' => '',
            'ID' => 'bitrix:main.register',
            'PATH' => '/auth/register.php?GROUP_CUSTOMER=true',
            'SORT' => 100,
        ),
);
