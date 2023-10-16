<?
IncludeModuleLangFile(__FILE__);

class CMondayPropSiteUserType
{
	 static function GetUserTypeDescription()
	{
		return array(
			"USER_TYPE_ID"	=> "site",
			"CLASS_NAME"	=> "CMondayPropSiteUserType",
			"DESCRIPTION"	=> GetMessage("MONDAY_PROP_SITE_DESCRIPTION"),
			"BASE_TYPE"		=> "string",
		);
	}
	
	function OnSearchIndex($arUserField)
	{
		if (is_array($arUserField['VALUE']))
		{
			$return = Array();
			$arSite = CSite::GetList($by="sort", $order="desc", Array("ID" => implode("|", $arUserField['VALUE'])));
			while ($site = $arSite->Fetch())
			{
				$return[] = $site['NAME'];
			}
			return implode("\r\n", $return);
		}
		else
		{
			$arSite = CSite::GetByID($arUserField['VALUE']);
			if ($site = $arSite->Fetch())
			{
				return $site['NAME'];
			}
			else return '';
		}
	}
	
	function GetFilterHTML($arUserField, $arHtmlControl)
	{
		global $lAdmin;
		$lAdmin->InitFilter(Array($arHtmlControl["NAME"]));
		
		$values = is_array($arHtmlControl["VALUE"]) ? $arHtmlControl["VALUE"] : Array($arHtmlControl["VALUE"]);
		
		if ($arUserField["MULTIPLE"] === 'Y') $multiple = ' multiple size="5"';
		else $multiple = '';

		$html = "<select name='".$arHtmlControl['NAME'].($arUserField["MULTIPLE"] === "Y"?"[]":"")."' ".$multiple."><option value=''>".GetMessage("MONDAY_PROP_SITE_NO")."</option>";
		
		$arSite = CSite::GetList($by="sort", $order="desc", Array());
		while ($site = $arSite->Fetch())
		{
			$html .= "<option ".(in_array($site['ID'], $values)?'selected':'')." value='".$site['ID']."'>[".$site['ID']."] ".$site['NAME']."</option>";
		}
		
		$html .= "</select>";
		
		return  $html;
	}
	
	function GetAdminListViewHTML($arUserField, $arHtmlControl)
	{
		if ($arHtmlControl['VALUE'])
		{
			$arSite = CSite::GetByID($arHtmlControl['VALUE']);
			if ($site = $arSite->Fetch())
			{
				return $site['NAME'];
			}
			else return '&nbsp;';
		}
		else return '&nbsp;';
	}
	
	function GetEditFormHTML($arUserField, $arHtmlControl)
	{
		$return = "<select name='".$arHtmlControl['NAME']."' ".($arUserField['EDIT_IN_LIST']==='N'?"disabled='disabled'":"")."><option value=''>".GetMessage("MONDAY_PROP_SITE_NO")."</option>";
		
		$arSite = CSite::GetList($by="sort", $order="desc", Array());
		while ($site = $arSite->Fetch())
		{
			$return .= "<option ".($site['ID'] == $arHtmlControl["VALUE"]?'selected':'')." value='".$site['ID']."'>[".$site['ID']."] ".$site['NAME']."</option>";
		}
		
		$return .= "</select>";
		
		return $return;
	}
	
	function GetDBColumnType($arUserField)
	{
		global $DB;
		switch(strtolower($DB->type))
		{
			case "mysql":
                return "text";
            case "oracle":
                return "varchar2(2000 char)";
            case "mssql":
                return "varchar(2000)";
		}
	}
}
class CMondayPropSiteIblockProperty
{
    static function GetUserTypeDescription()
	{
		return Array(
			"PROPERTY_TYPE"			=> "S",
			"USER_TYPE"				=> "SiteIblockProperty",
			"DESCRIPTION"			=> GetMessage("MONDAY_PROP_SITE_DESCRIPTION"),
			"GetSettingsHTML"		=> Array("CMondayPropSiteIblockProperty", "GetSettingsHTML"),
			"GetPropertyFieldHtml"	=> Array("CMondayPropSiteIblockProperty", "GetPropertyFieldHtml"),
			"GetAdminListViewHTML"	=> Array("CMondayPropSiteIblockProperty", "GetAdminListViewHTML"),
			"GetAdminFilterHTML"	=> Array("CMondayPropSiteIblockProperty", "GetAdminFilterHTML"),
			"GetPublicViewHTML"		=> Array("CMondayPropSiteIblockProperty", "GetPublicViewHTML"),
		);
	}
	
	function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
	{
		$arPropertyFields = Array("HIDE" => array("ROW_COUNT", "COL_COUNT", "DEFAULT_VALUE"));

		return '';
	}
	
	function GetPublicViewHTML($arProperty, $value, $strHTMLControlName)
	{
		if ($value['VALUE'])
		{
			$arSite = CSite::GetByID($value['VALUE']);
			if ($site = $arSite->Fetch())
			{
				return $site['NAME'];
			}
			else return '&nbsp;';
		}
		else return '&nbsp;';
	}
	
	function GetAdminFilterHTML($arProperty, $strHTMLControlName)
	{
		$lAdmin = new CAdminList($strHTMLControlName["TABLE_ID"]);
		$lAdmin->InitFilter(Array($strHTMLControlName["VALUE"]));
		$filterValue = $GLOBALS[$strHTMLControlName["VALUE"]];

		if (isset($filterValue) && is_array($filterValue)) $values = $filterValue;
		else $values = Array();
		
		if ($arProperty["MULTIPLE"] === 'Y') $multiple = ' multiple size="5"';
		else $multiple = '';

		$html = "<select name='".$strHTMLControlName['VALUE']."' ".$multiple."><option value=''>".GetMessage("MONDAY_PROP_SITE_NO")."</option>";
		
		$arSite = CSite::GetList($by="sort", $order="desc", Array());
		while ($site = $arSite->Fetch())
		{
			$html .= "<option ".($site['ID'] == $filterValue["VALUE"]?'selected':'')." value='".$site['ID']."'>[".$site['ID']."] ".$site['NAME']."</option>";
		}
		
		$html .= "</select>";
		
		return  $html;
	}
	
	function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName)
    {
        if ($value['VALUE'])
		{
			$arSite = CSite::GetByID($value['VALUE']);
			if ($site = $arSite->Fetch())
			{
				return $site['NAME'];
			}
			else return '&nbsp;';
		}
		else return '&nbsp;';
    }
	
	function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
	{
		$return = "<select name='".$strHTMLControlName['VALUE']."'><option value=''>".GetMessage("MONDAY_PROP_SITE_NO")."</option>";
		
		$arSite = CSite::GetList($by="sort", $order="desc", Array());
		while ($site = $arSite->Fetch())
		{
			$return .= "<option ".($site['ID'] == $value["VALUE"]?'selected':'')." value='".$site['ID']."'>[".$site['ID']."] ".$site['NAME']."</option>";
		}
		
		$return .= "</select>";
		
		return $return;
	}
}
?>