<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($USER->IsAuthorized() && $USER->GetEmail() == '' && $APPLICATION->GetCurPageParam() != '/profile/edit/') {
    LocalRedirect('/profile/edit/');
    die();
}

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery-1.8.0.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.placeholder.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.form.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.mousewheel.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.jscrollpane.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.galleria.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/jcarousel/lib/jquery.jcarousel.pack.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.hotkeys-0.7.8-packed.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/tutorial.js');

if (strpos($GLOBALS["APPLICATION"]->GetCurPage(true), SITE_DIR . "people/index.php") === 0 || strpos($GLOBALS["APPLICATION"]->GetCurPage(true), SITE_DIR . "groups/index.php") === 0)
    $GLOBALS["bRightColumnVisible"] = true;
else
    $GLOBALS["bRightColumnVisible"] = ($GLOBALS["APPLICATION"]->GetProperty("hide_sidebar") == "Y" ? false : true);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?$APPLICATION->ShowHead()?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/jcarousel/lib/jquery.jcarousel.css"/>
    <link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/jcarousel/skins/tango/skin.css"/>
    <link type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/css/jquery.jscrollpane.css" rel="stylesheet" media="all"/>
    <link rel="SHORTCUT ICON" href="http://newlyweds-club.ru<?= SITE_TEMPLATE_PATH ?>/images/favicon.ico"
          type="image/x-icon">
    <?=CMar::ShowSocialTitle()?>
    <?=CMar::ShowSocialDescription()?>
    <?=CMar::ShowSocialImage()?>
    <script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(function () {
            jQuery('.scroll-pane').jScrollPane();
            jQuery('input[placeholder], textarea[placeholder]').placeholder();
        });
    </script>

</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?php if ($USER->IsAuthorized()): ?>
<div class="gradient">
    <div class="top-back">
        <? $APPLICATION->IncludeComponent("mar:soc.profile.mini", "", array(), null, null); ?>
    </div>
</div>
    <?php else: ?>
<div class="gradient">
    <div class="top-back">
        <div class="top-container">
            <div class="city-box">
                <form method="post">
                    Ваш
                    город <?=SelectBoxFromArray('HEADER_SELECT_CITY_SET', GetCitys(), GetDefCity(), GetMessage("ISL_COUNTRY_EMPTY"), 'class="select-2" onchange="$(this).closest(\'form\').trigger(\'submit\');"');?>
                </form>
            </div>

            <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
                array(//"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                    //"SUFFIX"=>"form",
                ),
                null,
                null
            );
            ?>

            <div class="login-social">
                <span>Войти с помощью:</span>
                <ul>
                    <li><a class="top-vk popapAuthSocShow" href="#">&nbsp;</a></li>
                    <li><a class="top-face popapAuthSocShow" href="#">&nbsp;</a></li>
                    <li><a class="top-twit popapAuthSocShow" href="#">&nbsp;</a></li>
                    <li><a class="top-odnokl popapAuthSocShow" href="#">&nbsp;</a></li>
                    <li><a class="top-gmail popapAuthSocShow" href="#">&nbsp;</a></li>
                    <li><a class="top-mail popapAuthSocShow" href="#">&nbsp;</a></li>
                </ul>
            </div>
            <div class="log-in">
                <span><a class="top-mail popapEnterShow" href="#login">Войти</a></span>
                |
                <a class="top-mail popapRegShow" href="#reg">Регистрация</a>
            </div>
        </div>
    </div>
</div>
    <?php endif; ?>

<div class="container">
    <div class="header">
        <a class="logo" href="/">&nbsp;</a>

        <div class="header-data">
            <span><?=FormatDate('j', time());?></span>
            <?=FormatDate('F, Y', time());?>
            <i><?=FormatDate('l', time());?>    </i>

            <div class="end"></div>
        </div>
        <div class="search-container">
            Поиск по сайту:
            <form action="/catalog/" method="get">
                <div class="search-box">
                    <input name="search" class="input-1" type="text" value="<?=strip_tags($_GET['search'])?>"/>
                    <input class="search-button" type="submit" value=""/>
                </div>
            </form>
            <span>Пример: <a class="on_click">свадебный фотограф</a></span>
        </div>
    </div>
<script type="text/javascript">
    $(function(){
        $('.on_click').click(function(){
           var text = $('.on_click').text();
            $('.input-1').val(text);
        });
    });
</script>
    <div class="ad_980_124">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/ab_test.php",
            "EDIT_TEMPLATE" => ""
        ),
        false
    );?>
    </div>
<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "main",
    Array(
        "ROOT_MENU_TYPE" => "top",
        "MAX_LEVEL" => "1",
        "USE_EXT" => "N",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_TIME" => "36000000",
        "MENU_CACHE_USE_GROUPS" => "N",
        "MENU_CACHE_GET_VARS" => Array()
    )
);?>