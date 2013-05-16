<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");
?><?$APPLICATION->IncludeComponent(
	"mar:newlyweds_page",
	"",
	Array(
		"TOWN_ID" => ""
	),
false
);?> <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>