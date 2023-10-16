<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 */

CUtil::InitJSCore(array("popup"));

$arAuthServices = $arPost = array();
if(is_array($arParams["~AUTH_SERVICES"]))
{
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if(is_array($arParams["~POST"]))
{
	$arPost = $arParams["~POST"];
}

$hiddens = "";
foreach($arPost as $key => $value)
{
	if(!preg_match("|OPENID_IDENTITY|", $key))
	{
		$hiddens .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />'."\n";
	}
}
?>
<script type="text/javascript">
function BxSocServPopup(id)
{
	var content = BX("bx_socserv_form_"+id);
	if(content)
	{
		var popup = BX.PopupWindowManager.create("socServPopup"+id, BX("bx_socserv_icon_"+id), {
			autoHide: true,
			closeByEsc: true,
			angle: {offset: 24},
			content: content,
			offsetTop: 3
		});

		popup.show();

		var input = BX.findChild(content, {'tag':'input', 'attribute':{'type':'text'}}, true);
		if(input)
		{
			input.focus();
		}

		var button = BX.findChild(content, {'tag':'input', 'attribute':{'type':'submit'}}, true);
		if(button)
		{
			button.className = 'btn btn-primary';
		}
	}
}
</script>

<?
foreach($arAuthServices as $service):
	$onclick = ($service["ONCLICK"] <> ''? $service["ONCLICK"] : "BxSocServPopup('".$service["ID"]."')");
?>
        <div class="form-group form-group-center">
            <button class="btn-outline btn-fb"
                    id="bx_socserv_icon_<?=$service["ID"]?>"
                    onclick="<?=\Bitrix\Main\Text\HtmlFilter::encode($onclick)?>">
                <?if($service["ID"] == 'Facebook'):?>
                    <svg viewbox="0 0 10 10">
                        <path
                                d="M5.5 10.2V5.6h1.3L7 3.7H5.5V2.4c0-.5.3-.7.6-.7H7V.1C6.9 0 6.7 0 6.6 0h-.8c-.4 0-.8.1-1.1.4-.4.4-.6.8-.7 1.4V3.7H2.7v1.8H4v4.6h1.5z"
                        />
                    </svg>
                    Facebook
                <?endif?>
                <?if($service["ID"] == 'GoogleOAuth'):?>
                    <svg viewbox="0 0 10 10">
                        <path
                                fill="#FBBB00"
                                d="M2.2 6l-.3 1.3H.6C.2 6.7 0 5.9 0 5c0-.8.2-1.6.6-2.3l1.1.2.5 1.1c-.1.3-.2.7-.2 1 0 .4.1.7.2 1z"
                        />
                        <path
                                fill="#518EF8"
                                d="M9.9 4.1c.1.3.1.6.1.9 0 .4 0 .7-.1 1-.3 1.2-.9 2.2-1.8 2.9l-1.4-.1-.2-1.2c.6-.3 1-.9 1.3-1.5H5.1v-2H9.9z"
                        />
                        <path
                                fill="#28B446"
                                d="M8.1 8.9C7.3 9.6 6.2 10 5 10 3.1 10 1.4 8.9.6 7.4L2.2 6C2.6 7.2 3.7 8 5 8c.5 0 1.1-.1 1.5-.4l1.6 1.3z"
                        />
                        <path
                                fill="#F14336"
                                d="M8.2 1.2L6.6 2.5C6.1 2.2 5.6 2 5 2c-1.3 0-2.4.9-2.8 2L.6 2.7C1.4 1.1 3.1 0 5 0c1.2 0 2.3.4 3.2 1.2z"
                        />
                    </svg>
                    Google
                <?endif?>
            </button>
            <?if($service["ONCLICK"] == '' && $service["FORM_HTML"] <> ''):?>
                <div id="bx_socserv_form_<?=$service["ID"]?>" class="bx-authform-social-popup">
                    <form action="<?=$arParams["AUTH_URL"]?>" method="post">
                        <?=$service["FORM_HTML"]?>
                        <?=$hiddens?>
                        <input type="hidden" name="auth_service_id" value="<?=$service["ID"]?>" />
                    </form>
                </div>
            <?endif?>
        </div>
<?
endforeach;
?>
