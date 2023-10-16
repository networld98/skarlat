<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="basket__btn_wrapper-group" data-entity="basket-checkout-aligner">
		<div class="basket__btn_wrapper-group-total">
			<span class="basket__btn_wrapper-group-total-text"><?=Loc::getMessage('SBB_TOTAL')?>:</span>
			<span class="basket__btn_wrapper-group-total-value" data-entity="basket-total-price">{{{PRICE}}}</span>
            <div class="basket__btn_wrapper-group-total-currency"><?=Loc::getMessage('CURRENCY_UAH')?></div>
		</div>
		<button class="basket__btn-accept {{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}" id="basketModalButton" data-entity="basket-checkout-button" ><?=Loc::getMessage('SBB_ORDER')?></button>
	</div>
</script>
