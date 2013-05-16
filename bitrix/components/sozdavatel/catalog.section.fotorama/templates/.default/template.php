<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?=count($arResult["ITEMS"])?>

<div id="szd-fotorama-<?= $arParams["FOTORAMA_ID"] ?>">

    <?foreach ($arResult["ITEMS"] as $cell => $arElement): ?>
        <?
        $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
        ?>


        <? if ($arElement["DETAIL_PICTURE"]): ?>
            <img border="0" src="<?= $arElement["DETAIL_PICTURE"]["SRC"] ?>"
                 width="<?= $arElement["DETAIL_PICTURE"]["WIDTH"] ?>"
                 height="<?= $arElement["DETAIL_PICTURE"]["HEIGHT"] ?>" alt="<?= $arElement["NAME"] ?>"
                 title="<?= $arElement["NAME"] ?>"/>
        <? elseif ($arElement["PREVIEW_PICTURE"]): ?>
            <img border="0" src="<?= $arElement["PREVIEW_PICTURE"]["SRC"] ?>"
                 width="<?= $arElement["PREVIEW_PICTURE"]["WIDTH"] ?>"
                 height="<?= $arElement["PREVIEW_PICTURE"]["HEIGHT"] ?>" alt="<?= $arElement["NAME"] ?>"
                 title="<?= $arElement["NAME"] ?>"/>
        <?endif ?>

    <? endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</div>

<script type="text/javascript">
    $(function () {
        $('#szd-fotorama-<?=$arParams["FOTORAMA_ID"]?>').fotorama(
            {
                <?if ($arParams["CONTAINER_WIDTH"]):
                ?>width: <?=$arParams["CONTAINER_WIDTH"]?>, <?
			elseif(($arParams["CONTAINER_HEIGHT"])):
			?>width: <?=$arResult["PROP_WIDTH"]?>, <?
			endif;?>
                <?if ($arParams["CONTAINER_HEIGHT"]):
                ?>height: <?=$arParams["CONTAINER_HEIGHT"]?>, <?
			elseif(($arParams["CONTAINER_WIDTH"])):
			?>height: <?=$arResult["PROP_HEIGHT"]?>, <?
			endif;?>
                <?if ($arParams["TRANSITION_DURATION"]):
                ?>transitionDuration: <?=$arParams["TRANSITION_DURATION"]?>, <?
			endif;?>
                <?if ($arParams["TOUCH_STYLE"]=="N"):
                ?>touchStyle: false, <?
			endif;?>
                <?if ($arParams["BACKGROUND_COLOR"]):
                ?>backgroundColor: '<?=$arParams["BACKGROUND_COLOR"]?>', <?
			endif;?>
                <?if ($arParams["MARGIN"]):
                ?>margin: <?=$arParams["MARGIN"]?>, <?
			endif;?>
                <?if ($arParams["MIN_PADDING"]):
                ?>minPadding: <?=$arParams["MIN_PADDING"]?>, <?
			endif;?>
                <?if ($arParams["PRELOAD"]):
                ?>preload: <?=$arParams["PRELOAD"]?>, <?
			endif;?>
                <?if ($arParams["ZOOM_TO_FIT"]=="N"):
                ?>zoomToFit: false, <?
			endif;?>
                <?if ($arParams["ARROWS"]=="N"):
                ?>arrows: false, <?
			endif;?>
                <?if ($arParams["ARROWS_COLOR"]):
                ?>arrowsColor: '<?=$arParams["ARROWS_COLOR"]?>', <?
			endif;?>
                <?if ($arParams["THUMBS_STYLE"]=="none"):
                ?>thumbs: false, <?
			endif;?>
                <?if ($arParams["THUMBS_BACKGROUND_COLOR"]):
                ?>thumbsBackgroundColor: '<?=$arParams["THUMBS_BACKGROUND_COLOR"]?>', <?
			endif;?>
                <?if ($arParams["THUMB_COLOR"]):
                ?>thumbColor: '<?=$arParams["THUMB_COLOR"]?>', <?
			endif;?>
                <?if ($arParams["THUMBS_STYLE"]=="dots"):
                ?>thumbsPreview: false, <?
			endif;?>
                <?if ($arParams["THUMB_SIZE"]):
                ?>thumbSize: <?=$arParams["THUMB_SIZE"]?>, <?
			endif;?>
                <?if ($arParams["THUMB_MARGIN"]):
                ?>thumbMargin: <?=$arParams["THUMB_MARGIN"]?>, <?
			endif;?>
                <?if ($arParams["THUMB_BORDER_WIDTH"]):
                ?>thumbBorderWidth: <?=$arParams["THUMB_BORDER_WIDTH"]?>, <?
			endif;?>
                <?if ($arParams["THUMB_BORDER_COLOR"]):
                ?>thumbBorderColor: '<?=$arParams["THUMB_BORDER_COLOR"]?>', <?
			endif;?>
                <?if ($arParams["CAPTION"]=="Y"):
                ?>caption: true <?
			endif;?>
            }
        );
    });
</script>