<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult["ITEMS"][0])
{
		if(is_array($arResult["ITEMS"][0]["DETAIL_PICTURE"])):
			$width = $arResult["ITEMS"][0]["DETAIL_PICTURE"]["WIDTH"];
			$height = $arResult["ITEMS"][0]["DETAIL_PICTURE"]["HEIGHT"];
		elseif (is_array($arResult["ITEMS"][0]["PREVIEW_PICTURE"])):
			$width = $arResult["ITEMS"][0]["PREVIEW_PICTURE"]["WIDTH"];
			$height = $arResult["ITEMS"][0]["PREVIEW_PICTURE"]["HEIGHT"];
		else:
			$width = 1;
			$height = 1;
		endif;
			$proportion = $width/$height;
			$arResult["PROP_WIDTH"] = $arParams["CONTAINER_HEIGHT"]*$proportion;
			$arResult["PROP_HEIGHT"] = $arParams["CONTAINER_WIDTH"]/$proportion;
}
?>

