<?
IncludeModuleLangFile(__FILE__);

if (class_exists("monday_propsite")) return;

Class monday_propsite extends CModule
{
	var $MODULE_ID = "monday.propsite";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	
	function monday_propsite()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("MONDAY_PROP_SITE_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("MONDAY_PROP_SITE_MODULE_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("MONDAY_PROP_SITE_PARTNER_NAME");;
		$this->PARTNER_URI = "http://monday-studio.com";
	}
	
	function DoInstall()
	{
		RegisterModule($this->MODULE_ID);
		
		RegisterModuleDependences("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "CMondayPropSiteIblockProperty", "GetUserTypeDescription");
		RegisterModuleDependences("main", "OnUserTypeBuildList", $this->MODULE_ID, "CMondayPropSiteUserType", "GetUserTypeDescription");
		
		return true;
	}
	
	function DoUninstall()
	{
		UnRegisterModuleDependences("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "CMondayPropSiteIblockProperty", "GetUserTypeDescription");
		UnRegisterModuleDependences("main", "OnUserTypeBuildList", $this->MODULE_ID, "CMondayPropSiteUserType", "GetUserTypeDescription");
		
		UnRegisterModule($this->MODULE_ID);
		
		return true;
	}
}

?>