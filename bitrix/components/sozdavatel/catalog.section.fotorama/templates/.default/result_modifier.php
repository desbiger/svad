<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$key = rand(0,count($arResult["ITEMS"]));
if ($arResult["ITEMS"][$key]) {
    if (is_array($arResult["ITEMS"][$key]["DETAIL_PICTURE"])):
        $width = $arResult["ITEMS"][$key]["DETAIL_PICTURE"]["WIDTH"];
        $height = $arResult["ITEMS"][$key]["DETAIL_PICTURE"]["HEIGHT"]; elseif (is_array($arResult["ITEMS"][$key]["PREVIEW_PICTURE"])):
        $width = $arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["WIDTH"];
        $height = $arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["HEIGHT"]; else:
        $width = 1;
        $height = 1;
    endif;
    $proportion = $width / $height;
    $arResult["PROP_WIDTH"] = $arParams["CONTAINER_HEIGHT"] * $proportion;
    $arResult["PROP_HEIGHT"] = $arParams["CONTAINER_WIDTH"] / $proportion;
}
?>
		
