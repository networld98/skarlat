<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
    <div class="basket-block-footer">
        <div class="basket-block-footer__wrapper">
            <div class="basket-total__price">
                <span class="basket-total__price-title"><?=Loc::getMessage('SBB_TOTAL')?></span>
                <div class="basket-product-price">
                    {{#DISCOUNT_PRICE_FORMATED}}
                        <div class="basket-product-price-old">
                            <span class="basket-product-price-old__value">{{{PRICE_WITHOUT_DISCOUNT}}}</span>
                            <span class="basket-product-price-old__currency">{{{CURRENCY}}}</span>
                        </div>
                    {{/DISCOUNT_PRICE_FORMATED}}
                    <span class="basket-product-price__value basket-total__price-sum" data-entity="basket-total-price">{{{PRICE_FORMATED}}}</span>
                </div>
            </div>
            <?
            if ($arParams['HIDE_COUPON'] !== 'Y')
            {
            ?>
            <div class="basket-coupon-alert-section basket-promo-block">
                <div class="basket-coupon-alert-inner">
                    {{#COUPON_LIST}}
                    <div class="basket-coupon-alert text-{{CLASS}}">
                <span class="basket-coupon-text">
                    <strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
                </span>
                        <span class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
                    <?=Loc::getMessage('SBB_DELETE')?>
                </span>
                    </div>
                    {{/COUPON_LIST}}
                </div>
            </div>
            <div id="promo" class="basket-promo-block">
                <p><?=Loc::getMessage('SBB_COUPON_ENTER')?></p>
                <input type="text" class="basket-promo-input" id="" placeholder="" data-entity="basket-coupon-input">
            </div>
           <button class="promo" data-promo="true" id="promoBtn"><?=Loc::getMessage('SBB_COUPON_BTN')?></button>
                <?
            }
            ?>
            <button class="primary basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
                    data-entity="basket-checkout-button">
                <?=Loc::getMessage('SBB_ORDER')?>
            </button>
        </div>
    </div>
</script>