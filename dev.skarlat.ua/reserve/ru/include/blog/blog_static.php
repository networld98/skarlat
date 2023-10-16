<div class="seo-body">
    <div class="seo-content-prev">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/include/blog/blog_static_preview.php"
            )
        );?>
    </div>
    <button
        class="seo-collapse-btn"
        id="seo-collapse-btn"
        data-toggle="collapse"
        data-target="#seo-collapse"
        aria-expanded="false"
        aria-controls="seo-collapse"
    >
        <?=GetMessage("FULL_READ")?>
    </button>
    <div class="collapse multi-collapse seo-collapse-shadow" id="seo-collapse">
        <div class="seo-full-content">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "/include/blog/blog_static_full.php"
                )
            );?>
        </div>
    </div>
</div>
