<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(is_array($arResult["ITEMS"]))
{
	foreach($arResult["ITEMS"] as &$item)
	{
		if(!is_array($item['PREVIEW_PICTURE'])) continue;

		$arFileTmp = CFile::ResizeImageGet(
			$item['PREVIEW_PICTURE'],
			array("width" => 180, "height" => 140),
			BX_RESIZE_IMAGE_EXACT,
			true
		);

		$item["PREVIEW_PICTURE"] = array(
			"SRC" => $arFileTmp["src"],
			'WIDTH' => $arFileTmp["width"],
			'HEIGHT' => $arFileTmp["height"],
		);
	}
}