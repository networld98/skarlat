<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if(count($arResult["SEARCH"])>0):?>
<div class="container">
    <div class="search-block">
        <h1 class="search-block__title"><?echo GetMessage("CT_SEARCH_RESULT")?>:</h1>
    </div>
</div>
<?endif;?>
<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>