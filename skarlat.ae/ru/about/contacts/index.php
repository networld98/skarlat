<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "светильники, купить светильник, светодиодные светильники, потолочные светильники, точечные светильники, led светильники, настенные светильники, светильник, светильники киев, интернет магазин, интернет, магазин, люстры, торшеры, светильники," );
$APPLICATION->SetPageProperty("description", "Контакты - Свет для дома по самым лучшим ценам - ✅ Светильники SKARLAT 🔅 Огромный выбор 💥 Всегда в наличии на складе ✈ Доставка по Украине ☎: (044) 76 339 82 48 skarlat.ua");
$APPLICATION->SetTitle("Контакты");
?>
<section class="bg-lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-head">
                    <h1 id="change-title"><?$APPLICATION->ShowTitle()?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12 contacts-left-right">
        <div class="info-content map">
             <iframe
                    allowfullscreen=""
                    height="600"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d162757.72582758658!2d30.392608824595417!3d50.40217023835585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf4ee15a4505%3A0x764931d2170146fe!2z0JrQuNC10LIsIDAyMDAw!5e0!3m2!1sru!2sua!4v1574669525773!5m2!1sru!2sru"
                    style="border:0; width:100%">
             </iframe>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-xs-12 mb-5 contacts-left-right">
        <div class="">
            <div class="row contact-page-content">
                <div class="col-lg-12">
                    <h2 class="text-color">ЯК З НАМИ ЗВ`ЯЗАТИСЯ?</h2>
                </div>
                <div class="col-12 col-md-6 col-lg-6 cont-block">
                    <h3>Зателефонуйте нам</h3>
                    <p><a href="tel:+380443339296">+38 (044) 333 92 96</a></p>
                    <p><a href="tel:+380679387248">+38 (067) 938 72 48</a></p>
                </div>
                <div class="col-12 col-md-6 col-lg-6 cont-block">
                    <h3>Напишіть нам</h3>
                    <p><a href="mailto:shop@skarlat.ua">shop@skarlat.ua</a></p>
                </div>
                <div class="col-12 col-md-6 col-lg-6 cont-block">
                    <h3>Завітайте до нас</h3>
                    <p>м. Київ</p>
                    <p>вул. Івана Пуддубного, 9</p>
                    <p>Україна</p>
                </div>
                <div class="col-12 col-md-6 col-lg-6 cont-block">
                    <h3>Підпишіться на нас</h3>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "contacts",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "bottom",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "contact_social",
                            "USE_EXT" => "N"
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>