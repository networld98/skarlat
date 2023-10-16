<?include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
				$APPLICATION->IncludeComponent(
					"bitrix:sale.basket.basket",
					"modal",
					Array(
						"ACTION_VARIABLE" => "basketAction",
						"ADDITIONAL_PICT_PROP_26" => "-",
						"ADDITIONAL_PICT_PROP_27" => "-",
						"ADDITIONAL_PICT_PROP_29" => "-",
						"ADDITIONAL_PICT_PROP_30" => "-",
						"AUTO_CALCULATION" => "Y",
						"BASKET_IMAGES_SCALING" => "adaptive",
						"COLUMNS_LIST_EXT" => array("PREVIEW_PICTURE","DELETE","SUM","PROPERTY_ARTNUMBER"),
						"COLUMNS_LIST_MOBILE" => array("PREVIEW_PICTURE","DELETE","SUM","PROPERTY_ARTNUMBER"),
						"COMPATIBLE_MODE" => "Y",
						"CORRECT_RATIO" => "Y",
						"DEFERRED_REFRESH" => "N",
						"DISCOUNT_PERCENT_POSITION" => "bottom-right",
						"DISPLAY_MODE" => "extended",
						"EMPTY_BASKET_HINT_PATH" => "/catalog/",
						"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
						"GIFTS_CONVERT_CURRENCY" => "N",
						"GIFTS_HIDE_BLOCK_TITLE" => "N",
						"GIFTS_HIDE_NOT_AVAILABLE" => "N",
						"GIFTS_MESS_BTN_BUY" => "Выбрать",
						"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
						"GIFTS_PAGE_ELEMENT_COUNT" => "4",
						"GIFTS_PLACE" => "BOTTOM",
						"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
						"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
						"GIFTS_SHOW_OLD_PRICE" => "N",
						"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
						"HIDE_COUPON" => "Y",
						"LABEL_PROP" => array(),
						"PATH_TO_ORDER" => "/personal/order/make/",
						"PRICE_DISPLAY_MODE" => "Y",
						"PRICE_VAT_SHOW_VALUE" => "N",
						"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
						"QUANTITY_FLOAT" => "N",
						"SET_TITLE" => "Y",
						"SHOW_DISCOUNT_PERCENT" => "Y",
						"SHOW_FILTER" => "N",
						"SHOW_RESTORE" => "N",
						"TEMPLATE_THEME" => "blue",
						"TOTAL_BLOCK_DISPLAY" => array("bottom"),
						"USE_DYNAMIC_SCROLL" => "Y",
						"USE_ENHANCED_ECOMMERCE" => "Y",
						"USE_GIFTS" => "N",
						"USE_PREPAYMENT" => "N",
						"USE_PRICE_ANIMATION" => "Y"
					)
				);
?>