<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;?>
<div class="container">
    <div class="seo ptb">
        <div class="row seo-separator">
            <div class="col-12">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "PATH" =>SITE_DIR."/include/product/seo.php"
                    ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</div>
</main>
<footer class="footer ptb bt">
    <div class="container">
        <div class="row ">
            <div class="col-12 col-sm-12 d-flex flex-column flex-sm-row">
                <nav class="footer-nav order-1 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "0",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_catalog",
                            "USE_EXT" => "Y"
                        )
                    );?>
                </nav>
<!--                <nav class="footer-nav order-2 order-sm-0">-->
<!--                    --><?//$APPLICATION->IncludeComponent(
//                        "bitrix:menu",
//                        "bottom_menu",
//                        Array(
//                            "ALLOW_MULTI_SELECT" => "N",
//                            "CHILD_MENU_TYPE" => "bottom",
//                            "DELAY" => "N",
//                            "MAX_LEVEL" => "1",
//                            "MENU_CACHE_GET_VARS" => array(""),
//                            "MENU_CACHE_TIME" => "3600",
//                            "MENU_CACHE_TYPE" => "N",
//                            "MENU_CACHE_USE_GROUPS" => "Y",
//                            "ROOT_MENU_TYPE" => "bottom_menu_info",
//                            "USE_EXT" => "N"
//                        )
//                    );?>
<!--                </nav>-->
                <nav class="footer-nav order-3 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_ukraine",
                            "USE_EXT" => "N"
                        )
                    );?>
                </nav>
                <nav class="footer-nav order-3 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_kingdom",
                            "USE_EXT" => "N"
                        )
                    );?>
                </nav>
                <nav class="footer-nav order-3 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_arab",
                            "USE_EXT" => "N"
                        )
                    );?>
                </nav>
                <nav class="footer-nav order-3 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_download",
                            "USE_EXT" => "N"
                        )
                    );?>
                </nav>
                <nav class="footer-nav order-4 order-sm-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "social_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom_menu_social",
                            "USE_EXT" => "N"
                        )
                    );?>
                </nav>
            </div>
        </div>
    </div>
</footer>
<div id="phoneModal" data-close="true" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><?=GetMessage("CONTACTS")?></h2>
            <button class="close" data-close="true">
                <svg x="0px" y="0px" viewBox="0 0 30 30">
                    <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <? $APPLICATION->IncludeFile(
                $APPLICATION->GetTemplatePath(SITE_DIR."include/header/header_phone.php"),
                Array(),
                Array("MODE" => "html")
            ); ?>
        </div>
    </div>

</div>
<div id="modalInfo" data-close="true" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><?=GetMessage("ORDER_HISTORY")?></h2>
            <button class="close" data-close="true">
                <svg x="0px" y="0px" viewBox="0 0 30 30">
                    <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                </svg>
            </button>
        </div>

        <div class="modal-body"><div class="row pt-4 pb-4">
                <div class="col-12">
                    <ul class="history-list-order">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalBonus" data-close="true" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><?=GetMessage("ORDER_BONUS")?></h2>
            <button class="close" data-close="true">
                <svg x="0px" y="0px" viewBox="0 0 30 30">
                    <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="row pt-4 pb-4">
                <div class="col-12">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer end -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="copyright-content">
                    © Skarlat 2023. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</div>
<?if(SITE_ID == 'mg'){
    $APPLICATION->IncludeComponent(
        "bitrix:sender.subscribe",
        "carusel",
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "USE_PERSONALIZATION" => "Y",
            "CONFIRMATION" => "N",
            "SHOW_HIDDEN" => "Y",
            "AJAX_MODE" => "Y",
            "AJAX_OPTION_JUMP" => "Y",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "Y",
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => "3600",
            "SET_TITLE" => "N",
            "HIDE_MAILINGS" => "N",
            "USER_CONSENT" => "N",
            "USER_CONSENT_ID" => "2",
            "USER_CONSENT_IS_CHECKED" => "Y",
            "USER_CONSENT_IS_LOADED" => "N",
            "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );
}
?>
<? if(CSite::InDir(SITE_DIR.'catalog/')){
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/js-image-zoom.min.js');?>
    <script>
        $(document).ready(function() {
            console.log('ViewContent');
            fbq('track', 'ViewContent');

            var $easyzoom = $('.img-zoom__wrapper').easyZoom();
        });
    </script>
<?}?>
<!--Start of Tawk.to Script-->
<?
if (SITE_ID == 'mg' || SITE_ID == 'ue') {?>
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/64da0d0acc26a871b02f2418/1h7ps5sdt';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<?} elseif (SITE_ID == 'sh' || SITE_ID == 'ae') {?>
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/64da0724cc26a871b02f2279/1h7pqnq4e';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<?} elseif (SITE_ID == 're') {?>
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/64da0d6894cf5d49dc6a484f/1h7ps8obs';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<?}?>
<!--End of Tawk.to Script-->
</body>
</html>
