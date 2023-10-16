<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="order-block-basket__info" data-entity="basket-checkout-aligner">
        <span><?=Loc::getMessage('TOTAL')?></span>
		<input type="hidden" id="fullprice" value="{{{PRICE}}}">
        <div class="order-block-basket__total">
            <span data-entity="basket-total-price" id="fullprice_formated">{{{PRICE}}}</span>
            <div class="order-block-basket__total-currency"><?=Loc::getMessage('CURRENCY')?></div>
        </div>
    </div>
    <button class="order-block-basket__buy" onclick="$('#falseButton').click();"><?=Loc::getMessage('SBB_ORDER')?></button>
</script>
