<?php
$arUrlRewrite=array (
  33 => 
  array (
    'CONDITION' => '#^/personal/order/result/#',
    'RULE' => 'forgot_password=yes',
    'ID' => '',
    'PATH' => '/personal/order/result/change.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/personal/order/result/#',
    'RULE' => 'change_password=yes&USER_LOGIN=$1&USER_CHECKWORD=$2',
    'ID' => '',
    'PATH' => '/personal/order/result/change.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  23 => 
  array (
    'CONDITION' => '#^/crm/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.catalog.controller',
    'PATH' => '/crm/catalog/index.php',
    'SORT' => 100,
  ),
  30 => 
  array (
    'CONDITION' => '#^/conference/#',
    'RULE' => '',
    'ID' => 'bitrix:im.conference.center',
    'PATH' => '/conference/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  31 => 
  array (
    'CONDITION' => '#^/crm/type/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.router',
    'PATH' => '/crm/type/index.php',
    'SORT' => 100,
  ),
  39 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/devops/#',
    'RULE' => NULL,
    'ID' => 'bitrix:rest.devops',
    'PATH' => '/devops/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/page/#',
    'RULE' => '',
    'ID' => 'bitrix:intranet.customsection',
    'PATH' => '/page/index.php',
    'SORT' => 100,
  ),
  38 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
