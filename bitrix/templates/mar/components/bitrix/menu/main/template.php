<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="top-menu-container">
	<ul>
		<?foreach($arResult as $arItem):?>
		<?if ($arItem["PERMISSION"] > "D"):?>
			<li <?if ($arItem["SELECTED"]):?> class="selected"<?endif?>><span><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></span></li>
			<li><i>&nbsp;</i></li>
			<?endif?>
		<?endforeach?>
	</ul>
	<a class="we-social-networks" href="#"><?=GetMessage("MENU_MAIN_IN_SOC")?></a>
</div>