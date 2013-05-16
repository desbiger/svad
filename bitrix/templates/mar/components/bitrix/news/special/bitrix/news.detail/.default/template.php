<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$arUser = $USER->GetByID($arResult["CREATED_BY"])->Fetch();
if($arFile = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width'=>26, 'height'=>26), BX_RESIZE_IMAGE_EXACT, true))
{
	$arUser['PERSONAL_PHOTO'] = $arFile['src'];
}
?>

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
	<div class="content-container">
		<div class="kroski-box">
			<a href="/special/">Назад в раздел: "Спецпредложения"</a>
			<div class="end"></div>
		</div>

		<div class="content-header-2">
			<? if($arUser['PERSONAL_PHOTO']): ?><img class="detal-special-img" src="<?=$arUser['PERSONAL_PHOTO']?>"/>
			<?else:?><img class="detal-special-img" src="<?=SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="26px" height="26px"/><? endif; ?>
			<a class="detal-special-user" href="/profile/<?=$arUser['ID']?>/"><?= ($arUser['NAME'] ? $arUser['NAME'] . ($arUser['LAST_NAME'] ? ' ' . $arUser['LAST_NAME'] : '')  : $arUser['LOGIN'] ) ?></a>
			<div class="end"></div>
		</div>
		<div class="content-header-2">Скидка: <?=$arResult["PROPERTIES"]['DI_DISCOUNT']['VALUE']?>%</div>

		<div class="content-box">
			<?if (is_array($arResult["PREVIEW_PICTURE"])): ?>
			<a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><img style="float: left; padding: 0 10px 10px 0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>"></a>
			<?endif?>
			<?=$arResult["DETAIL_TEXT"]?>
			<div class="end"></div>
		</div>
		<div class="content-header-2">Период действия скидки: <?=$arResult["DATE_ACTIVE_FROM"]?> - <?=$arResult["DATE_ACTIVE_TO"]?></div>
		<div class="content-header-2">

			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/shared.php",
			"EDIT_TEMPLATE" => ""
		),false);?>

			<div class="end"></div>
		</div>
	</div>
</div>