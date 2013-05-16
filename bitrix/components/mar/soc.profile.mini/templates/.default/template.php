<div class="top-container">
    <div class="city-box">
        <form method="post">
            Ваш
            город <?=SelectBoxFromArray('HEADER_SELECT_CITY_SET', GetCitys(), GetDefCity(), GetMessage("ISL_COUNTRY_EMPTY"), 'class="select-2" onchange="$(this).closest(\'form\').trigger(\'submit\');"');?>
        </form>
    </div>
    <div class="rowUser">
        <div class="user-name">Привет,
            <? if ($arResult['user']['PERSONAL_PHOTO']): ?><img src="<?= $arResult['user']['PERSONAL_PHOTO'] ?>"/>
            <? else: ?><img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="26px"
                            height="26px"/><? endif; ?>
            <a href="/profile/<?= $arResult['user']['ID'] ?>/">
                <?= ($arResult['user']['NAME'] ? $arResult['user']['NAME'] . ($arResult['user']['LAST_NAME'] ? ' ' . $arResult['user']['LAST_NAME'] : '') : $arResult['user']['LOGIN']) ?></a>
        </div>
        <div class="top-border exit">
            <a href="?logout=yes">Выход</a> &rarr;
        </div>
    </div>
    <div class="top-border">
        <span class="top-profile"><a href="/profile/<?= $arResult['user']['ID'] ?>/">Профиль</a></span>
    </div>
    <div class="top-border">
        <span class="top-message"><i><?=$arResult['COUNT_TO']?></i><a href="/messages/">Сообщения</a></span>
    </div>
    <div class="top-border">
        <span class="top-favorit"><a href="/profile/<?= $arResult['user']['ID'] ?>/favorite/">Избранное</a></span>
    </div>
    <div class="end"></div>
</div>