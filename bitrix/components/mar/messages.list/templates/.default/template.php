<!--<pre>-->
<!--    --><? //print_r($arResult)?>
<!--</pre>-->
<div class="left-menu-container">

    <div class="content-header">
        Мои сообщения:
    </div>
    <div class="end"></div>

    <div class="left-menu">
        <ul>
            <? foreach ($arResult['STATUS'] as $status): ?>
                <li><a <?=isset($status['SELECT']) ? 'class="active"' : ''?>
                        href="/messages/<?= $status['CODE'] ?>/"><span><?=$status['NAME']?></span>
                        <i><?=$status['COUNT']?></i></a></li>
            <? endforeach; ?>
        </ul>
    </div>
</div>

<div class="content-right-2">

    <div class="content-header">
        <? foreach ($arResult['STATUS'] as $status): ?>
            <?= isset($status['SELECT']) ? $status['NAME'] : '' ?>
        <? endforeach; ?>
    </div>
    <div class="end"></div>

    <? foreach ($arResult['items'] as $arElement): ?>
        <div class="spisok">
            <div class="pic_albums">
                <?if ($arElement['USER']['PERSONAL_PHOTO']): ?>
                    <img src="<?= $arElement['USER']['PERSONAL_PHOTO'] ?>"/>
                <? else: ?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="80px" height="80px"/>
                <?endif;?>
            </div>
            <script type="text/javascript">
                function open_wind() {
                    window.open("/message/user/<?=$arElement['USER']['ID'] ?>/action/send/", "", 'location=yes,status=no,scrollbars=yes,resizable=yes,width=500,height=140,top=' + Math.floor((screen.height - 200) / 2 - 14) + ',left=' + Math.floor((screen.width - 500) / 2 - 5));
                }
            </script>
            <div class="text">
                <?if ($arParams['PERMISSION'] >= 'W'): ?>
                    <a class="name right" href="?delete=<?= $arElement['ID'] ?>">удалить</a>

                    <a onclick="open_wind()" class="name right" id="new_open"
                       style="position: relative; top: 50px; left: 64px;"
                       href="javascript: return false;">ответить</a>
                <? endif;?>
                <a href="/profile/<?= $arElement['USER']['ID'] ?>/"
                   class="name<?= $arElement['USER']['IS_ONLINE'] == 'Y' ? ' online' : '' ?>"><?= ($arElement['USER']['NAME'] ? $arElement['USER']['NAME'] . ($arElement['USER']['LAST_NAME'] ? ' ' . $arElement['USER']['LAST_NAME'] : '') : $arElement['USER']['LOGIN']) ?></a>
                <span><?=$arElement['USER']['STATUS']['NAME']?><?=$arElement['USER']['STATUS']['NAME'] ? ', ' : ''?><?=$arElement['USER']['UF_CITY']['NAME']?></span>

                <p><?=nl2br($arElement['PREVIEW_TEXT'])?></p>
            </div>
        </div>
    <? endforeach; ?>

    <?=$arResult['navigation'];?>

</div>