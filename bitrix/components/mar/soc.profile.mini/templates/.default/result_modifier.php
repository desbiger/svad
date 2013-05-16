<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if($arFile = CFile::ResizeImageGet($arResult['user']['PERSONAL_PHOTO'], array('width'=>26, 'height'=>26), BX_RESIZE_IMAGE_EXACT, true))
{
	$arResult['user']['PERSONAL_PHOTO'] = $arFile['src'];
}
?>
