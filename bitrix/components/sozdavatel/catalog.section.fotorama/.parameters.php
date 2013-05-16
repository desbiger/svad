<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arProperty_LNS = array();
$arProperty_N = array();
$arProperty_X = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	if($arr["PROPERTY_TYPE"] != "F")
		$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

	if($arr["PROPERTY_TYPE"]=="N")
		$arProperty_N[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

	if($arr["PROPERTY_TYPE"]!="F")
	{
		if($arr["MULTIPLE"] == "Y")
			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		elseif($arr["PROPERTY_TYPE"] == "L")
			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		elseif($arr["PROPERTY_TYPE"] == "E" && $arr["LINK_IBLOCK_ID"] > 0)
			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arProperty_UF = array();
$arSProperty_LNS = array();
$arUserFields = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("IBLOCK_".$arCurrentValues["IBLOCK_ID"]."_SECTION");
foreach($arUserFields as $FIELD_NAME=>$arUserField)
{
	$arProperty_UF[$FIELD_NAME] = $arUserField["LIST_COLUMN_LABEL"]? $arUserField["LIST_COLUMN_LABEL"]: $FIELD_NAME;
	if($arUserField["USER_TYPE"]["BASE_TYPE"]=="string")
		$arSProperty_LNS[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
}

$arOffers = CIBlockPriceTools::GetOffersIBlock($arCurrentValues["IBLOCK_ID"]);
$OFFERS_IBLOCK_ID = is_array($arOffers)? $arOffers["OFFERS_IBLOCK_ID"]: 0;
$arProperty_Offers = array();
if($OFFERS_IBLOCK_ID)
{
	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$OFFERS_IBLOCK_ID));
	while($arr=$rsProp->Fetch())
	{
		if($arr["PROPERTY_TYPE"] != "F")
			$arProperty_Offers[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arPrice = array();
if(CModule::IncludeModule("catalog"))
{
	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
	while($arr=$rsPrice->Fetch()) $arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
}
else
{
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
);

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		//"AJAX_MODE" => array(),
		"JQUERY_INC" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("JQUERY_INC"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"SECTION_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_SECTION_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '={$_REQUEST["SECTION_ID"]}',
		),
		"SECTION_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_SECTION_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"ELEMENT_SORT_FIELD" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"shows" => GetMessage("IBLOCK_SORT_SHOWS"),
				"sort" => GetMessage("IBLOCK_SORT_SORT"),
				"timestamp_x" => GetMessage("IBLOCK_SORT_TIMESTAMP"),
				"name" => GetMessage("IBLOCK_SORT_NAME"),
				"id" => GetMessage("IBLOCK_SORT_ID"),
				"active_from" => GetMessage("IBLOCK_SORT_ACTIVE_FROM"),
				"active_to" => GetMessage("IBLOCK_SORT_ACTIVE_TO"),
			),
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "sort",
		),
		"ELEMENT_SORT_ORDER" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "asc",
		),
		"FILTER_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_FILTER_NAME_IN"),
			"TYPE" => "STRING",
			"DEFAULT" => "arrFilter",
		),
		"INCLUDE_SUBSECTIONS" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("CP_BCS_INCLUDE_SUBSECTIONS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SHOW_ALL_WO_SECTION" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("CP_BCS_SHOW_ALL_WO_SECTION"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BCS_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		
		
		"CONTAINER_WIDTH" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_CONTAINER_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"CONTAINER_HEIGHT" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_CONTAINER_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"TRANSITION_DURATION" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_TRANSITION_DURATION"),
			"TYPE" => "STRING",
			"DEFAULT" => "333",
		),
		"TOUCH_STYLE" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_TOUCH_STYLE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"BACKGROUND_COLOR" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_BACKGROUND_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"MARGIN" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_MARGIN"),
			"TYPE" => "STRING",
			"DEFAULT" => "0",
		),
		"MIN_PADDING" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_MIN_PADDING"),
			"TYPE" => "STRING",
			"DEFAULT" => "10",
		),
		"PRELOAD" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_PRELOAD"),
			"TYPE" => "STRING",
			"DEFAULT" => "3",
		),
		"ZOOM_TO_FIT" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_ZOOM_TO_FIT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"ARROWS" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_ARROWS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"ARROWS_COLOR" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_ARROWS_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"THUMBS_STYLE" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMBS_STYLE"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"preview" => GetMessage("IBLOCK_THUMBS_PREVIEW"),
				"dots" => GetMessage("IBLOCK_THUMBS_DOTS"),
				"none" => GetMessage("IBLOCK_THUMBS_NONE"),
			),
			"ADDITIONAL_VALUES" => "N",
			"DEFAULT" => "preview",
		),
		"THUMBS_BACKGROUND_COLOR" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMBS_BACKGROUND_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"THUMB_COLOR" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMB_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"THUMB_SIZE" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMBS_SIZE"),
			"TYPE" => "STRING",
			"DEFAULT" => "48",
		),
		"THUMB_MARGIN" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMBS_MARGIN"),
			"TYPE" => "STRING",
			"DEFAULT" => "0",
		),
		"THUMB_BORDER_WIDTH" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMB_BORDER_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "3",
		),
		"THUMB_BORDER_COLOR" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_THUMB_BORDER_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"CAPTION" => Array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("T_IBLOCK_DESC_CAPTION"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"FOTORAMA_ID" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_FOTORAMA_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "1",
		),
	),
);

if(!$OFFERS_IBLOCK_ID)
{
	unset($arComponentParameters["PARAMETERS"]["OFFERS_FIELD_CODE"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_PROPERTY_CODE"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER"]);
}
else
{
	unset($arComponentParameters["PARAMETERS"]["PRODUCT_PROPERTIES"]);
	$arComponentParameters["PARAMETERS"]["OFFERS_CART_PROPERTIES"] = array(
		"PARENT" => "PRICES",
		"NAME" => GetMessage("CP_BCS_OFFERS_CART_PROPERTIES"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_Offers,
	);
}
?>