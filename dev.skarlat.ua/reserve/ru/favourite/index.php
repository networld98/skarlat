<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(GetMessage("FAVORITE")." Skarlat");

$APPLICATION->IncludeComponent(
	"bitrix:catalog.product.subscribe.list",
	"skarlat",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"LINE_ELEMENT_COUNT" => "6"
	)
);
?>
    <!-- SUBSCRIBE SECTION START -->
    <div class="subscribe-main">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-7">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/ru/include/main_page/advantages.php"
                        )
                    );?>
                </div>
                <div class="col-12 col-md-6 col-lg-5 d-flex align-items-center">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:form.result.new",
                        "main_page",
                        Array(
                            "CACHE_TIME" => "3600",
                            "CACHE_TYPE" => "A",
                            "CHAIN_ITEM_LINK" => "",
                            "CHAIN_ITEM_TEXT" => "",
                            "EDIT_URL" => "result_edit.php",
                            "IGNORE_CUSTOM_TEMPLATE" => "Y",
                            "LIST_URL" => "/",
                            "SEF_MODE" => "N",
                            "SUCCESS_URL" => "",
                            "USE_EXTENDED_ERRORS" => "N",
                            "VARIABLE_ALIASES" => Array(
                                "RESULT_ID" => "RESULT_ID",
                                "WEB_FORM_ID" => "WEB_FORM_ID"
                            ),
                            "WEB_FORM_ID" => "12"
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
    <!-- SUBSCRIBE SECTION END -->
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
