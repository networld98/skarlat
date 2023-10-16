<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;

CJSCore::init(array('popup', 'ajax'));

$this->setFrameMode(true);

$landingId = null;
if (is_callable(["LandingPubComponent", "getMainInstance"]))
{
	$instance = \LandingPubComponent::getMainInstance();
	$landingId = $instance["SITE_ID"];
}

$strMainId = $this->getEditAreaId($arResult['PRODUCT_ID']);
$jsObject = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainId);
$paramsForJs = array(
	'buttonId' => $arResult['BUTTON_ID'],
	'jsObject' => $jsObject,
	'alreadySubscribed' => $arResult['ALREADY_SUBSCRIBED'],
	'listIdAlreadySubscribed' => (!empty($_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID']) ?
		$_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID'] : []),
	'productId' => $arResult['PRODUCT_ID'],
	'buttonClass' => htmlspecialcharsbx($arResult['BUTTON_CLASS']),
	'urlListSubscriptions' => '/',
	'landingId' => ($landingId ? $landingId : 0)
);

$showSubscribe = true;

/* Compatibility with the sale subscribe option */
$saleNotifyOption = Bitrix\Main\Config\Option::get('sale', 'subscribe_prod');
if(strlen($saleNotifyOption) > 0)
	$saleNotifyOption = unserialize($saleNotifyOption);
$saleNotifyOption = is_array($saleNotifyOption) ? $saleNotifyOption : array();
foreach($saleNotifyOption as $siteId => $data)
{
	if($siteId == SITE_ID && $data['use'] != 'Y')
		$showSubscribe = false;
}
$templateData = $paramsForJs;
$templateData['showSubscribe'] = $showSubscribe;

$subscribeBtnName = !empty($arParams['MESS_BTN_SUBSCRIBE']) ? $arParams['MESS_BTN_SUBSCRIBE'] : Loc::getMessage('CPST_SUBSCRIBE_BUTTON_NAME');

if($showSubscribe):?>
	<button class="product-item__wrapper-block-btn_favorite" id="<?=htmlspecialcharsbx($arResult['BUTTON_ID'])?>" data-item="<?=htmlspecialcharsbx($arResult['PRODUCT_ID'])?>">
        <svg class="heart" viewBox="0 0 20 20">
            <path d="M18.5 2.9c-.9-1.1-2.3-1.7-3.8-1.7-2.1 0-3.5 1.3-4.2 2.3-.2.3-.4.5-.5.8-.1-.3-.3-.5-.5-.8-.7-1-2.1-2.3-4.2-2.3-1.5 0-2.9.6-3.9 1.7C.5 4 0 5.4 0 7c0 1.6.6 3.2 2.1 4.9 1.2 1.5 3 3 5.1 4.8.8.6 1.6 1.3 2.4 2.1h.1c.1.1.2.1.4.1s.3 0 .4-.1h.1c.9-.8 1.6-1.4 2.4-2.1 2.1-1.8 3.9-3.3 5.1-4.8C19.4 10.2 20 8.6 20 7c0-1.6-.5-3-1.5-4.1zm-6.4 12.8c-.6.6-1.4 1.1-2.1 1.8l-2.1-1.8C3.9 12.3 1.1 10 1.1 7c0-1.3.4-2.4 1.2-3.3.7-.9 1.8-1.4 2.9-1.4 1.6 0 2.6 1 3.3 1.9.6.7.9 1.5.9 1.8.1.2.3.3.6.3.2 0 .5-.1.6-.4.1-.3.4-1.1.9-1.8.6-.9 1.6-1.9 3.3-1.9 1.1 0 2.2.5 2.9 1.4.8.9 1.1 2 1.1 3.3 0 3.1-2.7 5.4-6.7 8.8z"/>
        </svg>
    </button>     
	<input type="hidden" id="<?=htmlspecialcharsbx($arResult['BUTTON_ID'])?>_hidden">

	<script type="text/javascript">
		BX.message({
			CPST_SUBSCRIBE_POPUP_TITLE: '<?=GetMessageJS('CPST_SUBSCRIBE_POPUP_TITLE');?>',
			CPST_SUBSCRIBE_BUTTON_NAME: '<?=$subscribeBtnName?>',
			CPST_SUBSCRIBE_BUTTON_CLOSE: '<?=GetMessageJS('CPST_SUBSCRIBE_BUTTON_CLOSE');?>',
			CPST_SUBSCRIBE_MANY_CONTACT_NOTIFY: '<?=GetMessageJS('CPST_SUBSCRIBE_MANY_CONTACT_NOTIFY');?>',
			CPST_SUBSCRIBE_LABLE_CONTACT_INPUT: '<?=GetMessageJS('CPST_SUBSCRIBE_LABLE_CONTACT_INPUT');?>',
			CPST_SUBSCRIBE_VALIDATE_UNKNOW_ERROR: '<?=GetMessageJS('CPST_SUBSCRIBE_VALIDATE_UNKNOW_ERROR');?>',
			CPST_SUBSCRIBE_VALIDATE_ERROR_EMPTY_FIELD: '<?=GetMessageJS('CPST_SUBSCRIBE_VALIDATE_ERROR_EMPTY_FIELD');?>',
			CPST_SUBSCRIBE_VALIDATE_ERROR: '<?=GetMessageJS('CPST_SUBSCRIBE_VALIDATE_ERROR');?>',
			CPST_SUBSCRIBE_CAPTCHA_TITLE: '<?=GetMessageJS('CPST_SUBSCRIBE_CAPTCHA_TITLE');?>',
			CPST_STATUS_SUCCESS: '<?=GetMessageJS('CPST_STATUS_SUCCESS');?>',
			CPST_STATUS_ERROR: '<?=GetMessageJS('CPST_STATUS_ERROR');?>',
			CPST_ENTER_WORD_PICTURE: '<?=GetMessageJS('CPST_ENTER_WORD_PICTURE');?>',
			CPST_TITLE_ALREADY_SUBSCRIBED: '<?=GetMessageJS('CPST_TITLE_ALREADY_SUBSCRIBED');?>',
			CPST_POPUP_SUBSCRIBED_TITLE: '<?=GetMessageJS('CPST_POPUP_SUBSCRIBED_TITLE');?>',
			CPST_POPUP_SUBSCRIBED_TEXT: '<?=GetMessageJS('CPST_POPUP_SUBSCRIBED_TEXT');?>'
		});

		var <?=$jsObject?> = new JCCatalogProductSubscribe(<?=CUtil::phpToJSObject($paramsForJs, false, true)?>);
	</script>
<?endif;