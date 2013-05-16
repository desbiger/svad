<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (is_array($arResult["PREVIEW_PICTURE"])) {
	$arFileTmp = CFile::ResizeImageGet(
		$arResult['PREVIEW_PICTURE'],
		array("width" => 180, "height" => 140),
		BX_RESIZE_IMAGE_EXACT,
		true
	);

	$arResult["PREVIEW_PICTURE"] = array(
		"SRC" => $arFileTmp["src"],
		'WIDTH' => $arFileTmp["width"],
		'HEIGHT' => $arFileTmp["height"],
	);
}