<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата замовлення");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
	Array(
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
