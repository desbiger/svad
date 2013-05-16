<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Спецпредложения для лучшей свадьбы на Клуб-новобрачных.рф");
$APPLICATION->SetTitle("Спецпредложения для лучшей свадьбы на Клуб-новобрачных.рф");

$sortVaribal = array(
	'new' => 'ACTIVE_FROM',
	'top' => 'SHOW_COUNTER',
	'discount' => 'PROPERTY_DI_DISCOUNT'
);
$sort = $_GET['show'];
$sort = isset($sortVaribal[$sort])?$sortVaribal[$sort]:$sortVaribal['new'];

?><?$APPLICATION->IncludeComponent("bitrix:news", "special", array(
	"IBLOCK_TYPE" => "deals",
	"IBLOCK_ID" => "11",
	"NEWS_COUNT" => "15",
	"USE_SEARCH" => "N",
	"USE_RSS" => "N",
	"USE_RATING" => "N",
	"USE_CATEGORIES" => "N",
	"USE_REVIEW" => "N",
	"USE_FILTER" => "N",
	"SORT_BY1" => $sort,
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "",
	"SORT_ORDER2" => "ASC",
	"CHECK_DATES" => "Y",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/special/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"SET_TITLE" => "Y",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
	"ADD_SECTIONS_CHAIN" => "Y",
	"USE_PERMISSIONS" => "N",
	"PREVIEW_TRUNCATE_LEN" => "",
	"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
	"LIST_FIELD_CODE" => array(
		0 => "PREVIEW_PICTURE",
		1 => "DETAIL_TEXT",
		2 => "DATE_ACTIVE_FROM",
		3 => "DATE_ACTIVE_TO",
		4 => "SHOW_COUNTER",
		5 => "",
	),
	"LIST_PROPERTY_CODE" => array(
		0 => "DI_DISCOUNT",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"DISPLAY_NAME" => "Y",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "NAME",
	"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
	"DETAIL_FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_PICTURE",
		2 => "DETAIL_TEXT",
		3 => "DATE_ACTIVE_FROM",
		4 => "DATE_ACTIVE_TO",
		5 => "SHOW_COUNTER",
		6 => "CREATED_BY",
	),
	"DETAIL_PROPERTY_CODE" => array(
		0 => "DI_DISCOUNT",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
	"DETAIL_PAGER_TITLE" => "Страница",
	"DETAIL_PAGER_TEMPLATE" => "",
	"DETAIL_PAGER_SHOW_ALL" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "mar",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"DISPLAY_DATE" => "N",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"USE_SHARE" => "N",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"news" => "",
		"section" => "",
		"detail" => "#ELEMENT_ID#/",
	)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>