<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arParams["JQUERY_INC"]=="Y")
{
	$APPLICATION->AddHeadScript('/bitrix/js/jquery/$.js');
}
$APPLICATION->AddHeadScript('/bitrix/components/sozdavatel/catalog.section.fotorama/fotorama/fotorama.js');

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arParams["SECTION_ID"] = intval($arParams["~SECTION_ID"]);

$arParams["INCLUDE_SUBSECTIONS"] = $arParams["INCLUDE_SUBSECTIONS"]!="N"? "Y": "N";

if(strlen($arParams["ELEMENT_SORT_FIELD"])<=0)
	$arParams["ELEMENT_SORT_FIELD"]="sort";

if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["ELEMENT_SORT_ORDER"]))
	 $arParams["ELEMENT_SORT_ORDER"]="asc";

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

$array = unserialize(file_get_contents($_SERVER["DOCUMENT_ROOT"].'/upload/topWeek.txt'));
$sortArray = array_combine($array,range(1, count($array)));

$CACHE_ID = SITE_ID."|fotorama|";

$cache = new CPHPCache;
if ($cache->StartDataCache(3600, $CACHE_ID, "/"))
{
	$arSelect = array(
		"ID",
		"NAME",
		"DATE_CREATE",
		"ACTIVE_FROM",
		"CREATED_BY",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"DETAIL_PAGE_URL",
		"DETAIL_PICTURE",
		"PREVIEW_PICTURE",
		"PROPERTY_REAL_PICTURE"
	);

	$arFilter = array(
		"ID" => $array,
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y"
	);

	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, array('nTopCount' => 10), $arSelect);
	$arResult["ITEMS"] = array();
	while ($obElement = $rsElements->GetNextElement()) {
		$arItem = $obElement->GetFields();

		$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
		$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["PROPERTY_REAL_PICTURE_VALUE"]);

		$arResult["ITEMS"][$sortArray[$arItem["ID"]]] = $arItem;
		$arResult["ELEMENTS"][] = $arItem["ID"];
	}
	ksort($arResult["ITEMS"]);

	$this->IncludeComponentTemplate();
	$templateCachedData = $this->GetTemplateCachedData();

	$cache->EndDataCache(
		array(
			"arResult" => $arResult,
			"templateCachedData" => $templateCachedData
		)
	);
}
else
{
	extract($cache->GetVars());
	$this->SetTemplateCachedData($templateCachedData);
}