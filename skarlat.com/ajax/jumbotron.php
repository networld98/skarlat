<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
CComponentUtil::__IncludeLang(dirname(SITE_TEMPLATE_PATH."/skarlat/"), "/header.php")
?>
<? if(basketItemsCount() !== 0): ?>
<!-- JUMBOTRON BASKET START -->
<div class="jumbotron jumbotron-basket jumbotron-fluid" id="jumbotronBasket">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col d-flex align-items-center justify-content-start">
                        <div class="jumbotron-basket-title">
                            <h3>
                                <?=GetMessage("IN_BASKET_PRESENT")?>
                                <a href="javascript:void(0)" id="basketModalButtonJumbotronBasketTitle">
                                    <?=basketItemsCount()?> <?=GetMessage("PRODUCT")?><?=BITGetDeclNum(basketItemsCount(), GetMessage("PRODUCT_ENDING"))?>
                                </a>
                            </h3>
                            <div class="jumbotron-basket-value">
                                <span><?=GetMessage("ON_SUM")?></span>
                                <div class="jumbotron-basket-price">
                                    <?=basketPrice()?>
                                    <div class="jumbotron-basket-currency">
                                        <?=GetMessage("CURRENCY_".CCurrency::GetBaseCurrency())?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/main_page/jumbotron_basket_list.php"
                            )
                        );?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex jumbotron-basket-btn-block--wrapper">
                <div class="jumbotron-basket-btn-block">
                    <a class="jumbotron-basket-btn-basket" id="basketModalButtonJumbotronBasket" href="javascript:void(0)" role="button"><?=GetMessage("IN_BASKET")?></a>
                    <a class="jumbotron-basket-btn-pay" href="/personal/order/make/"><?=GetMessage("ORDER")?></a>
                </div>
            </div>
            <button type="button" class="close jumbotron-basket-close" aria-label="Close">
                <span aria-hidden="true">
                    <svg viewBox="0 0 20 20">
                        <path
                                d="M.8 0L0 .8 9.2 10 0 19.2l.8.8 9.2-9.2 9.2 9.2.8-.8-9.2-9.2L20 .8l-.8-.8L10 9.2.8 0z"
                        />
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){showLazyPics();});
</script>
<!-- JUMBOTRON BASKET END -->
<? endif; ?>