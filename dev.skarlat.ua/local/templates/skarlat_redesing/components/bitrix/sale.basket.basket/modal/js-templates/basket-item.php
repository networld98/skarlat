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
	 <div class="basket-item" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
			<button type="button" class="basket-item__close close" aria-label="Close" data-entity="basket-item-delete">
                <span aria-hidden="true">
                  <svg viewBox="0 0 10 10">
                    <path
                      d="M6.9 1.3v-1c0-.2-.2-.3-.3-.3H3.4c-.1 0-.3.1-.3.3v.9H.6v.6h.6v7.5c0 .3.3.6.6.6h6.3c.3 0 .6-.3.6-.6V1.9h.6v-.6H6.9zM3.8.6h2.5v.6H3.8V.6zm3 6.3l-.5.6-1.4-1.6-1.4 1.6-.5-.6 1.4-1.4L3 4l.5-.5L4.9 5l1.4-1.4.5.5-1.4 1.4 1.4 1.4z"
                    />
                  </svg>
                </span>
            </button>
			<div class="basket-item__info" id="basket-item-height-aligner-{{ID}}">
                <div class="basket-item__info-wrapper-img">
					{{#DETAIL_PAGE_URL}}
						<a href="{{DETAIL_PAGE_URL}}">
					{{/DETAIL_PAGE_URL}}
					  <img
						alt="image"
						src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}"
					  />
					{{#DETAIL_PAGE_URL}}
						</a>
					{{/DETAIL_PAGE_URL}}
                </div>

                <div class="basket-item__info-wrapper">
					<div class="error-mess">
						{{#WARNINGS.length}}
							{{#WARNINGS}}
								<div data-entity="basket-item-warning-text">{{{.}}}</div>
							{{/WARNINGS}}
						{{/WARNINGS.length}}
					</div>
					{{#DETAIL_PAGE_URL}}
						<a href="{{DETAIL_PAGE_URL}}" class="basket-item__info_title">
					{{/DETAIL_PAGE_URL}}
						{{NAME}}
					{{#DETAIL_PAGE_URL}}
						</a>
					{{/DETAIL_PAGE_URL}}
					<?
							if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
							{
								foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
								{
									switch (trim((string)$blockName))
									{
										case 'props':
											if (in_array('PROPS', $arParams['COLUMNS_LIST']))
											{
												?>
												{{#PROPS}}
													<div class="basket-item__info_sku">
														{{{NAME}}}:
														<span class="code" data-entity="basket-item-property-value" data-property-code="{{CODE}}">{{{VALUE}}}</span>
													</div>
												{{/PROPS}}
												<?
											}

											break;
										case 'sku':
											?>
											{{#SKU_BLOCK_LIST}}
												{{#IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-image"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																				<span class="basket-item-scu-item-inner"
																					style="background-image: url({{PICT}});"></span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}

												{{^IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-text"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																		<span class="basket-item-scu-item-inner">{{NAME}}</span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}
											{{/SKU_BLOCK_LIST}}

											<?
											break;
										case 'columns':
											?>
											{{#COLUMN_LIST}}
												{{#IS_TEXT}}
													<div class="basket-item__info_sku">
														{{NAME}}:
														<span class="code" data-column-property-code="{{CODE}}" data-entity="basket-item-property-column-value">{{VALUE}}</span>
													</div>
												{{/IS_TEXT}}
											{{/COLUMN_LIST}}
											<?
											break;
									}
								}
							}
							?>
                    <div class="basket-item__info_price">
                        {{#SHOW_DISCOUNT_PRICE}}
                            <div class="basket-item__info_price-old">
                                {{{FULL_PRICE}}}
                                <div class="basket-item__info_price-old-currency">{{{CURRENCY_FORMATED}}}</div>
                            </div>
                        {{/SHOW_DISCOUNT_PRICE}}
                        <div class="basket-item__info_price-new">
                            {{{PRICE}}}
                            <div class="basket-item__info_price-new-currency">{{{CURRENCY_FORMATED_ITEM}}}</div>
                        </div>
                    </div>
                </div>
            </div>

			<div class="basket-item__button">
                <div class="basket-item__total">
					<span id="basket-item-sum-price-{{ID}}">{{{SUM_FULL_RIGHT_PRICE}}}</span>
                    <div class="basket-item__total-currency">{{{CURRENCY_FORMATED}}}</div>
                </div>
                <div class="btn-group basket-item__button-group-quantity" role="group" data-entity="basket-item-quantity-block">
					<button type="button" class="basket-item__button-minus"  data-entity="basket-item-quantity-minus">-</button>
						<input type="number" {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}} class="basket-item__button-quantity" min="{{MIN_CONT}}" value="{{QUANTITY}}" data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field" id="basket-item-quantity-{{ID}}" />
					<button type="button" class="basket-item__button-add" data-entity="basket-item-quantity-plus">+</button>
                </div>
              </div>
	</div>
</script>
