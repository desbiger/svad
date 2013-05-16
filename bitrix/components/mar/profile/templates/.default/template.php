<div class="left-menu-container">
    <div class="left-menu">
        <div class="ispolnitel-name">
            <div class="catalog-box ispolnitel-name-profile">
                <?if ($arResult['USER']['PERSONAL_PHOTO']): ?>
                    <img src="<?= $arResult['USER']['PERSONAL_PHOTO'] ?>"/>
                <? else: ?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="80px" height="80px"/>
                <?endif;?>
                <span>
					<? $userName = ($arResult['USER']['NAME'] ? $arResult['USER']['NAME'] . ($arResult['USER']['LAST_NAME'] ? ' ' . $arResult['USER']['LAST_NAME'] : '') : $arResult['USER']['LOGIN']); ?>
                    <?= $userName ?>
                    <? if ($arResult['USER']['IS_ONLINE'] == 'Y'): ?>
                        <strong>&nbsp;</strong>
                    <? endif; ?>
				</span>
                <u><?
                    $STATUS_BK = array();
                    if ($arResult['USER']['STATUS']) {
                        $STATUS_BK[] = $arResult['USER']['STATUS']['NAME'];
                    }
                    if ($arResult['USER']['CITY']) {
                        $STATUS_BK[] = $arResult['USER']['CITY']['NAME'];
                    }
                    echo implode(', ', $STATUS_BK)
                    ?></u>
                <?if ($arResult['USER']['UF_GROUP'] == 15): ?>
                    <u>
                        <?$datetime = strtotime($arResult['USER']['UF_WED_DATE']);?>
                        <?$day = ceil(abs(($datetime - time()) / (24 * 60 * 60)));?>
                        <?if ($arResult['USER']['is_married']): ?>
                            семье <?= $day ?> <?= plural_form($day, 'день', 'дня', 'дней') ?>
                        <? else: ?>
                            <?= $day ?> <?= plural_form($day, 'день', 'дня', 'дней') ?> до свадьбы
                        <?endif;?>
                    </u>
                <? endif;?>

                <?if ($arResult["USER"]["MODER_BY"] == "Y"): ?>
                    <div class="profile_icon_edit">&nbsp;</div><a class="link" href="/profile/edit/">Редактировать</a>
                <? endif?>
                <div class="end"></div>
                <div class="user-raiting">
                    Рейтинг: <i><?=floor($arResult['USER']['RATING']['weight'])?></i>
                </div>
            </div>
        </div>
        <div class="end"></div>

        <?if ($USER->IsAuthorized() && $arResult['USER']['ID'] != $USER->GetID()): ?>
            <div class="user-options-like">
                <? $arResult['USER']['RATING']['is_self'] = $arResult['USER']['ID']; ?>
                <? $GLOBALS["APPLICATION"]->IncludeComponent("mar:likes", '', $arResult['USER']['RATING'], null, array("HIDE_ICONS" => "Y"));    ?>
            </div>
            <div class="user-options-container">
                <a class="send" href="/message/user/<?= $arResult['USER']['ID'] ?>/action/send/"
                   onclick="if (typeof(BX) != 'undefined' && BX.IM) { BXIM.openMessenger(<?= $arResult["USER"]["ID"] ?>); return false; }
                       else { window.open('/message/user/<?= $arResult['USER']['ID'] ?>/action/send/', '', 'location=yes,status=no,scrollbars=yes,resizable=yes,width=500,height=140,top='+Math.floor((screen.height - 200)/2-14)+',left='+Math.floor((screen.width - 500)/2-5)); return false; }">Написать
                    сообщение</a>

                <a class="otsiv" href="#">Оставить отзыв</a>
                <a class="on-favorit<?= $arResult['IS_FAVORITE'] ? ' selected' : '' ?>" href="#favorite"
                   data-id="<?= $arResult['USER']['ID'] ?>">Добавить в избранное</a>
            </div>
        <? endif;?>

        <div class="user-info-container">
            <?if ($arResult['SERVICES']): ?>
                <div class="content-header-2">
                    Услуги
                </div>
                <table class="user-info-tab" cellpadding="0" cellspacing="0">
                    <?foreach ($arResult['SERVICES'] as $service): ?>
                        <tr>
                            <td><?=$service['NAME']?></td>
                            <?if ($service['PROPERTY_PRICE_FROM_VALUE'] && !$service['PROPERTY_PRICE_TO_VALUE']): ?>
                                <td>от <?=$service['PROPERTY_PRICE_FROM_VALUE']?> р.</td>
                            <? elseif (!$service['PROPERTY_PRICE_FROM_VALUE'] && $service['PROPERTY_PRICE_TO_VALUE']): ?>
                                <td>до <?=$service['PROPERTY_PRICE_TO_VALUE']?> р.</td>
                            <? elseif ($service['PROPERTY_PRICE_FROM_VALUE'] && $service['PROPERTY_PRICE_TO_VALUE']): ?>
                                <td><?=$service['PROPERTY_PRICE_FROM_VALUE']?>-<?=$service['PROPERTY_PRICE_TO_VALUE']?>
                                    р.
                                </td>
                            <?endif;?>
                        </tr>
                    <? endforeach;?>
                </table>
            <? endif;?>

            <div class="content-header-2">
                Контакты
            </div>

            <div class="user-contacts">
                <? if ($arResult['USER']['PERSONAL_PHONE']): ?>
                    <span>Телефон: <?=$arResult['USER']['PERSONAL_PHONE']?></span>
                <? endif; ?>
                <? if ($arResult['USER']['PERSONAL_MOBILE']): ?>
                    <span>Мобильный: <?=$arResult['USER']['PERSONAL_MOBILE']?></span>
                <? endif; ?>
                <? if ($arResult['USER']['UF_SKYPE']): ?>
                    <span>skype: <?=$arResult['USER']['UF_SKYPE']?></span>
                <? endif; ?>
                <? if ($arResult['USER']['PERSONAL_ICQ']): ?>
                    <span>icq: <?=$arResult['USER']['PERSONAL_ICQ']?></span>
                <? endif; ?>
                <? if ($arResult['USER']['PERSONAL_WWW']): ?>
                    <span><a class="link"
                             href="<?= ((strpos($arResult['USER']['PERSONAL_WWW'], 'http') === 0 ? '' : 'http://') . $arResult['USER']['PERSONAL_WWW']) ?>"
                             target="_blank" rel="noindex"><?=$arResult['USER']['PERSONAL_WWW']?></a></span>
                <? endif; ?>
            </div>

            <div class="content-header-2">
                Поделиться
            </div>

            <div class="content-header-2">
                <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/shared.php",
                    "EDIT_TEMPLATE" => ""
                ), false);?>
                <div class="end"></div>
            </div>
        </div>
    </div>
</div>

<div class="content-right-2">
    <div class="content-container">
        <? if ($status = $arResult['USER']['STATUS']): ?>
            <div class="kroski-box">
                <a href="/catalog/<?= $status['CODE'] ?>/">Назад в каталог: <?=$status['PROPERTY_A_NAMES_VALUE']?></a>

                <div class="end"></div>
            </div>
        <? endif; ?>
        <?$APPLICATION->IncludeComponent("bitrix:menu", "profile", array(
                "ROOT_MENU_TYPE" => "profile",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "",
                "USE_EXT" => "N",
                "DELAY" => "Y",
                "ALLOW_MULTI_SELECT" => "N"
            ),
            false
        );?>
        <?
        $PERMISSION = $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0";
        switch ($arResult["PAGE"]) {
            default:
            case 'profile':
                $APPLICATION->IncludeComponent("mar:profile.about", "", Array(
                    "USER" => $arResult['USER'],
                    "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0",
                ));
                break;
            case 'portfolio':
            case 'portfolio_detal':
                $APPLICATION->IncludeComponent("mar:profile.portfolio", "", array("USER" => $arResult['USER'], "VARIABLES" => $arResult['VARIABLES']), null);
                break;
            case 'albums':
                $APPLICATION->IncludeComponent("mar:profile.albums", "", array("USER" => $arResult['USER'], "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0"), null);
                break;
            case 'album_photo':
            case 'album_detal':
                $APPLICATION->IncludeComponent("mar:profile.albums.photos", "", array("USER" => $arResult['USER'], "VARIABLES" => $arResult['VARIABLES']), null);
                break;
            case 'album_new':
                $APPLICATION->IncludeComponent(
                    "mar:photogallery.section.edit",
                    "addalbum",
                    Array(
                        "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0",
                        "IBLOCK_TYPE" => "photos",
                        "IBLOCK_ID" => "1",
                        "SECTION_ID" => $arResult["VARIABLES"]['ALBUM_ID'],
                        "SECTION_CODE" => "",
                        "USER_ALIAS" => "",
                        "BEHAVIOUR" => "",
                        "ACTION" => 'NEW',
                        "INDEX_URL" => "/",
                        "SECTION_URL" => '/profile/' . $arResult["USER"]['ID'] . '/albums/#SECTION_ID#/action/edit/',
                        "SECTION_EDIT_ICON_URL" => '/profile/' . $arResult["USER"]['ID'] . '/albums/' . $arResult["VARIABLES"]['ALBUM_ID'] . '/icon/action/edit/',
                        "CACHE_TYPE" => "N",
                        "CACHE_TIME" => "0",
                        "DATE_TIME_FORMAT" => "d.m.Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y"
                    )
                );
                break;
            case 'album_action':
                switch ($arResult["VARIABLES"]['ACTION']) {
                    case 'edit':
                    case 'drop':
                        $APPLICATION->IncludeComponent("mar:profile.albums.edit", "", array("USER" => $arResult['USER'], "VARIABLES" => $arResult['VARIABLES']), null);
                        break;
                    case 'upload':
                        $APPLICATION->IncludeComponent("mar:photogallery.upload", ".default", array(
                                "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0",
                                "IBLOCK_TYPE" => "photos",
                                "IBLOCK_ID" => "1",
                                "SECTION_ID" => $arResult["VARIABLES"]["ALBUM_ID"],
                                "INDEX_URL" => "index.php",
                                "SECTION_URL" => "/profile/" . $arResult["USER"]["ID"] . "/albums/#SECTION_ID#/action/edit/",
                                "SET_TITLE" => "Y",
                                "UPLOADER_TYPE" => "form",
                                "UPLOAD_MAX_FILE_SIZE" => "4",
                                "MODERATION" => "N",
                                "ALBUM_PHOTO_THUMBS_WIDTH" => "160",
                                "USE_WATERMARK" => "N",
                                "THUMBNAIL_SIZE" => "160",
                                "JPEG_QUALITY1" => "100",
                                "ORIGINAL_SIZE" => "1200",
                                "P_SHOW_RESIZER" => "N",
//								"JPEG_QUALITY" => "100",
                                "PUBLIC_BY_DEFAULT" => 'Y',
                            ),
                            false
                        );
                        break;
                    case 'upload_video':
                        $APPLICATION->IncludeComponent("mar:photogallery.upload.video", ".default", array(
                                "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0",
                                "SECTION_ID" => $arResult["VARIABLES"]["ALBUM_ID"],
                                "SECTION_URL" => "/profile/" . $arResult["USER"]["ID"] . "/albums/#SECTION_ID#/action/edit/",
                            ),
                            false
                        );
                        break;
                }
                break;
            case 'album_edit_icon':
                $APPLICATION->IncludeComponent("bitrix:photogallery.section.edit.icon", ".default", array(
                        "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0",
                        "IBLOCK_TYPE" => "photos",
                        "IBLOCK_ID" => "1",
                        "SECTION_ID" => $arResult["VARIABLES"]['ALBUM_ID'],
                        "SECTION_CODE" => "",
                        "USER_ALIAS" => "",
                        "BEHAVIOUR" => "",
                        "ELEMENT_SORT_FIELD" => "ID",
                        "ELEMENT_SORT_ORDER" => "ASC",
                        "ALBUM_PHOTO_WIDTH" => "200",
                        "ALBUM_PHOTO_THUMBS_WIDTH" => "200",
                        "INDEX_URL" => "index.php",
                        "SECTION_URL" => '/profile/' . $arResult["USER"]['ID'] . '/albums/' . $arResult["VARIABLES"]['ALBUM_ID'] . '/icon/action/edit/',
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N"
                    ),
                    false
                );
                break;
            case 'favorite':
                $APPLICATION->IncludeComponent("mar:profile.favorite", "", array("USER" => $arResult['USER'], "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0"), null);
                break;
            case 'infavorite':
                $APPLICATION->IncludeComponent("mar:profile.infavorite", "", array("USER" => $arResult['USER'], "PERMISSION" => $arResult["USER"]["MODER_BY"] == "Y" ? "W" : "0"), null);
                break;
            case 'reviews':
                $APPLICATION->IncludeComponent("mar:profile.reviews", "", array("USER" => $arResult['USER'], "PERMISSION" => $USER->IsAdmin() ? "W" : "0"), null);
                break;
            case 'work':
                $APPLICATION->IncludeComponent("mar:profile.work", "", array(
                    "USER" => $arResult['USER'],
                    "VARIABLES" => $arResult['VARIABLES'],
                    "PERMISSION" => $PERMISSION
                ), null);
                break;
        }
        ?>
    </div>
</div>