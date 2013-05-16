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
	false
);?>
</div>
<div class="content-right-2">
    <div class="content-container">
        <div class="content-header">
            <?=$arResult["SECTION"]?$arResult["SECTION"]['PATH']['0']['NAME']:GetMessage('CT_POST_ALL')?>
        </div>
        <div class="content-select content-select-konkurs">
            <a class="item<?=$_GET['sort']?'':' active'?>" href="/article/"><?=GetMessage("CT_POST_NEW")?></a>
            <a class="item<?=$_GET['sort']?' active':''?>" href="/article/?sort=top"><?=GetMessage("CT_POST_TOP")?></a>
        </div>
        <div class="end"></div>

			<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
      	<div class="previev-box" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if($arItem["PREVIEW_PICTURE"]): ?>
         <img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"/>
				<?endif;?>
        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
				<? echo $arItem["PREVIEW_TEXT"]; ?>
            <div class="previev-like">
								<?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
                <span class="previev-like-like"><?=intval($arItem['PROPERTIES']['rating']['VALUE'])?></span>
                <span class="previev-like-otsiv"><?=intval($arItem['DISPLAY_PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'])?></span>
                <span class="previev-like-look"><?=intval($arItem['SHOW_COUNTER'])?></span>
            </div>
        </div>
        <div class="end"></div>
			<?endforeach;?>

			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
			<?endif;?>
    </div>
</div>







