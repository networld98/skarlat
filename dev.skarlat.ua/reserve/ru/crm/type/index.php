<?php

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->includeComponent(
	'bitrix:crm.router',
	'',
	[
		'root' => '/ru/crm/',
	]
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
