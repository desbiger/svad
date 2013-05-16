<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="left-menu">
    <ul>
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
    <li><a class="active" href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span> <i></i></a></li>
	<?else:?>
    <li><a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span> <i></i></a></li>
	<?endif?>
<?endforeach?>
    </ul>
</div>
<?endif?>