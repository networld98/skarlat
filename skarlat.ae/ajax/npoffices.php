<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
use Bitrix\Main\Config\Option;

$np = Option::get("maycat.d7dull", "np");

CModule::IncludeModule("iblock");

if(LANGUAGE_ID!=='ua' || LANGUAGE_ID!=='ru'){
    $LANGUAGE_ID = 'ua';
}else{
    $LANGUAGE_ID = LANGUAGE_ID;
}

if (is_numeric($_REQUEST['city'])) {
    if(CModule::IncludeModule("sale")) {
        $arLocs = CSaleLocation::GetByID($_REQUEST['city'],  $LANGUAGE_ID);
        $arLocs["CITY_NAME"] = str_replace(", місто","",$arLocs["CITY_NAME"]);
    }
} else {
    $arLocs["CITY_NAME"] = $_REQUEST['city'];
}

$arLocs["CITY_NAME"] = str_replace(", місто","",$arLocs["CITY_NAME"]);
$arLocs["CITY_NAME"] = str_replace(" селище","",$arLocs["CITY_NAME"]);
$arLocs["CITY_NAME"] = str_replace(" смт","",$arLocs["CITY_NAME"]);
$refId=$np;
$arFilter = array('IBLOCK_ID' => $refId, "NAME"=>$arLocs["CITY_NAME"]);
$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
while ($arSect = $rsSect->fetch()){
	$sect=$arSect['ID'];
}
if($sect>0):
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "SECTION_ID", "CODE");
$arFilter = Array("IBLOCK_ID"=>$refId,"SECTION_ID"=>$sect);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
?>

<select class="form-control" name="ORDER[PROPS][NP_OFFICE]" <?if($_POST['required']=="required"):?>required="required"<?endif;?> id="selectPost">
<?
if($res->SelectedRowsCount()<1):
?>
	<script>
	$(document).ready(function(){
		$('#order-block__delivery-item-np-cur').removeAttr('checked');
		$('#order-block__delivery-item-np').removeAttr('checked');	
		
		$('#order-block__delivery-item-np-cur').attr('disabled','disabled');
		$('#order-block__delivery-item-np').attr('disabled','disabled');
	});
	</script>
    <option value="">No branches found in this city</option>
<?
endif;
?>
<option value="curier">-- to choose --</option>
<?
while($ob = $res->fetch()){ 
	?>
	<script>
		$(document).ready(function(){
			$('#order-block__delivery-item-np-cur').removeAttr('disabled');
			$('#order-block__delivery-item-np').removeAttr('disabled');
		});
	</script>
	<option value="<?=$ob['NAME']?>" <?if($ob['NAME']==$_REQUEST['set']) echo 'selected';?>><?=$ob['NAME']?></option>
	<?
}
?>
</select>
<?else:?>
	<script>
	$(document).ready(function(){
		$('#order-block__delivery-item-np-cur').removeAttr('checked');
		$('#order-block__delivery-item-np').removeAttr('checked');
		$('#order-block__delivery-item-np-cur').attr('disabled','disabled');
		$('#order-block__delivery-item-np').attr('disabled','disabled');
	});
	</script>
	<select class="form-control" name="ORDER[PROPS][NP_OFFICE]" <?if($_POST['required']=="required"):?>required="required"<?endif;?> id="selectPost">
        <option value="">No branches found in this city</option>
    </select>
<?endif;?>