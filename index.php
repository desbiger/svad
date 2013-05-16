<?
$_SERVER["DOCUMENT_ROOT"] = ('/home/l/lovestore/public_html');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
CMar::SetTitle("Лучшая свадьба на Клуб новобрачных.рф #CITY#");
?>
    <div class="slider-container" >

        <div class="textHeader">
            Фото дня
        </div>

        <?$APPLICATION->IncludeComponent("sozdavatel:catalog.section.fotorama", "index", array(
                "IBLOCK_TYPE" => "photos",
                "IBLOCK_ID" => "1",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "ELEMENT_SORT_FIELD" => "shows",
                "ELEMENT_SORT_ORDER" => "asc",
                "FILTER_NAME" => "arrFilter",
                "INCLUDE_SUBSECTIONS" => "Y",
                "SHOW_ALL_WO_SECTION" => "Y",
                "CONTAINER_WIDTH" => "638",
                "CONTAINER_HEIGHT" => "359",
                "TRANSITION_DURATION" => "333",
                "TOUCH_STYLE" => "N",
                "BACKGROUND_COLOR" => "",
                "MARGIN" => "0",
                "MIN_PADDING" => "0",
                "PRELOAD" => "3",
                "ZOOM_TO_FIT" => "Y",
                "ARROWS" => "Y",
                "ARROWS_COLOR" => "",
                "THUMBS_STYLE" => "preview",
                "THUMBS_BACKGROUND_COLOR" => "",
                "THUMB_COLOR" => "",
                "THUMB_SIZE" => "81",
                "THUMB_MARGIN" => "10",
                "THUMB_BORDER_WIDTH" => "1",
                "THUMB_BORDER_COLOR" => "#202020",
                "CAPTION" => "N",
                "JQUERY_INC" => "N",
                "CACHE_FILTER" => "N",
                "FOTORAMA_ID" => "1",
                "PAGE_ELEMENT_COUNT" => 10
            ),
            false
        );?>
    </div>

    <div class="slider-player-container gradient">
        <?
        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/upload/topWeekVideo.txt';
        $videoID = unserialize(file_get_contents($fileName));
        if ($videoID[0]):
            $element = CIBlockElement::GetByID($videoID[0])->GetNextElement();
            $fields = $element->GetFields();
            $video = $element->GetProperty(19);
            $video = $video['VALUE'];
            $fields['PREVIEW_PICTURE'] = CFile::ResizeImageGet($fields['PREVIEW_PICTURE'], array('width' => 280, 'height' => 210), BX_RESIZE_IMAGE_EXACT, true);

            if (!function_exists('getVideoService')) {
                include $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/mar/photogallery.detail.list.ex/video_services.php';
            }

            $arParams = array(
                'PATH' => $video,
                'WIDTH' => '582',
                'HEIGHT' => '374'
            );

            $video = getVideoService($arParams);

            $disc = $fields['PREVIEW_TEXT'];

            $user = CUser::GetByID($fields['CREATED_BY'])->GetNext();

            if ($user['UF_CITY']) {
                $user['UF_CITY'] = CIBlockElement::GetByID($user['UF_CITY'])->GetNext();
            }

            $urlProfile = '/profile/' . $fields['CREATED_BY'] . '/albums/' . $fields['IBLOCK_SECTION_ID'] . '/' . $fields['ID'] . '/';
            ?>

            <div class="popapVideoTopWeek">
                <div class="gradient float-pop">
                    <div class="gradient-2">

                        <div class="reg-container">
                            <div class="content-header">
                                Лучшее видео
                            </div>
                            <div class="end"></div>
                            <div class="player-pop-box">

                            </div>
                            <div class="end"></div>
                            <div class="video-name">
                                <a href="<?= $urlProfile ?>"><?=$disc?></a>
                                <span><?=$user['UF_CITY']['NAME']?>, <?=$user["NAME"]?> <?=$user["LAST_NAME"]?></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="end"></div>
            </div>

            <div class="slider-player-box">
                <div class="content-header">
                    Лучшее видеo
                    <div class="player-href player-href-2">
                        <a href="#"></a>
                    </div>
                </div>
                <div class="end"></div>

                <div class="player-box">
                    <a id="videoTopWeek" href="#video"><img src="<?= $fields['PREVIEW_PICTURE']['src'] ?>"/></a>
                </div>

                <div class="video-name">
                    <a href="<?= $urlProfile ?>"><?=$disc?></a>
                    <span><?=$user['UF_CITY']['NAME']?>, <?=$user["NAME"]?> <?=$user["LAST_NAME"]?></span>
                </div>
            </div>


            <script type="text/javascript">
                $('#videoTopWeek').click(function () {
                    $('.popapVideoTopWeek .player-pop-box').html('<?=$video?>');
                    $('.popapVideoTopWeek, .grayCap').fadeIn('fast');
                    $('.grayCap').click(function () {
                        $('.popapVideoTopWeek, .grayCap').fadeOut('fast', function () {
                            $('.popapVideoTopWeek .player-pop-box').html('');
                        });
                        return false;
                    });
                    return false;
                });
            </script>

        <? endif;?>
    </div>

    <div class="end"></div>

    <div class="content-left">
    <?
    $arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
    $arFilter = Array("IBLOCK_ID" => 7, "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(
        Array('ACTIVE_FROM' => 'desc'),
        $arFilter,
        false,
        Array("nTopCount" => 7),
        $arSelect
    );
    $index = 0;
    $arResult['ARTICLE_NEW'] = array();
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();

        if (!$index && $arFields['PREVIEW_PICTURE'] && $arFile = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width' => 180, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true)) {
            $arFields['PREVIEW_PICTURE'] = $arFile['src'];
        }
        $index++;

        $arFields['~PREVIEW_TEXT'] = TruncateText(strip_tags($arFields['PREVIEW_TEXT']), 75);

        $arResult['ARTICLE_NEW'][] = $arFields;
    }
    ?>
    <?if ($arResult['ARTICLE_NEW']): ?>
        <div class="content-header">
            Статьи:
        </div>
        <div class="content-select switch_article">
            <span class="active" data-rel="article_new">новые</span>
            <span data-rel="article_top">популярные</span>
        </div>
        <div class="end"></div>

        <script type="text/javascript">
            $('.switch_article span').click(function () {
                if ($(this).hasClass('active')) {
                    return false;
                }
                $('.switch_article span').toggleClass('active');
                var show = $('.switch_article span.active').data('rel');
                var hide = $('.switch_article span:not(.active)').data('rel');
                $('.' + show).show();
                $('.' + hide).hide();
                return false;
            });
        </script>
        <div class="article_new">
            <?if ($arResult['ARTICLE_NEW'][0]): ?>
                <div class="content-float">
                    <?if ($arResult['ARTICLE_NEW'][0]['PREVIEW_PICTURE']): ?>
                        <img class="content-img" src="<?= $arResult['ARTICLE_NEW'][0]['PREVIEW_PICTURE'] ?>"/>
                    <? else: ?>
                        <img class="content-img" src="<?= SITE_TEMPLATE_PATH ?>/images/pic-2.jpg"/>
                    <?endif;?>
                    <div class="article-box">
                        <?= $arResult['ARTICLE_NEW'][0]['NAME']?>
                        <a href="<?= $arResult['ARTICLE_NEW'][0]['DETAIL_PAGE_URL'] ?>"><?= $arResult['ARTICLE_NEW'][0]['~PREVIEW_TEXT']?></a>
                    </div>
                </div>
                <? unset($arResult['ARTICLE_NEW'][0]); ?>
            <? endif;?>
            <?$arResult['ARTICLE_NEW'] = array_chunk($arResult['ARTICLE_NEW'], 3);?>
            <?foreach ($arResult['ARTICLE_NEW'] as $articles): ?>
                <div class="content-float-vstavka">&nbsp;</div>
                <div class="content-float">
                    <?foreach ($articles as $article): ?>
                        <div class="article-box">
                            <?=$article['NAME']?>
                            <a href="<?= $article['DETAIL_PAGE_URL'] ?>"><?=$article['~PREVIEW_TEXT']?></a>
                        </div>
                    <? endforeach;?>
                </div>
            <? endforeach;?>
        </div>

        <?
        $arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
        $arFilter = Array("IBLOCK_ID" => 7, "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(
            Array('SHOW_COUNTER' => 'desc'),
            $arFilter,
            false,
            Array("nTopCount" => 7),
            $arSelect
        );
        $index = 0;
        $arResult['ARTICLE_TOP'] = array();
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();

            if (!$index && $arFields['PREVIEW_PICTURE'] && $arFile = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width' => 180, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true)) {
                $arFields['PREVIEW_PICTURE'] = $arFile['src'];
            }
            $index++;

            $arFields['~PREVIEW_TEXT'] = TruncateText(strip_tags($arFields['PREVIEW_TEXT']), 75);

            $arResult['ARTICLE_TOP'][] = $arFields;
        }
        ?>
        <div class="article_top">
            <?if ($arResult['ARTICLE_TOP'][0]): ?>
                <div class="content-float">
                    <?if ($arResult['ARTICLE_TOP'][0]['PREVIEW_PICTURE']): ?>
                        <img class="content-img" src="<?= $arResult['ARTICLE_TOP'][0]['PREVIEW_PICTURE'] ?>"/>
                    <? else: ?>
                        <img class="content-img" src="<?= SITE_TEMPLATE_PATH ?>/images/pic-2.jpg"/>
                    <?endif;?>
                    <div class="article-box">
                        <?= $arResult['ARTICLE_TOP'][0]['NAME']?>
                        <a href="<?= $arResult['ARTICLE_TOP'][0]['DETAIL_PAGE_URL'] ?>"><?= $arResult['ARTICLE_TOP'][0]['~PREVIEW_TEXT']?></a>
                    </div>
                </div>
                <? unset($arResult['ARTICLE_TOP'][0]); ?>
            <? endif;?>
            <?$arResult['ARTICLE_TOP'] = array_chunk($arResult['ARTICLE_TOP'], 3);?>
            <?foreach ($arResult['ARTICLE_TOP'] as $articles): ?>
                <div class="content-float-vstavka">&nbsp;</div>
                <div class="content-float">
                    <?foreach ($articles as $article): ?>
                        <div class="article-box">
                            <?=$article['NAME']?>
                            <a href="<?= $article['DETAIL_PAGE_URL'] ?>"><?=$article['~PREVIEW_TEXT']?></a>
                        </div>
                    <? endforeach;?>
                </div>
            <? endforeach;?>
        </div>

        <div class="end"></div>
    <? endif;?>


    <?
    $arSelect = Array("ID", "CREATED_BY", "IBLOCK_SECTION_ID", "PREVIEW_PICTURE");
    $arFilter = Array("IBLOCK_ID" => 1, "ACTIVE" => "Y", "PROPERTY_REAL_VIDEO" => NULL);
    $res = CIBlockElement::GetList(
        Array('created' => 'desc'),
        $arFilter,
        false,
        Array("nTopCount" => 12),
        $arSelect
    );
    $arResult['PHOTOS'] = array();
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if ($arFields['PREVIEW_PICTURE'] && $arFile = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width' => 160, 'height' => 160), BX_RESIZE_IMAGE_EXACT, true)) {
            $arFields['PREVIEW_PICTURE'] = $arFile['src'];
        }
        $arResult['PHOTOS'][] = $arFields;
    }
    ?>
    <?if ($arResult['PHOTOS']): ?>
        <div class="content-header">
            Новые фото
        </div>
        <div class="end"></div>
        <div class="galery-container">
            <?foreach ($arResult['PHOTOS'] as $photo): ?>
                <a href="/profile/<?= $photo["CREATED_BY"] ?>/albums/<?= $photo["IBLOCK_SECTION_ID"] ?>/<?= $photo["ID"] ?>/"><img
                        src="<?= $photo["PREVIEW_PICTURE"] ?>"/><span>&nbsp;</span></a>
            <? endforeach;?>
            <div class="end"></div>
        </div>
    <? endif;?>

    <?
    $arSelect = Array("ID", "NAME", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
    $arFilter = Array("IBLOCK_ID" => 11, "ACTIVE" => "Y", "ACTIVE_DATE" => "Y", "PROPERTY_REAL_VIDEO" => NULL);
    $res = CIBlockElement::GetList(
        Array('created' => 'desc'),
        $arFilter,
        false,
        Array("nTopCount" => 3),
        $arSelect
    );
    $arResult['SPECIALS'] = array();
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if ($arFields['PREVIEW_PICTURE'] && $arFile = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width' => 180, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true)) {
            $arFields['PREVIEW_PICTURE'] = $arFile['src'];
        }
        $arFields['~PREVIEW_TEXT'] = TruncateText(strip_tags($arFields['DETAIL_TEXT']), 75);
        $arResult['SPECIALS'][] = $arFields;
    }
    ?>
    <?if ($arResult['SPECIALS']): ?>
        <div class="content-header">Спецпредложения</div>
        <div class="end"></div>
        <? $count = 0; ?>
        <? foreach ($arResult['SPECIALS'] as $special): ?>
            <? if ($count): ?>
                <div class="content-float-vstavka">&nbsp;</div>
            <? endif; ?>
            <div class="content-float">
                <div class="special-article-box">
                    <a href="<?= $special['DETAIL_PAGE_URL'] ?>">

                        <?if ($special['PREVIEW_PICTURE']): ?>
                            <img src="<?= $special['PREVIEW_PICTURE'] ?>"/>
                        <? else: ?>
                            <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty_hd.jpg" width="180px"/>
                        <?endif;?>
                        <?= $special['NAME']?>

                        <div class="article-text"><?= $special['~PREVIEW_TEXT']?></div>
                    </a>
                </div>
            </div>
            <? $count++; ?>
        <? endforeach; ?>
    <? endif;?>
    <div class="end"></div>
    </div>

    <div class="content-right">

        <div class="content-header">
            Новое в каталоге:
        </div>
        <div class="end"></div>

        <?
        $GROUP_ID = 7;

        if (!CModule::IncludeModule("iblock")) {
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
        }

        $arParam["SELECT"][] = "UF_RATING";
        $arParam['NAV_PARAMS']["nTopCount"] = 5;

        $filter = Array
        (
            "ACTIVE" => "Y",
            "UF_CITY" => GetDefCity(),
            "GROUPS_ID" => Array($GROUP_ID)
        );

        $rsUsers = CUser::GetList(($by = "DATE_REGISTER"), ($order = "desc"), $filter, $arParam);

        $arResult['items'] = array();

        while ($arUser = $rsUsers->Fetch()) {
            if ($arFile = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 62, 'height' => 62), BX_RESIZE_IMAGE_EXACT, true)) {
                $arUser['PERSONAL_PHOTO'] = $arFile['src'];
            }

            $arUser['RATING'] = intval($arUser['UF_RATING']);

            $arResult['items'][] = $arUser;
        }
        ?>

        <?foreach ($arResult['items'] as $user): ?>
            <a class="catalog-box" href="/profile/<?= $user['ID'] ?>/">
                <?if ($user['PERSONAL_PHOTO']): ?>
                    <img src="<?= $user['PERSONAL_PHOTO'] ?>"/>
                <? else: ?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="61px" height="61px"/>
                <?endif;?>
                <span><?=$user['NAME']?> <?=$user['LAST_NAME']?></span>
                <u><?=$user['PERSONAL_CITY']?></u>
                Рейтинг: <i><?=$user['RATING']?></i>
                <b>&nbsp;</b>
            </a>
        <? endforeach;?>

        <script type="text/javascript">
            $(function () {
                if ($('.baner_img').attr('src') === '') {
                    $('.baner_town').css('display', 'none');
                }
                return false;
            });
        </script>

        <div class="right-banner">
            <?$APPLICATION->IncludeComponent(
                "mar:banners.generalPage",
                "",
                Array(
                    "TOWN_ID" => ""
                )
            );?>
        </div>

        <?$APPLICATION->IncludeComponent("mar:forum.topic.last", "layout", array(
                "FID" => array(),
                "NID" => array(
                    0 => "3",
                    1 => "5",
                    2 => "4",
                ),
                "SORT_BY" => "LAST_POST_DATE",
                "SORT_ORDER" => "DESC",
                "SORT_BY_SORT_FIRST" => "Y",
                "URL_TEMPLATES_INDEX" => "index.php",
                "URL_TEMPLATES_LIST" => "list.php?FID=#FID#",
                "URL_TEMPLATES_READ" => "read.php?FID=#FID#&TID=#TID#",
                "URL_TEMPLATES_MESSAGE" => "/forum/messages/forum#FID#/topic#TID#/message#MID#/",
                "URL_TEMPLATES_PROFILE_VIEW" => "profile_view.php?UID=#UID#",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "TOPICS_PER_PAGE" => "4",
                "DATE_TIME_FORMAT" => "j F Y G:i",
                "SHOW_FORUM_ANOTHER_SITE" => "Y",
                "SET_TITLE" => "N",
                "SET_NAVIGATION" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TITLE" => "Темы",
                "PAGER_TEMPLATE" => "",
                "SHOW_NAV" => array(),
                "SHOW_COLUMNS" => array(
                    0 => "LAST_POST_DATE",
                ),
                "SHOW_SORTING" => "N",
                "SEPARATE" => "в форуме #FORUM#"
            ),
            false
        );?>
    </div>

    <div class="end"></div>

<?
$newUsers = array();

$arParam["SELECT"][] = "UF_RATING";
$arParam["SELECT"][] = "UF_CITY";
$arParam["SELECT"][] = "PERSONAL_GENDER";
$arParam["SELECT"][] = "UF_WED_DATE";

$GROUP_ID = 8;

$filter = Array(
    "ACTIVE" => "Y",
    "UF_CITY" => GetDefCity(),
    "GROUPS_ID" => Array($GROUP_ID),
    "PERSONAL_GENDER" => "M|F",
    "<=UF_WED_DATE" => date('d-m-Y H:i:s'),
    ">=UF_WED_DATE" => date('d-m-Y H:i:s', strtotime('-1 week')),
);

$rsUsers = CUser::GetList(($by = "UF_RATING"), ($order = "desc"), $filter, $arParam);

while ($arUser = $rsUsers->Fetch()) {
    $newUsers[] = $arUser;
}

if (count($rsUsers) < 10) {
    $arParam['nTopCount'] = 10 - count($rsUsers);

    unset($filter['>=UF_WED_DATE']);
    $filter['<=UF_WED_DATE'] = date('d-m-Y H:i:s', strtotime('-1 week'));

    $rsUsers = CUser::GetList(($by = "UF_WED_DATE"), ($order = "desc"), $filter, $arParam);

    while ($arUser = $rsUsers->Fetch()) {
        $newUsers[] = $arUser;
    }
}

foreach ($newUsers as &$arUser) {
    if ($arFile = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 80, 'height' => 80), BX_RESIZE_IMAGE_EXACT, true)) {
        $arUser['PERSONAL_PHOTO'] = $arFile['src'];
    }

    if ($arUser['UF_CITY']) {
        $arUser['UF_CITY'] = CIBlockElement::GetByID($arUser['UF_CITY'])->GetNext();
    }

    if ($arUser['PERSONAL_GENDER']) {
        if ($arUser['PERSONAL_GENDER'] == 'M') {
            $arUser['STATUS']['NAME'] = 'Муж';
        } else {
            $arUser['STATUS']['NAME'] = 'Жена';
        }
    }
}
?>
<? if (count($newUsers)): ?>
    <div class="content-header">
        Поздравляем с бракосочетанием!
        <span><?=count($newUsers)?></span>
    </div>
    <div class="end"></div>

    <div class="scroll-pane horizontal-only">
        <div class="presents-container">

            <?foreach ($newUsers as $user): ?>
                <div class="presents-box">
                    <a href="/profile/<?= $user['ID'] ?>/">
				<span>
					<?if ($user['PERSONAL_PHOTO']): ?>
                        <img src="<?= $user['PERSONAL_PHOTO'] ?>"/>
                    <? else: ?>
                        <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="80px" height="80px"/>
                    <?endif;?>
				</span>
                        <?=$user['NAME']?> <?=$user['LAST_NAME']?>
                    </a><br>
                    <?=$user['UF_CITY']['NAME']?>, Россия
                </div>
            <? endforeach;?>

            <div class="end"></div>
        </div>
    </div>
<? endif; ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>