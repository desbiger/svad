<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
if (empty($arResult["TOPIC"]))
	return 0;

// ************************* Input params***************************************************************
$arParams["SHOW_NAV"] = (is_array($arParams["SHOW_NAV"]) ? $arParams["SHOW_NAV"] : array());
$arParams["SHOW_COLUMNS"] = (is_array($arParams["SHOW_COLUMNS"]) ? $arParams["SHOW_COLUMNS"] : array());
$arParams["SHOW_SORTING"] = ($arParams["SHOW_SORTING"] == "Y" ? "Y" : "N");
$arParams["SEPARATE"] = (empty($arParams["SEPARATE"]) ? GetMessage("FTP_IN_FORUM") : $arParams["SEPARATE"]);
// *************************/Input params***************************************************************

?>

<div class="content-header">
	Последнее на форуме:
</div>
<div class="end"></div>
<?
foreach ($arResult["TOPIC"] as $res)
{
	?>
	<a class="forum-box" href="<?=$res["read"]?>">
		<img src="/bitrix/templates/mar/components/bitrix/forum/mar/themes/red/images/default.gif" />
		<i><?=$arResult["FORUM"][$res["FORUM_ID"]]["NAME"]?></i>
		<span><?=$res["LAST_POST_DATE"]?></span>
		<b>&nbsp;</b>
	</a>
<?
}
?>

