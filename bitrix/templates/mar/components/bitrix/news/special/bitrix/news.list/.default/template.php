<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="left-menu-container">

	<div class="content-header">
		Спецпредложения:
	</div>
	<div class="end"></div>
	<? if(!$_GET['show']) $_GET['show'] = 'new'; ?>
	<div class="left-menu">
		<ul>
			<li><a<?=$_GET['show']=='new'?' class="active"':''?> href="/special/?show=new"><span>Новое</span></a></li>
			<li><a<?=$_GET['show']=='top'?' class="active"':''?> href="/special/?show=top"><span>Популярное</span></a></li>
			<li><a<?=$_GET['show']=='discount'?' class="active"':''?> href="/special/?show=discount"><span>Скидки</span></a></li>
		</ul>
	</div>

</div>

<div class="content-right-2">

	<div class="content-header">
		<?=$_GET['show']=='new'?'Новое':''?>
		<?=$_GET['show']=='top'?'Популярное':''?>
		<?=$_GET['show']=='discount'?'Скидки':''?>
	</div>
	<div class="end"></div>

	<div class="row-special">
		<?$count=0?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="span1">
			<div class="persent">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["PROPERTIES"]["DI_DISCOUNT"]["VALUE"]?>%</a>
			</div>
			<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"></a>
			<?else:?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=SITE_TEMPLATE_PATH ?>/images/cover_empty_hd.jpg"></a>
			<?endif?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link"><?=TruncateText(strip_tags($arItem["NAME"]),100)?></a>
			<p><?=TruncateText(strip_tags($arItem["DETAIL_TEXT"]),100)?></p>
		</div>
		<?
		$count++;
		if($count == 3) {
			echo '<div class="end"></div>';
			$count = 0;
		}
		?>
		<?endforeach;?>
		<div class="end"></div>
	</div>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
