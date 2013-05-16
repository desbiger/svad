<?
define("STOP_STATISTICS", true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
	'hm:models.ajax',
	'', 
	array(
		"AJAX_CALL" => "Y", 
	),
	null,
	array('HIDE_ICONS' => 'Y'));

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
?>