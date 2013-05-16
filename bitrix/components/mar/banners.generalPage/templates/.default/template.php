<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<div class="baner_town">
    <?if ($arResult['townLink'] === ''):?>
        <img src="<?=$arResult['town']['PREVIEW_PICTURE']?>" class="baner_img">
    <?endif;?>
    <?if ($arResult['townLink'] != ''):?>
    <a href="/profile/<?=$arResult['townLink']?>/">
        <img src="<?=$arResult['town']['PREVIEW_PICTURE']?>" class="baner_img">
    </a>
    <?endif;?>
</div>
