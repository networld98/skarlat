<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Співробітництво');
?>
<!-- SECTION COOPERATION CONTENT START -->
<div class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8 mb-4">
                <div class="info-content">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/ru/include/cooperation.php",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3 offset-lg-0 col-lg-5 col-xl-4">
                <div class="row">
                    <div class="col-12">
                        <div class="form-wrapper-request">
                            <h3 class="text-color text-center">Запрошуємо до співробітництва оптовиків!</h3>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:form.result.new",
                                "cooperation_page",
                                Array(
                                    "CACHE_TIME" => "3600",
                                    "CACHE_TYPE" => "A",
                                    "CHAIN_ITEM_LINK" => "",
                                    "CHAIN_ITEM_TEXT" => "",
                                    "EDIT_URL" => "result_edit.php",
                                    "IGNORE_CUSTOM_TEMPLATE" => "Y",
                                    "LIST_URL" => "/ru/cooperation/",
                                    "SEF_MODE" => "N",
                                    "SUCCESS_URL" => "",
                                    "USE_EXTENDED_ERRORS" => "N",
                                    "VARIABLE_ALIASES" => Array(
                                        "RESULT_ID" => "RESULT_ID",
                                        "WEB_FORM_ID" => "WEB_FORM_ID"
                                    ),
                                    "WEB_FORM_ID" => "13"
                                )
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SECTION COOPERATION CONTENT END -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
