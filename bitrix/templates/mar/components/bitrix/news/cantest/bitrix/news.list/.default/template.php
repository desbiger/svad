<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="left-menu-container">
    <div class="content-header">
        <?=GetMessage("CT_POST_ARTICLE")?>:
    </div>
    <div class="end"></div>
	<? if(!$_GET['show']) $_GET['show'] = 'new'; ?>
	<div class="left-menu">
		<ul>
			<li><a<?=$_GET['show']=='new'?' class="active"':''?> href="/contest/?show=new"><span>Новые</span></a></li>
			<li><a<?=$_GET['show']=='old'?' class="active"':''?> href="/contest/?show=old"><span>Завершённые</span></a></li>
		</ul>
	</div>
</div>
<div class="content-right-2">
    <div class="content-container">
        <div class="content-header">
					<?=$_GET['show']=='new'?'Новые':''?>
					<?=$_GET['show']=='old'?'Завершённые':''?>
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
        </div>
        <div class="end"></div>
			<?endforeach;?>

			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
			<?endif;?>
    </div>
</div>







