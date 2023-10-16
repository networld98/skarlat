<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(GetMessage("GUARANTY"));
?>
<!-- SECTION GARANTEG CONTANT START -->
<div>
    <div class="container">
        <div class="col-12">
            <div class="info-content">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/guaranty_".LANGUAGE_ID.".php"
                    )
                );?>
            </div>
        </div>
    </div>
</div>
<!-- SECTION GARANTEG CONTANT END -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
