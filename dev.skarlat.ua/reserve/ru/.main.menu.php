<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock'))
{
	$arFilter = array(
		"TYPE" => "catalog",
		"SITE_ID" => SITE_ID,
		"ID" => "29"
	);

	$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
	$dbIBlock = new CIBlockResult($dbIBlock);

	if ($arIBlock = $dbIBlock->GetNext())
	{
		if(defined("BX_COMP_MANAGED_CACHE"))
			$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

		if($arIBlock["ACTIVE"] == "Y")
		{
			$aMenuLinksExt = $APPLICATION->IncludeComponent("custom:menu.sections", "", array(
				"IS_SEF" => "Y",
				"SEF_BASE_URL" => "",
				"SECTION_PAGE_URL" => $arIBlock['SECTION_PAGE_URL'],
				"DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
				"IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
				"IBLOCK_ID" => $arIBlock['ID'],
				"DEPTH_LEVEL" => "3",
				"CACHE_TYPE" => "N",
			), false, Array('HIDE_ICONS' => 'Y'));
		}
	}

}
/*$svg='<svg class="category-menu__item-icon" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="108.487mm" height="135.467mm" version="1.1" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"
viewBox="0 0 7807 9749"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <g id="Слой_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <g id="_2209833255376">
   <path fill="#E31E24" d="M4866 6455c-83,0 -165,75 -165,327 0,251 82,326 165,326 82,0 165,-75 165,-326 0,-252 -83,-327 -165,-327z"/>
   <path fill="#E31E24" d="M2942 5218c-83,0 -165,75 -165,326 0,251 82,326 165,326 82,0 165,-75 165,-326 0,-251 -83,-326 -165,-326z"/>
   <path fill="#E31E24" d="M6758 3459c-826,-913 -1317,-1717 -1584,-2230 -289,-557 -383,-901 -384,-904l-86 -325 -307 137c-36,16 -884,403 -1359,1353 -238,477 -286,1008 -284,1370 1,210 -148,393 -354,434 -145,29 -294,-16 -399,-121l-571 -571 -197 271c-21,28 -501,691 -589,823 -427,647 -650,1400 -644,2179 8,1040 417,2014 1152,2743 734,729 1712,1131 2752,1131 2152,0 3903,-1751 3903,-3904 0,-780 -382,-1650 -1049,-2386zm-1892 4054c-398,0 -698,-263 -698,-731 0,-465 300,-732 698,-732 397,0 697,267 697,732 0,468 -300,731 -697,731zm-383 -2663l634 0 -1793 2625 -633 0 1792 -2625zm-2239 694c0,-465 300,-731 698,-731 397,0 697,266 697,731 0,469 -300,731 -697,731 -398,0 -698,-262 -698,-731z"/>
  </g>
 </g>
</svg>';
$aNewMenuLinksExt[0] = Array(
	"Черная пятница", 
	"/sales/", 
	Array(), 
	Array("SVG"=>$svg), 
);*/
foreach($aMenuLinksExt as $new){
	if($new['SECTION_PAGE_URL']=='/sales/') continue;
	$aNewMenuLinksExt[]=$new;
}
$aMenuLinks = array_merge($aMenuLinks, $aNewMenuLinksExt);
?>