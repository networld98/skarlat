<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$userName = CUser::GetFullName();
if (!$userName)
	$userName = CUser::GetLogin();
?>
<script>
	<?if ($userName):?>
	BX.localStorage.set("eshop_user_name", "<?=CUtil::JSEscape($userName)?>", 604800);
	<?else:?>
	BX.localStorage.remove("eshop_user_name");
	<?endif?>

	<?if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0 && preg_match('#^/\w#', $_REQUEST["backurl"])):?>
	document.location.href = "<?=CUtil::JSEscape($_REQUEST["backurl"])?>";
	<?endif?>
</script>
<?
$APPLICATION->SetTitle("Авторизация");
?>
    <section class="bg-lightgrey">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="block-head">
                        <h1>You are registered and successfully logged in.</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div class="container block-mb">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="info-content">
                <p><a class="promo" href="<?=SITE_DIR?>">Return to the main page</a></p>
            </div>
        </div>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>