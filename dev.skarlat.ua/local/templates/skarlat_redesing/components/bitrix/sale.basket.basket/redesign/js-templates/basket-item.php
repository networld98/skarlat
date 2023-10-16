<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
	<tr class="basket-list__item basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}}"
		id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        {{#SHOW_RESTORE}}
        <td class="basket-items-list-item-notification" colspan="<?=$restoreColSpan?>">
            <div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
                {{#SHOW_LOADING}}
                <div class="basket-items-list-item-overlay"></div>
                {{/SHOW_LOADING}}
                <div class="basket-items-list-item-removed-container">
                    <div>
                        <?=Loc::getMessage('SBB_GOOD_CAP')?> <strong>{{NAME}}</strong> <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.
                    </div>
                    <div class="basket-items-list-item-removed-block">
                        <a href="javascript:void(0)" data-entity="basket-item-restore-button">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
                        </a>
                        <span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
                    </div>
                </div>
            </div>
        </td>
        {{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<td class="basket-items-list-item-descriptions">
                <a href="{{DETAIL_PAGE_URL}}" class="basket-product__img-block">
                    <div class="basket-product__img-wrapper">
                        <img class="basket-product__img" alt="{{NAME}}"
                             src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}">
                        <?
                        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                        {
                            ?>
                            {{#DISCOUNT_PRICE_PERCENT}}
                            <div class="basket-item-label-ring basket-item-label-small <?=$discountPositionClass?>">
                                -{{DISCOUNT_PRICE_PERCENT_FORMATED}}
                            </div>
                            {{/DISCOUNT_PRICE_PERCENT}}
                            <?
                        }
                        ?>
                    </div>
                </a>
                <div class="basket-product__info">
                    <a href="{{DETAIL_PAGE_URL}}" class="basket-product__title">
                        <div class="basket-product__title-wrap">
                            <p>{{SHORT_CATEGORY_NAME}}</p>
                            <p>{{NAME}}</p>
                        </div>
                        <div class="basket-product-price d-flex d-md-none">
                            <span class="basket-product-price__value">{{{SUM_FULL_PRICE_FORMATED}}}</span>
                        </div>
                    </a>
                    <div class="basket-product__btn-block">
                        <div class="basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}} product-quantity"
                             data-entity="basket-item-quantity-block">
                            <span class="product-quantity-decrement" data-entity="basket-item-quantity-minus">-</span>
                            <div class="basket-item-amount-filed-block">
                                <input type="text" class="product-quantity-value" value="{{QUANTITY}}"
                                       {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
                                data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                                id="basket-item-quantity-{{ID}}">
                            </div>
                            <span class="product-quantity-increment" data-entity="basket-item-quantity-plus">+</span>
                        </div>
                        <div class="basket-product__btn">
                            <div class="basket-product-price d-none d-md-flex">
                                <span class="basket-product-price__value">{{{SUM_FULL_PRICE_FORMATED}}}</span>
                            </div>
                            <button class="basket-product__remove" data-entity="basket-item-delete"><?=Loc::getMessage('SBB_DELETE')?></button>
                        </div>
                    </div>
                </div>
            </td>
		{{/SHOW_RESTORE}}
	</tr>
</script>