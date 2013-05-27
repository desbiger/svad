<div class="content-container">
<div class="kroski-box">
    <a href="/profile/<?= $arResult['user']['ID'] ?>/">Вернуться к профилю</a>

    <div class="end"></div>
</div>




<h3 class="statii">Введите Дату свадьбы:</h3>

<!--<form method="post" action="" name="regform" enctype="multipart/form-data">-->
<form id="profile_edit" method="post" name="form1" action=""
      enctype="multipart/form-data">

    <div class="fields integer" id="main_UF_WED_DATE">
        <div class="fields datetime">

            <?//
            //            if($_REQUEST['date_fld']){$valueInput = $_REQUEST['date_fld'];}
            //            else {
            //                $valueInput = '';
            //            }
            //?>
            <?
//            ob_start();
            ?> <?$APPLICATION->IncludeComponent(
                "mycomponent:main.profile",
                "profile_edit",
                Array(
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "SET_TITLE" => "Y",
                    "USER_PROPERTY" => array(0=>"UF_GROUP",1=>"UF_STATUS",2=>"UF_CITY",3=>"UF_SKYPE",4=>"UF_WED_DATE"),
                    "SEND_INFO" => "N",
                    "CHECK_RIGHTS" => "N",
                    "USER_PROPERTY_NAME" => "",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );?> <?
//            $ob_result = ob_get_contents();

//            ?><!-- --><?//if(!($user = mar_getUser())) {	die(); }?>

            <? $valueInput = $arResult['user']['UF_WED_DATE']?>

            <?$APPLICATION->IncludeComponent("bitrix:main.calendar", "", Array(
                    "SHOW_INPUT" => "Y",
                    "FORM_NAME" => "",
                    "INPUT_NAME" => "date_fld",
//                        "INPUT_NAME_FINISH" => "date_fld_finish",
                    "INPUT_VALUE" => $valueInput,
                    "INPUT_VALUE_FINISH" => "",
                    "SHOW_TIME" => "Y",
                    "HIDE_TIMEBAR" => "Y"
                )
            );?>


        </div>
    </div>

<!--    <input class="button marg" type="submit" value="Сохранить" name="save">-->
    <input class="button marg" type="submit" name="save"
           value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
</form>




<br/>

<h3 class="statii">Возможно вам будут интересны статьи:</h3>

<?=getStats::getStatsFunction(19);?>
<?

$GROUP_ID = 7;

if (!CModule::IncludeModule("iblock")) {
    ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
    return;
}

$arDefaultVariableAliases404 = array();

$SEF_URL_TEMPLATES = array(
    "catalog" => "#STATUS_CODE#/"
);

$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultVariableAliases404, $SEF_URL_TEMPLATES);
$arVariables = array();
$componentPage = CComponentEngine::ParseComponentPath(
    "/catalog/",
    $arUrlTemplates,
    $arVariables
);

$obCache = new CPHPCache;
$life_time = 30 * 60; // ����� ����������� - 30 �����
$city_id = GetDefCity();
$cache_id = 'CATALOG_LIST_STATUS_COUNTS_' . $city_id;
if ($obCache->InitCache($life_time, $cache_id, "/")) {
    $counts = $obCache->GetVars();
}


if ($obCache->StartDataCache()) {
    $strSql = "
		SELECT count(uts.VALUE_ID) as ct
				 , uts.UF_STATUS as st
		FROM
			b_uts_user AS uts, b_user_group AS b_group
		WHERE
			GROUP_ID = $GROUP_ID
			AND VALUE_ID = USER_ID
			AND UF_CITY = $city_id
		GROUP BY
			uts.UF_STATUS
	";

    $res = $DB->Query($strSql, true);
    $counts = array();
    while ($count = $res->GetNext()) {
        $counts[(int)$count['st']] = (int)$count['ct'];
    }
    $obCache->EndDataCache($counts);
}

$arSelect = array(
    'ID', 'NAME', 'CODE', 'PROPERTY_A_NAMES', 'PROPERTY_A_TITLE'
);
$statusFilter = array(
    "IBLOCK_ID" => 3,
    "ACTIVE" => "Y",
);
$arResult['STATUS'] = array();
$statuses = CIBlockElement::GetList(array("SORT" => "ASC"), $statusFilter, false, false, $arSelect);
while ($status = $statuses->GetNext()) {
    if ($status['CODE'] == $arVariables['STATUS_CODE']) {
        $arResult['STATUS_SELECT'] = $status;
        $status['SELECT'] = "Y";
        if ($status['PROPERTY_A_TITLE_VALUE'])
            CMar::SetTitle($status['PROPERTY_A_TITLE_VALUE']);
    }
    if (isset($counts[(int)$status['ID']])) {
        $status['USER_COUNT'] = $counts[(int)$status['ID']];
    }
    $arResult['STATUS'][] = $status;
}

$arParam["SELECT"][] = "UF_RATING";

$filter = Array
(
    "ACTIVE" => "Y",
    "UF_CITY" => GetDefCity(),
    "GROUPS_ID" => Array($GROUP_ID)
);

if ($componentPage == 'catalog') {
    $filter['UF_STATUS'] = $arResult['STATUS_SELECT']['ID'];
}

if (!empty($_GET['search'])) {
    unset($filter['UF_CITY']);
    $name = strip_tags($_GET['search']);
    $name = explode(' ', $name);
    foreach ($name as &$search) {
        $search .= '%';
    }
    $filter['NAME'] = '(' . implode(' && ', $name) . ')';
}

$rsUsers = CUser::GetList(($by = "UF_RATING"), ($order = "desc"), $filter, $arParam);
$is_filtered = $rsUsers->is_filtered;
$rsUsers->NavStart(3);

$arResult['itemsCount'] = $rsUsers->NavRecordCount;
$arResult['items'] = array();

while ($arUser = $rsUsers->Fetch()) {
    if ($arFile = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 62, 'height' => 62), BX_RESIZE_IMAGE_EXACT, true)) {
        $arUser['PERSONAL_PHOTO'] = $arFile['src'];
    }

    $arUser['RATING'] = intval($arUser['UF_RATING']);

    $arFilter = array(
        'IBLOCK_ID' => 1,
        'CREATED_BY' => $arUser['ID'],
    );

    $opPhoto = CIBlockElement::GetList(Array(), $arFilter, false, array("nTopCount" => 3));

    $arUser['PHOTOS'] = array();

    while ($arPhoto = $opPhoto->GetNext()) {
        if ($arPhoto['PREVIEW_PICTURE'] && $arFile = CFile::ResizeImageGet($arPhoto['PREVIEW_PICTURE'], array('width' => 121, 'height' => 121), BX_RESIZE_IMAGE_EXACT, true)) {
            $arPhoto['PICTURE'] = $arFile['src'];
        }

        $arUser['PHOTOS'][] = $arPhoto;
    }

    $arResult['items'][] = $arUser;
}

//    $arResult['navigation'] = $rsUsers->GetNavPrint(
//        GetMessage("PAGES"),
//        false,
//        "text",
//        '/bitrix/components/mar/catalog.list/templates/.default/pagenavigation.php'
//    );

?>


<div class="content-right-2">

    <div class="content-header">
        <?=isset($arResult['STATUS_SELECT']) ? $arResult['STATUS_SELECT']['PROPERTY_A_NAMES_VALUE'] : ''?>
        <!--		<span>--><?//=$arResult['itemsCount']?><!--</span>-->
    </div>
    <div class="end"></div>

    <? foreach ($arResult['items'] as $arUser): ?>
        <!--	--><? // echo '<pre>', print_r($arUser, true) , '</pre>';?>
        <div class="ispolnitel-name-container">
            <div class="ispolnitel-name">
                <a class="catalog-box" href="/profile/<?= $arUser['ID'] ?>/">
                    <?if ($arUser['PERSONAL_PHOTO']): ?>
                        <img src="<?= $arUser['PERSONAL_PHOTO'] ?>"/>
                    <? else: ?>
                        <img src="<?= SITE_TEMPLATE_PATH ?>/images/cover_empty.jpg" width="61px" height="61px"/>
                    <?endif;?>
                    <span><?=$arUser['NAME']?> <?=$arUser['LAST_NAME']?></span>
                    <u><?=$arUser['PERSONAL_CITY']?></u>
                    Рейтинг: <i><?=$arUser['RATING']?></i>
                    <b>&nbsp;</b>
                </a>
            </div>
            <?if ($arUser['PHOTOS']): ?>
                <div class="ispolnitel-prew">
                    <?foreach ($arUser['PHOTOS'] as $photo): ?>
                        <a href="/profile/<?= $arUser['ID'] ?>/"><img src="<?= $photo['PICTURE'] ?>"/></a>
                    <? endforeach;?>
                    <div class="end"></div>
                </div>
            <? endif;?>
            <div class="end"></div>
        </div>
    <? endforeach; ?>

    <?=$arResult['navigation'];?>


</div>
</div>


