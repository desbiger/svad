<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="left-menu-container">
    <div class="content-header">
			<?=GetMessage("CT_POST_ARTICLE")?>:
    </div>
    <div class="end"></div>
	<?$APPLICATION->IncludeComponent(
	"mar:section.list.count",
	"",
	Array(
		"IBLOCK_TYPE" => "article",
		"IBLOCK_ID" => "7",
		"ITEMS_LIMIT" => "10000",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000",
		"SECTION_ID" => ($arResult["SECTION"]?$arResult["SECTION"]['PATH']['0']['ID']:0)
	),
	$component
);?>
</div>

<div class="content-right-2">
	<div class="content-container">
		<? if($arResult["SECTION"]): ?>
		<div class="kroski-box">
			<a href="<?=$arResult["SECTION"]['PATH']['0']['SECTION_PAGE_URL']?>/"><?=GetMessage('CT_ARTICLE_BACK')?><?=$arResult["SECTION"]['PATH']['0']['NAME']?>"</a>
			<div class="end"></div>
		</div>
		<? endif; ?>

		<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<div class="content-header-2"><?=$arResult["NAME"]?></div>
		<?endif;?>

		<div class="content-box">
			<?if (is_array($arResult["PREVIEW_PICTURE"])): ?>
			<img style="float: left; padding: 0 10px 10px 0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>">
			<?endif?>
			<?=$arResult["DETAIL_TEXT"]?>
			<div class="end"></div>
		</div>
		<div class="content-header-2">Дата добавления: <?=CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["DATE_CREATE"], CSite::GetDateFormat()));?></div>
		<div class="content-header-2">
			<? $RATING = like::get($arResult['ID'], 'ELM0'); $RATING['is_self'] = $arResult['CREATED_BY'];?>
			<? $GLOBALS["APPLICATION"]->IncludeComponent("mar:likes", 'content', $RATING, null,array("HIDE_ICONS" => "Y"));	?>
		</div>
		<div class="content-header-2">

			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/shared.php",
			"EDIT_TEMPLATE" => ""
		),false);?>

			<div class="end"></div>
		</div>


<!--		<pre>-->
<?//print_r($arResult)?>
<!--        </pre>-->

<?$APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", "", array(
	"FORUM_ID" => "5",
	"IBLOCK_TYPE" => "article",
	"IBLOCK_ID" => "7",
	"ELEMENT_ID" => $arResult['ID'],
	"POST_FIRST_MESSAGE" => "Y",
	"URL_TEMPLATES_PROFILE_VIEW" => "/profile/#USER_ID#/",
	"NO_REDIRECT_AFTER_SUBMIT" => "Y",
	"POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
[url=#LINK#]#TITLE#[/url]
#BODY#",
	"URL_TEMPLATES_READ" => "",
	"URL_TEMPLATES_DETAIL" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000",
	"MESSAGES_PER_PAGE" => "10000",
	"PAGE_NAVIGATION_TEMPLATE" => "",
	"DATE_TIME_FORMAT" => "j F Y G:i",
	"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
	"EDITOR_CODE_DEFAULT" => "N",
	"SHOW_AVATAR" => "Y",
	"SHOW_RATING" => "N",
	"RATING_TYPE" => "",
	"SHOW_MINIMIZED" => "N",
	"USE_CAPTCHA" => "N",
	"PREORDER" => "Y",
	"SHOW_LINK_TO_FORUM" => "N",
	"FILES_COUNT" => "0",
	"AJAX_POST" => "Y",
		"AUTOSAVE" => false,
	),
	$component,
	array(
	"HIDE_ICONS" => "N"
	)
);?>

    </div>
</div>