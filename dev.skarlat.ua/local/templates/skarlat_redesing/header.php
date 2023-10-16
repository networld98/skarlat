<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CJSCore::Init(array("fx"));
CJSCore::Init(array('jquery3'));

use Bitrix\Main,
    Bitrix\Iblock,
    Bitrix\Catalog,
    Bitrix\Main\Localization\Loc,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Main\Config\Option;

//Получить сайть айди сайта без продаж и регистрации
global $no_shop_site_array, $no_shop_site_price_array;
$no_shop_sites = Option::get("maycat.d7dull", "no_shop_site");
$no_shop_price_sites = Option::get("maycat.d7dull", "no_shop_site_price");
if($no_shop_sites != '' || $no_shop_sites != NULL){
    $no_shop_site_array = explode(',',$no_shop_sites);
}else{
    $no_shop_site_array = [];
}
//Получить сайть айди сайта без продаж но с ценами
if($no_shop_price_sites != '' || $no_shop_price_sites != NULL){
    $no_shop_site_price_array = explode(',',$no_shop_price_sites);
}else{
    $no_shop_site_price_array = [];
}

//Редиректим если страница личного кабинета или корзина
if(in_array(SITE_ID,$no_shop_site_array) && strpos($_SERVER['REQUEST_URI'], '/personal/') !== false ){
    header('Location: https://'.$_SERVER['HTTP_HOST'].'/');
}

$curPage = $APPLICATION->GetCurPage(true);

global $USER, $iblCatalog;
if (SITE_ID == 'mg') {
    $iblCatalog = 47;
    //закрываем от индексации
    $APPLICATION->SetPageProperty("robots", "noindex, nofollow");
} elseif (SITE_ID == 'sh') {
    $iblCatalog = 29;
    $APPLICATION->SetPageProperty("robots", "index, follow");
} elseif (SITE_ID == 'ue') {
    $iblCatalog = 64;
    //закрываем от индексации
    $APPLICATION->SetPageProperty("robots", "noindex, nofollow");
} elseif (SITE_ID == 're') {
    $iblCatalog = 59;
    //закрываем от индексации
    $APPLICATION->SetPageProperty("robots", "noindex, nofollow");
} elseif (SITE_ID == 'ae') {
    $iblCatalog = 65;
    //закрываем от индексации
    $APPLICATION->SetPageProperty("robots", "noindex, nofollow");
}
if ($_GET['q'] || $_GET['collection']) {
    $getUrl = '?' . $_SERVER['QUERY_STRING'];
}

if (SITE_ID == 'ae' || SITE_ID == 're' || SITE_ID == 'ue') {
    $rsSites = CSite::GetList($by="sort", $order="desc", array());
    while ($arSite = $rsSites->Fetch()){
        if ($arSite['ID'] == SITE_ID && $arSite['ID'] != 'ae') {
            $siteDir['this'] = $arSite['DIR'];
        }elseif ($arSite['ID'] == 'ae') {
            $siteDir['ae'] = $arSite['DIR'];
        }elseif($arSite['ID']  == 're') {
            $siteDir['re'] = $arSite['DIR'];
        }elseif($arSite['ID']  == 'ue') {
            $siteDir['ue'] = $arSite['DIR'];
        }
    }
    $newUrl = str_replace($siteDir['this'], '/',  $_SERVER['SCRIPT_URL']);
    $newUrl = substr($newUrl,1);
    if (SITE_ID == 'ae') {
        $ruUrl =  $siteDir['re'] . $newUrl;
        $uaUrl =  $siteDir['ue'] . $newUrl;
        $enUrl =  '/' . $newUrl;
    }
    if (SITE_ID == 're') {
        $ruUrl =  $siteDir['re'];
        $uaUrl =  $siteDir['ue'] . $newUrl;
        $enUrl =  '/' . $newUrl;
    }
    if (SITE_ID == 'ue') {
        $ruUrl =  $siteDir['re'] . $newUrl;
        $uaUrl =  $siteDir['ue'];
        $enUrl =  '/' . $newUrl;
    }

}else{
    $uaUrl = 'https://dev.skarlat.ua' . $_SERVER['SCRIPT_URL'] . $getUrl;
    $enUrl = 'https://skarlat.com' . $_SERVER['SCRIPT_URL'] . $getUrl;
}


if ($_GET['logout'] == "yes"):
    $url = explode("?", $_SERVER['REQUEST_URI']);
    LocalRedirect($url[0]);
endif;
if (!CModule::IncludeModule("sale")) return;

$filter['USER_ID'] = $USER->getId();

$resultObject = Catalog\SubscribeTable::getList(
    array(
        'select' => array('SITE_ID'),
        'filter' => $filter,
    )
);
$countfavourite = 0;
while ($item = $resultObject->fetch()) {
    if ($item['SITE_ID'] == SITE_ID) {
        $countfavourite++;
    }
}
global $countItemsInCart;
//Получаем количество товаров в корзине
$dbBasketItems = CSaleBasket::GetList(
    false,
    array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
    false,
    false,
    array("ID", "PRODUCT_ID", "QUANTITY"));
while ($arItems = $dbBasketItems->Fetch()) {
    $arItems = CSaleBasket::GetByID($arItems["ID"]);
    $countItemsInCart += $arItems['QUANTITY'];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <?php if (stripos(@$_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-MZVBCPFEDJ"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-MZVBCPFEDJ');
        </script>
    <?php endif; ?>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5"/>
    <link rel="alternate" hreflang="x-default" href="https://dev.skarlat.ua/">
    <link rel="alternate" hreflang="en" href="https://dev.skarlat.ua/en/">
    <link rel="canonical" href="https://<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['SCRIPT_URL']?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_TEMPLATE_PATH ?>/favicon/apple-icon-180x180.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_TEMPLATE_PATH ?>/favicon/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="96x96" href="<?= SITE_TEMPLATE_PATH ?>/favicon/favicon-96x96.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= SITE_TEMPLATE_PATH ?>/favicon/favicon-16x16.png"/>
    <meta name="msapplication-TileImage" content="<?= SITE_TEMPLATE_PATH ?>/favicon/ms-icon-144x144.png"/>
    <?if (SITE_ID == 'sh') {?>
        <meta name="p:domain_verify" content="9fe6b700ce7b5d60d37661c6df7291fe"/>
    <?}?>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="application-name" content="Skarlat.ua"/>
    <meta name="apple-mobile-web-app-title" content="Skarlat.ua"/>
    <meta name="msapplication-starturl" content="/"/>
    <meta name="facebook-domain-verification" content="mg7fduvtxd6n2kthq73xqkpo6kncvk" />
    <? $APPLICATION->ShowViewContent('OpenGraph'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title><? $APPLICATION->ShowTitle(false) ?></title>
    <?
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/reset.css");

    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/libs/jquery.fancybox.min.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/style.bundle.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/slick.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/additional.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/app.css");?>
    <?if(SITE_ID == 'sh' || SITE_ID == 'ae') {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/english_favorite.css");
    }
    if(CSite::InDir(SITE_DIR.'personal/')){
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/selectize.css");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/microplugin.js');
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/sifter.min.js');
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/selectize.min.js');
    }
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery-ui.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/slick.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.inputmask.js');
    if (SITE_ID == 'ae' || SITE_ID == 're' || SITE_ID == 'ue') {
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/additional_ae.js');
    }else{
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/additional_' . SITE_ID . '.js');
    }
    if(CSite::InDir(SITE_DIR.'catalog/')){
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/easyzoom.css");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/easyzoom.js');
       // $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/content-zoom-slider.min.js');

//        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jQuery-mooZoom-1.0.0.css");
//        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jQuery-mooZoom-1.0.0.js');
//        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.jqZoom.css");
//        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.jqZoom.js');
    }
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/app.js');
    $APPLICATION->ShowHead(); ?>
    <?php if (stripos(@$_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false): ?>
        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1054033791971682');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1054033791971682&ev=PageView&noscript=1"/></noscript>
        <!-- End Meta Pixel Code -->
    <?php endif; ?>
</head>
<body class="bx-background-image bx-theme-<?= $theme ?>" <? $APPLICATION->ShowProperty("backgroundImage"); ?>>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<?
if (!$_SESSION['WATERMARK_IMAGE']) {
    setWatermarkImage();
};
?>
<!-- HEADER START -->
<header class="header">
    <div class="header-content">
        <div class="header-content__wrap <?if($APPLICATION->GetCurPage(false) === '/' || $APPLICATION->GetCurPage(false) === '/ua/' || $APPLICATION->GetCurPage(false) === '/ru/'):?>dark-main-desktop<? endif; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header-content-wrapper">
                            <a href="<?= SITE_DIR ?>" class="logo" title="logo">
                                <svg viewBox="0 0 332 54.1">
                                    <path class="header-logo__path-1"
                                          d="M12 11.1c-.4-.8-.5-1.7-.3-2.5s.7-1.5 1.5-2c.8-.4 1.7-.5 2.5-.3s1.5.7 2 1.5l11.9 20.7c.4.6.6 1.4.6 2.1 0 .7-.1 1.3-.4 1.9l-12.2 20c-.5.8-1.2 1.3-2 1.5-.8.2-1.6.1-2.4-.3-.8-.5-1.3-1.2-1.5-2-.2-.8-.1-1.6.3-2.4l9.7-15.9H3.3c-.9 0-1.7-.4-2.3-1-.6-.6-1-1.4-1-2.3 0-.9.4-1.7 1-2.3.6-.6 1.4-1 2.3-1H21l-9-15.7z"></path>
                                    <path class="header-logo__path-2" fill="red"
                                          d="M29.1 40.7c-.5-.8-.5-1.7-.3-2.5s.7-1.5 1.5-2 1.7-.5 2.5-.3 1.5.7 2 1.5l6.8 11.7c.5.8.5 1.7.3 2.5s-.7 1.5-1.5 2-1.7.5-2.5.3-1.5-.7-2-1.5l-6.8-11.7zm6.8-32.8c.5-.8 1.2-1.4 2-1.6.8-.2 1.6-.1 2.4.3l.1.1c.8.5 1.3 1.2 1.5 2 .2.8.1 1.7-.3 2.5L35.4 22c-.5.8-1.2 1.3-2 1.5-.8.2-1.6.1-2.4-.3h-.1c-.8-.5-1.3-1.2-1.5-2-.2-.8-.1-1.6.3-2.4v-.1l6.2-10.8zm.7 25.3c-.9 0-1.7-.4-2.3-1-.6-.6-1-1.4-1-2.3 0-.9.4-1.7 1-2.3.6-.6 1.4-1 2.3-1h13.8c.9 0 1.7.4 2.3 1 .6.6 1 1.4 1 2.3 0 .9-.4 1.7-1 2.3-.6.6-1.4 1-2.3 1H36.6z"></path>
                                    <path class="header-logo__path-3" fill-rule="evenodd"
                                          d="M83.8 16.3h11.1v-6c-3.5 0-10.4-.4-13.4.2-5.3 1.1-9.4 5.6-9.4 11.5 0 5.8 5 11.6 10.9 11.6h8.9c3 0 5.4 2.7 5.4 5.7 0 2.7-1.9 5-4.4 5.6-3 .7-16.4.1-20.4.1v5.8h19.9c6.4 0 11.6-5.2 11.7-11.6.1-5-3.9-11.6-9.2-11.6H83.7c-3.2.1-5.7-2.3-5.7-5.6 0-3.4 2.6-5.5 5.8-5.7zm235.2-5h-6.1V0H306v32.9c1.3 13 11.4 18.5 23.4 18.5h2.6v-6h-3.8c-7.3 0-13.8-4.9-15.2-12.1 0-.1 0-.3-.1-.4V17.5h6.1v-6.2zm-25 33.5c-3.8 4-9.1 6.6-15.1 6.6-11.4 0-20.6-9.2-20.6-20.6 0-11.4 9.2-20.6 20.6-20.6 11.4 0 20.6 9.2 20.6 20.6l.4 20.2H294v-6.2zm-14.8-28.4c7.8 0 14.1 6.3 14.1 14.1s-6.3 14.1-14.1 14.1-14.1-6.3-14.1-14.1 6.3-14.1 14.1-14.1zm-41.3 16.5V10.2H231v22.7c1.3 13 11.4 18.5 23.4 18.5h2.6v-6h-3.8c-7.3 0-13.8-4.9-15.2-12.1 0-.2 0-.3-.1-.4zm-32.1-4.2v22.7h-6.9V28.7c1.2-12.5 11-18.5 22.7-18.5h3.2v6H221c-7.3 0-13.8 4.9-15.2 12.1.1.2.1.3 0 .4zm-19.3 16.1c-3.8 4-9.1 6.6-15.1 6.6-11.4 0-20.6-9.2-20.6-20.6 0-11.4 9.2-20.6 20.6-20.6 11.4 0 20.6 9.2 20.6 20.6l.4 20.2h-5.9v-6.2zm-14.8-28.4c7.8 0 14.1 6.3 14.1 14.1s-6.3 14.1-14.1 14.1-14.1-6.3-14.1-14.1 6.3-14.1 14.1-14.1zm-43.2 16.3c9.6 2.6 11.7 9.1 11.7 18.4h6.8c0-11.1-1.7-20.5-14.7-23.9l11.8-16.9h-8.4l-11 16.1H117V10.2h-7.2v40.7h7.2V32.6c2 0 10.2-.3 11.5.1z"></path>
                                </svg>
                            </a>
                            <div class="header-nav-wrapper">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:search.form",
                                    "skarlat",
                                    array(
                                        "PAGE" => "#SITE_DIR#catalog/",
                                        "USE_SUGGEST" => "N"
                                    )
                                ); ?>
                                <nav class="header-nav show" id="header-nav-info">
                                    <ul class="header-list tab <?if(in_array(SITE_ID,$no_shop_site_array)){?>header-list-end<?}?>">
                                        <? $APPLICATION->IncludeComponent(
                                            "bitrix:menu",
                                            "top_menu",
                                            array(
                                                "ALLOW_MULTI_SELECT" => "N",
                                                "CHILD_MENU_TYPE" => "top",
                                                "DELAY" => "N",
                                                "MAX_LEVEL" => "1",
                                                "MENU_CACHE_GET_VARS" => array(
                                                ),
                                                "MENU_CACHE_TIME" => "3600",
                                                "MENU_CACHE_TYPE" => "A",
                                                "MENU_CACHE_USE_GROUPS" => "N",
                                                "ROOT_MENU_TYPE" => "top_menu",
                                                "USE_EXT" => "N",
                                                "COMPONENT_TEMPLATE" => "top_menu"
                                            )
                                        ); ?>
                                        <li class="header-list__item">
                                            <?if (SITE_ID == 'ae' || SITE_ID == 're' || SITE_ID == 'ue') {?>
                                                <a class="header-lang <? if (SITE_ID == 'ae') { ?>active<? } ?>"
                                                   href="<?= $enUrl ?>">En</a>
                                                <a class="header-lang <? if (SITE_ID == 'ue') { ?>active<? } ?>"
                                                   href="<?= $uaUrl ?>">Ua</a>
                                                <a class="header-lang <? if (SITE_ID == 're') { ?>active<? } ?>"
                                                   href="<?= $ruUrl ?>">Ru</a>
                                            <?}else{?>
                                                <a class="header-lang <? if (SITE_ID == 'sh') { ?>active<? } ?>"
                                                   href="<?= $enUrl ?>">En</a>
                                                <a class="header-lang <? if (SITE_ID == 'mg') { ?>active<? } ?>"
                                                   href="<?/*= $uaUrl */?>https://skarlat.ua/">Ua</a>
                                            <?}?>
                                        </li>
                                        <li class="header-list__item" data-open="false">
                                            <button class="header-btn header-phone-app" title="<?=GetMessage("CONTACTS")?>">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 55 55" xml:space="preserve">
                                                        <path class="st1" d="M16.9,9.7l5.9,5.3c0.9,0.8,1.2,2.5,0.1,3.6c-6.6,6.6,3,14.6,3,14.6s8.9,8.7,14.8,1.4c1-1.3,2.7-1.1,3.6-0.3
                                                        l5.9,5.3c1.1,1,0.8,3-0.6,4.5c-2.3,2.4-5.6,4.9-9.5,5.5c-9.1,1.5-20.8-9-20.8-9S7.7,30.1,8.2,20.8c0.2-4,2.3-7.5,4.4-10.1
                                                        C13.9,9.2,15.9,8.8,16.9,9.7z"/>
                                                </svg>
                                            </button>
                                        </li>
                                        <li class="header-list__item search" data-open="false">
                                            <button class="header-btn" id="header-search-btn-app" title="<?=GetMessage("SEARCH")?>">
                                                <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 55 55" xml:space="preserve">
                                                        <path class="st1" d="M25.7,9.2c9,0,16.4,7.3,16.4,16.4c0,9-7.3,16.4-16.4,16.4S9.3,34.6,9.3,25.5C9.3,16.5,16.6,9.2,25.7,9.2z"/>
                                                        <line class="st2" x1="37" y1="37.3" x2="49.7" y2="49.8"/>
                                                </svg>
                                            </button>
                                        </li>
                                        <?if(!in_array(SITE_ID,$no_shop_site_array)){?>
                                            <li class="header-list__item personal" data-open="false">
                                                <button class="header-btn show" id="header-basket-btn-app" title="<?=GetMessage("PERSONAL")?>">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 55 55" xml:space="preserve">
                                                            <path class="st1" d="M36.7,35.6h-1.8c-0.5,0-0.9-0.2-1.1-0.9c0-0.5,0-0.9,0.2-1.1c3.7-3.2,6.2-9.6,6.2-13.5
                                                        c0-6-4.8-10.8-10.8-10.8c-6,0-10.3,4.8-10.3,10.8c0,4.1,2.3,10.3,6.2,13.5c0.2,0.2,0.5,0.7,0.2,1.1c-0.2,0.5-0.5,0.9-1.1,0.9
                                                        l-1.8,0c-6,0-10.8,4.8-10.8,10.8v2.3c0,0.7,0.5,1.1,1.1,1.1h33.2c0.7,0,1.1-0.5,1.1-1.1v-2.3C47.5,40.4,42.7,35.6,36.7,35.6z"/>
                                                    </svg>
                                                </button>
                                            </li>
                                        <?}?>
                                    </ul>
                                    <ul class="tab-burger">
                                        <li class="header-list__item menu" data-open="false">
                                            <button class="header-btn header-burger" id="burger" title="<?=GetMessage("MENU")?>">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-tab__wrapper">
            <div class="header-tab-content">
                <ul class="header-tab-content__list header-tab-content__list__category hide">
                    <?
                    $count=0;$arSelect = array("NAME", "SECTION_PAGE_URL", "PICTURE", "ID");
                    $arFilter = array("IBLOCK_ID" => $iblCatalog, "DEPTH_LEVEL" => 1, "ACTIVE" => "Y");
                    $obSections = CIBlockSection::GetList(array("SORT" => "asc"), $arFilter, false, $arSelect);
                    while ($ar_result = $obSections->GetNext()) {
                        $file = CFile::ResizeImageGet($ar_result['PICTURE'], array('width' => 307, 'height' => 205), BX_RESIZE_IMAGE_EXACT, true);
                        $activeElements = CIBlockSection::GetSectionElementsCount($ar_result['ID'], Array("CNT_ACTIVE"=>"Y"));
                        if($activeElements>0){
                            $count++;?>
                        <li class="header-tab-content__item animation">
                            <a href="<?= $ar_result["SECTION_PAGE_URL"] ?>" class="header-tab-content__link">
                                <img src="<?= $file["src"] ?>" alt="<?= $ar_result["NAME"] ?>"
                                     class="header-tab-content__img"/>
                                <span class="header-tab-content__title"><?= $ar_result["NAME"] ?></span>
                            </a>
                        </li>
                    <?}
                    }
                    if($count==0){?>
                        <li class="header-tab-content__item animation">
                            <h3><?=GetMessage("DIRECTORY_EMPTY")?></h3>
                        </li>
                    <?}?>
                </ul>
                <ul class="header-tab-content__list header-tab-content__list__info hide">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "PATH" => SITE_DIR."/include/header/top_menu_info.php"
                        ),
                        false
                    ); ?>
                </ul>
                <ul class="header-tab-content__list header-tab-content__list__help hide"></ul>
            </div>
        </div>
    </div>
    <div class="bg-shadow hide"></div>
    <div class="menu-wrapper hide" id="menu">
        <div class="container">
            <nav class="menu-nav" id="burger-nav-menu">
                <ul class="menu-list menu-mobile-parrent">
                    <li data-category="true" class="menu-item-category arrow" data-id="menu-category">
                        <a class="menu-link" href="javascript:void(0)"><?=GetMessage("CATEGORIES")?></a>
                    </li>
                    <li data-category="true" class="menu-item-category arrow" data-id="menu-info">
                        <a class="menu-link" href="javascript:void(0)"><?=GetMessage("INFO_PAGE")?></a>
                    </li>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "mobile_menu",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "mobile_menu",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "mobile_menu",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                    <li data-category="true" class="menu-item-category personal-menu-li arrow" data-id="menu-personal">
                        <a class="menu-link mobile-burger-active" href="javascript:void(0)"><?if($GLOBALS['USER']->IsAuthorized()){ echo \Bitrix\Main\Engine\CurrentUser::get()->getFullName();}else{echo GetMessage("PERSONAL");}?></a>
                        <a class="menu-link mobile-burger-disable" href="javascript:void(0)"><?=GetMessage("PERSONAL")?></a>
                    <li data-about="true" class="menu-item menu-last-lang-support">
                        <div class="lang-block">
                            <a class="header-lang <? if (SITE_ID == 'sh') { ?>active<? } ?>"
                               href="<?= $enUrl ?>">En</a>
                            <a class="header-lang <? if (SITE_ID == 'mg') { ?>active<? } ?>"
                               href="<?= $uaUrl ?>">Ua</a>
                            <?if (SITE_ID == 'ae' || SITE_ID == 're' || SITE_ID == 'ue') {?>
                                <a class="header-lang <? if (SITE_ID == 're') { ?>active<? } ?>"
                                   href="<?= $ruUrl ?>">Ru</a>
                            <?}?>

                        </div>
                        <div class="support-block">
                            <a class="header-phone-app"><?=GetMessage("SUPPORT")?></a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div id="menu-category" class="menu-category">
                <div class="container">
                    <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "catalog_mobile",
                    array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "CHILD_MENU_TYPE" => "catalog_mobile",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "3",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "catalog_mobile",
                        "USE_EXT" => "Y"
                    ),
                    false
                ); ?>
                </div>
            </div>
            <div id="menu-info" class="menu-category">
                <div class="container">
                    <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "catalog_mobile",
                    array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "CHILD_MENU_TYPE" => "mobile_info",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "3",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "mobile_info",
                        "USE_EXT" => "Y"
                    ),
                    false
                ); ?>
                </div>
            </div>
            <div id="menu-personal" class="menu-category">
                <div class="container">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "catalog_mobile",
                        array(
                            "ALLOW_MULTI_SELECT" => "Y",
                            "CHILD_MENU_TYPE" => "user_menu",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "3",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "user_menu",
                            "USE_EXT" => "Y"
                        ),
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>
    <aside class="basket-aside__wrap">
        <div class="basket-aside" id="basket">
            <a href="<? if ($USER->IsAuthorized()) {
                echo SITE_DIR; ?>personal/<? } else {
                echo SITE_DIR; ?>auth/<? } ?>" class="account">
                <? if (\Bitrix\Main\Engine\CurrentUser::get()->getId()) { ?>
                    <svg viewBox="0 0 25 25">
                        <g>
                            <path d="M24.5801 11.176L13.3635 0.955395C12.8711 0.506714 12.1287 0.506763 11.6366 0.955346L0.419826 11.176C0.0254415 11.5354 -0.104832 12.0891 0.0878438 12.5866C0.280568 13.0841 0.749805 13.4056 1.28335 13.4056H3.07485V23.6458C3.07485 24.0518 3.40405 24.381 3.81005 24.381H9.95819C10.3642 24.381 10.6934 24.0519 10.6934 23.6458V17.4283H14.3068V23.6459C14.3068 24.0519 14.636 24.3811 15.042 24.3811H21.1898C21.5958 24.3811 21.925 24.0519 21.925 23.6459V13.4056H23.7169C24.2503 13.4056 24.7196 13.0841 24.9124 12.5866C25.1048 12.0891 24.9745 11.5354 24.5801 11.176Z"
                                  fill="#787878"/>
                            <path d="M21.7329 2.08643H16.7954L22.4681 7.24442V2.82158C22.4681 2.41558 22.1389 2.08643 21.7329 2.08643Z"
                                  fill="#787878"/>
                        </g>
                    </svg>
                    <div class="account-info">
                    <span>
                        <? echo \Bitrix\Main\Engine\CurrentUser::get()->getFullName(); ?>
                   </span>
                        <? if (\Bitrix\Main\Engine\CurrentUser::get()->getId()) { ?>
                            <p><?= \Bitrix\Main\Engine\CurrentUser::get()->getEmail(); ?></p>
                        <? } ?>
                    </div>
                <? }else{ ?>
                <span><?=GetMessage("SING_IN")?><span>
                <?}?>
            </a>
            <nav class="basket-aside__nav">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "auth_user_menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "user_menu",
                        "USE_EXT" => "N"
                    )
                ); ?>
            </nav>
        </div>
    </aside>
</header>
<div class="header-fix"></div>
<main>
    <?
    if ($APPLICATION->GetCurPage() != '/' && $APPLICATION->GetCurPage() != '/en/' && $APPLICATION->GetCurPage() != '/ru/' && $APPLICATION->GetCurPage() != '/ua/') {
        ?>
        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "main_crumbs", array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => SITE_ID
        ),
            false
        ); ?>
    <? } ?>
