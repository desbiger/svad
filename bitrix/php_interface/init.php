<?php

function mar_getUser()
{
    if ($GLOBALS['USER']->IsAuthorized() && !$GLOBALS['marUSER']) {
        $CACHE_ID = SITE_ID . '|marUSER|' . $GLOBALS['USER']->GetID();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(360000, $CACHE_ID, '/marUSER/')) {
            $rsUser = CUser::GetByID($GLOBALS['USER']->GetID());
            $GLOBALS['marUSER'] = $rsUser->Fetch();
            $cache->EndDataCache($GLOBALS['marUSER']);
        } else {
            $GLOBALS['marUSER'] = $cache->GetVars();
        }
    }
    if ($GLOBALS['marUSER']) {
        return $GLOBALS['marUSER'];
    }
    return array();
}

class like
{
    static $types = array(
        'USER' => 3,
        'ELM' => 1,
        'ELM0' => 0,
        'FRMc' => 0.01,
        'BONUS' => 0
    );

    static public function addCount($element, $type, $weight)
    {
        $DB = $GLOBALS['DB'];

        $fields = $DB->Query('
			SELECT *
			FROM `b_likes_count`
			WHERE `element` = ' . $element . ' and `type` = \'' . $type . '\'
			LIMIT 1
		');

        if (!$fields->AffectedRowsCount()) {
            $affect = $DB->Query('
				INSERT INTO `b_likes_count` (`element`, `type`, `count`, `weight`)
				VALUES (' . $element . ',\'' . $type . '\',1,' . $weight . ')
			');

            if ($type == 'USER') {
                $DB->Query('
				UPDATE `b_uts_user`
				SET `UF_RATING` = (SELECT `weight` FROM `b_likes_count` WHERE `element` = ' . $element . ' and `type` = \'' . $type . '\' LIMIT 1)
				WHERE `VALUE_ID` = ' . $element . '
				LIMIT 1
			');
            }

            if ($affect) {
                return array(
                    'element' => $element,
                    'type' => $type,
                    'count' => 1,
                    'weight' => $weight
                );
            } else {
                return false;
            }
        }

        $field = $fields->Fetch();

        $affect = $DB->Query('
			UPDATE `b_likes_count`
			SET `count` = `count` + 1, `weight` = `weight` + ' . $weight . '
			WHERE `element` = ' . $element . ' and `type` = \'' . $type . '\'
			LIMIT 1;
		');

        if ($type == 'USER') {
            $DB->Query('
				UPDATE `b_uts_user`
				SET `UF_RATING` = (SELECT `weight` FROM `b_likes_count` WHERE `element` = ' . $element . ' and `type` = \'' . $type . '\' LIMIT 1)
				WHERE `VALUE_ID` = ' . $element . '
				LIMIT 1
			');
        }

        if ($affect) {
            return array(
                'element' => $element,
                'type' => $type,
                'count' => $field['count'] + 1,
                'weight' => $field['weight'] + $weight
            );
        } else {
            return false;
        }
    }

    static public function set($element, $is_self, $type = 'USER', $userRating = false, $weight = null)
    {
        $DB = $GLOBALS['DB'];

        $user_id = $GLOBALS['USER']->GetID();
        $element = intval($element);
        $is_self = intval($is_self);
        $type = isset(self::$types[$type]) ? $type : 'USER';
        $weight = is_null($weight) ? self::$types[$type] : $weight;

        $fields = $DB->Query('select `id` from `b_likes` where `liker` = ' . $user_id . ' and `element` = ' . $element . ' and `type` = \'' . $type . '\' limit 1');
        if ($fields->AffectedRowsCount()) {
            return false;
        }

        $fields = $DB->Query('
			INSERT INTO `b_likes` (`liker`, `is_self`, `element`, `type`, `weight`,`date`)
			VALUES (' . $user_id . ',' . $is_self . ',' . $element . ',\'' . $type . '\',' . $weight . ',' . time() . ')');
        if (!$fields->AffectedRowsCount()) {
            return false;
        }

        if ($userRating && $type != 'USER' && ($weight > 0)) {
            self::addCount($userRating, 'USER', $weight);
        }

        return self::addCount($element, $type, $weight);
    }

    static public function get($element, $type = 'USER')
    {
        $DB = $GLOBALS['DB'];

        $user_id = $GLOBALS['USER']->GetID();

        $element = intval($element);
        $type = isset(self::$types[$type]) ? $type : 'USER';

        $result = array(
            'is_like' => false,
            'element' => $element,
            'type' => $type,
            'count' => 0,
            'weight' => 0
        );

        $fields = $DB->Query('
			SELECT *
			FROM `b_likes_count`
			WHERE `element` = ' . $element . ' and `type` = \'' . $type . '\'
			LIMIT 1
		');

        if ($fields->AffectedRowsCount()) {
            $field = $fields->Fetch();

            $result['weight'] = $field['weight'];
            $result['count'] = $field['count'];
        }

        if (!$user_id) {
            return $result;
        }

        $fields = $DB->Query('select `id` from `b_likes` where `liker` = ' . $user_id . ' and `element` = ' . $element . ' and `type` = \'' . $type . '\' limit 1');
        if ($fields->AffectedRowsCount()) {
            $result['is_like'] = true;
        }

        return $result;
    }
}

class CMar
{
    static private $socialTitle = '';
    static private $socialDescription = '';
    static private $socialImage = '';

    static public $_title_tags = array();

    static public function push($key, $value)
    {
        $_SESSION['cmar_storege_' . $key] = $value;
    }

    static public function pop($key)
    {
        $text = '';
        if (isset($_SESSION['cmar_storege_' . $key])) {
            $text = $_SESSION['cmar_storege_' . $key];
            unset($_SESSION['cmar_storege_' . $key]);
        }

        return $text;
    }

    static public function SetTitle($title, array $tags = array())
    {
        if (!CModule::IncludeModule("iblock")) {
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
        }

        if (!self::$_title_tags['#CITY#']) {
            $city_id = GetDefCity();
            $arCity = CIBlockElement::GetByID($city_id)->GetNext();
            self::$_title_tags['#CITY#'] = $arCity['NAME'];
        }

        $tags = array_merge(self::$_title_tags, $tags);

        $title = str_replace(array_keys($tags), array_values($tags), $title);

        $GLOBALS['APPLICATION']->SetTitle($title);
    }

    static public function SetSocialTitle($property_name = "title")
    {
        self::$socialTitle = $property_name;
    }

    static public function GetSocialTitle()
    {
        $title = $GLOBALS['APPLICATION']->GetTitle();

        if (!empty(self::$socialTitle)) {
            $title = strip_tags(self::$socialTitle);
        }

        $result = '<meta name="title" content="' . $title . '" />';
        $result .= '<meta property="og:title" content="' . $title . '" />';
        $result .= '<meta name="mrc__share_title" content="' . $title . '">';
        return $result;
    }

    static public function SetSocialDescription($property_name = "title")
    {
        self::$socialDescription = $property_name;
    }

    static public function GetSocialDescription()
    {
        $description = $GLOBALS['APPLICATION']->GetTitle();

        if (!empty(self::$socialDescription)) {
            $description = strip_tags(self::$socialDescription);
        }

        $result = '<meta name="description" content="' . $description . '" />';
        $result .= '<meta property="og:description" content="' . $description . '" />';
        return $result;
    }

    static public function SetSocialImage($property_name = "title")
    {
        self::$socialImage = $property_name;
    }

    static public function GetSocialImage()
    {
        $image = '/bitrix/templates/mar/images/soclogo.jpg?1';

        if (!empty(self::$socialImage)) {
            $image = self::$socialImage;
        }
        $result = '<link rel="image_src" href="http://newlyweds-club.ru' . $image . '" />' . "\n";
        $result .= '<meta property="og:image" content="http://newlyweds-club.ru' . $image . '" />' . "\n";
        return $result;
    }

    static public function ShowSocialTitle($property_name = "title", $strip_tags = true)
    {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(Array("CMar", "GetSocialTitle"), $property_name);
    }

    static public function ShowSocialDescription($property_name = "title", $strip_tags = true)
    {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(Array("CMar", "GetSocialDescription"), $property_name);
    }

    static public function ShowSocialImage($property_name = "title", $strip_tags = true)
    {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(Array("CMar", "GetSocialImage"), $property_name);
    }

    static public function CalcTopWeekPhoto()
    {
        global $DB;

        $array = array();

        $el = $DB->Query('
			SELECT `lk`.`element`,COUNT(`lk`.`element`) as `count`

			FROM
				`b_iblock_element` AS `el`
				LEFT JOIN b_iblock_element_property ON `b_iblock_element_property`.`IBLOCK_ELEMENT_ID` = `el`.`ID` and IBLOCK_PROPERTY_ID = 19,
				`b_likes` AS `lk`

			WHERE
				`el`.`IBLOCK_ID` = 1
				AND `b_iblock_element_property`.`VALUE` IS NULL
				AND `lk`.`date` > ' . (time() - 604800) . '
				AND `el`.`ID` = `lk`.`element`

			GROUP BY `lk`.`element`
			ORDER BY `count` DESC
			LIMIT 10
		');

        while ($arFetch = $el->Fetch()) {
            $array[] = $arFetch['element'];
        }

        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/upload/topWeek.txt';

        file_put_contents($fileName, serialize($array));
    }

    static public function CalcTopWeekVideo()
    {
        global $DB;

        $array = array();

        $el = $DB->Query('
			SELECT `lk`.`element`,COUNT(`lk`.`element`) as `count`

			FROM
				`b_iblock_element` AS `el`,
				`b_iblock_element_property` as `prop`,
				`b_likes` AS `lk`

			WHERE
				`el`.`IBLOCK_ID` = 1
				AND IBLOCK_PROPERTY_ID = 19
				AND `prop`.`IBLOCK_ELEMENT_ID` = `el`.`ID`
				AND `prop`.`VALUE` IS NOT NULL
				AND `lk`.`date` > ' . (time() - 604800) . '
				AND `el`.`ID` = `lk`.`element`

			GROUP BY `lk`.`element`
			ORDER BY `count` DESC
			LIMIT 1
		');

        while ($arFetch = $el->Fetch()) {
            $array[] = $arFetch['element'];
        }

        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/upload/topWeekVideo.txt';

        file_put_contents($fileName, serialize($array));
    }

    static public function CalcTopWeek()
    {
        self::CalcTopWeekPhoto();
        self::CalcTopWeekVideo();

        return 'CMar::CalcTopWeek();';
    }
}

AddEventHandler("forum", "onBeforeUserAdd", Array("CMarUserForum", "OnBeforeUserAdd"));
AddEventHandler("forum", "onBeforeUserUpdate", Array("CMarUserForum", "OnBeforeUserUpdate"));
class CMarUserForum
{
    function OnBeforeUserAdd(&$arFields)
    {
        $arFields["SHOW_NAME"] = "Y";
    }

    function OnBeforeUserUpdate($profileID, &$arFields)
    {
        $arFields["SHOW_NAME"] = "Y";
    }
}

AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
function OnAfterUserRegisterHandler(&$arFields)
{
    if (isset($arFields["USER_ID"])) {
        $userID = $arFields["USER_ID"];
        $user = CUser::GetByID($userID);
        $user = $user->Fetch();

        CModule::IncludeModule("iblock");

        if (!$user["UF_GROUP"]) {
            $user["UF_GROUP"] = 16;
        }

        $group = CIBlockElement::GetProperty(4, $user["UF_GROUP"], null, array('CODE' => 'A_GROUP_ID'));
        if ($array = $group->GetNext()) {
            CUser::SetUserGroup($userID, array_merge(CUser::GetUserGroup($userID), array($array['VALUE'])));
        }
    }

    return $arFields;
}

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserAddHandler");
function OnAfterUserAddHandler(&$arFields)
{
    if (isset($arFields["ID"])) {
        if (!$arFields["UF_GROUP"]) {
            $arFields["UF_GROUP"] = 16;
        }

        $group = CIBlockElement::GetProperty(4, $arFields["UF_GROUP"], null, array('CODE' => 'A_GROUP_ID'));
        if ($array = $group->GetNext()) {
            CUser::SetUserGroup($arFields["ID"], array_merge(CUser::GetUserGroup($arFields["ID"]), array($array['VALUE'])));
        }
    }
}

AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserAddHandler");
function OnBeforeUserAddHandler(&$arFields)
{
    if ($arFields['EXTERNAL_AUTH_ID']) {
        if (!$arFields["UF_GROUP"]) {
            $arFields["UF_GROUP"] = 16;
        }

        $city = new CCity();

        if ($city_id = $city->GetCityID()) {
            $arFields["UF_CITY"] = $city_id;
        } else {
            $arFields["UF_CITY"] = 0;
        }
    }
}

AddEventHandler("main", "OnAfterUserUpdate", "OnAfterUserUpdateHandler");
function OnAfterUserUpdateHandler(&$arFields)
{
    if ($arFields["RESULT"]) {
        if (isset($arFields["ID"])) {
            $userID = $arFields["ID"];
            $user = CUser::GetByID($userID);
            $user = $user->Fetch();

            CModule::IncludeModule("iblock");

            if (!$user["UF_GROUP"]) {
                $user["UF_GROUP"] = 16;
            }

            $groups = CUser::GetUserGroup($userID);
            foreach ($groups as $indexId => $groupID) {
                if (in_array($groupID, array(7, 8, 9))) {
                    unset($groups[$indexId]);
                }
            }

            $group = CIBlockElement::GetProperty(4, $user["UF_GROUP"], null, array('CODE' => 'A_GROUP_ID'));
            if ($array = $group->GetNext()) {
                CUser::SetUserGroup($userID, array_merge($groups, array($array['VALUE'])));
            }
        }
    }
}

AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
function OnBeforeUserUpdateHandler(&$arFields)
{
    $return = '';

    if ($arFields['UF_GROUP'] == 15) {
        if (is_set($arFields, "PERSONAL_GENDER") && strlen($arFields["PERSONAL_GENDER"]) <= 0) {
            $return .= "Пожалуйста, выберете пол.<br>";
        }
        if (is_set($arFields, "UF_WED_DATE") && strlen($arFields["UF_WED_DATE"]) <= 0) {
            $return .= "Пожалуйста, выберете дату свадьбы.<br>";
        }
    }

    if ($arFields['UF_GROUP'] == 14) {
        if (is_set($arFields, "UF_STATUS") && strlen($arFields["UF_STATUS"]) <= 0) {
            $return .= "Пожалуйста, выберете вид деятельности.<br>";
        }
    }

    if (empty($return)) {
        return true;
    }
    global $APPLICATION;
    $APPLICATION->throwException($return);
    return false;
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", array("videoAdd", "OnBeforeIBlockElementAdd"));

class videoAdd
{

    function getYoutube($pach)
    {
        if (preg_match('#youtube.[^/]+/watch\?v=([^&]+)#', $pach, $matches)) {
            return 'http://i.ytimg.com/vi/' . $matches[1] . '/0.jpg';
        } elseif (preg_match('#youtu.be/([^&]+)#', $pach, $matches)) {
            return 'http://i.ytimg.com/vi/' . $matches[1] . '/0.jpg';
        }
        return false;
    }

    function getVimeo($path)
    {
        $json = @json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url=' . $path));

        if (!$json) {
            return false;
        }

        $thumb = $json->thumbnail_url;

        if ($thumb) {
            return $thumb;
        }

        return false;
    }

    function OnBeforeIBlockElementAdd(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == 1) {
            if (isset($arFields['PROPERTY_VALUES'][19])) {
                $value = $arFields['PROPERTY_VALUES'][19];
                if ($video = self::getVimeo($value)) {
                    $arFields['PREVIEW_PICTURE'] = CFile::MakeFileArray($video);
                    $arFields['PROPERTY_VALUES']['REAL_PICTURE'] = $arFields['PREVIEW_PICTURE'];
                    return true;
                }
                if ($video = self::getYoutube($value)) {
                    $arFields['PREVIEW_PICTURE'] = CFile::MakeFileArray($video);
                    $arFields['PROPERTY_VALUES']['REAL_PICTURE'] = $arFields['PREVIEW_PICTURE'];
                    return true;
                }
                return false;
            }
        }

        //file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/log.txt', print_r($arFields, true));

//		file_put_contents('d:/var/www/mar.hl/www/bitrix/components/mar/player/log.txt', print_r($arFields, true));

//		if ($arFields['PROPERTY_VALUES'][94] > 0)
//		{
//			$author_id = $arFields['PROPERTY_VALUES'][94];
//			$arSelect = Array("ID");
//			$arFilter = Array("IBLOCK_ID"=>25, "ACTIVE"=>"Y", "PROPERTY_129_VALUE"=>$author_id);
//			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
//			$res_arr = $res->Fetch();
//			$arFields['PROPERTY_VALUES'][146] = $res_arr;
//
//		}
    }
}

AddEventHandler("main", "OnAfterUserUpdate", Array("OnUserUpdateClass", "OnUserUpdate"));

class OnUserUpdateClass
{
    function OnUserUpdate(&$arFields)
    {
        $CACHE_ID = SITE_ID . '|marUSER|' . $GLOBALS['USER']->GetID();
        $cache = new CPHPCache;
        $cache->Clean($CACHE_ID, '/marUSER/');

        $arSize = array('width' => 90, 'height' => 90);
        if ($arFields['PERSONAL_PHOTO']) {
            if ($arTmp = CFile::ResizeImageGet($arFields['PERSONAL_PHOTO'], $arSize, BX_RESIZE_IMAGE_EXACT, true)) {
                $arFile = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'] . $arTmp['src']);
                if (CModule::IncludeModule('forum')) {
                    $arUser = CForumUser::GetByUSER_ID($arFields['ID']);
                    if (intval($arUser['AVATAR']) > 0) {
                        $arFile['del'] = 'Y';
                        $arFile['old_file'] = $arUser['AVATAR'];
                    }
                    CForumUser::Update($arUser['ID'], array('AVATAR' => $arFile));
                }
            }
        }
    }
}

function GetCitys($country = 11)
{
    $obCache = new CPHPCache;

    $life_time = 60 * 60;

    $cache_id = 'GetCitys' . $GLOBALS['USER']->GetID();

    if ($obCache->InitCache($life_time, $cache_id, "/")) {
        return $obCache->GetVars();
    }

    if ($obCache->StartDataCache()) {
        if (!CModule::IncludeModule("iblock")) {
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
        }

        $arSelect = Array("ID", "NAME");
        $arFilter = Array("IBLOCK_ID" => 5, 'IBLOCK_SECTION_ID' => $country, 'ACTIVE' => 'Y');
        $res = CIBlockElement::GetList(Array('NAME' => 'ASC'), $arFilter, false, false, $arSelect);

        $citys = array();
        while ($ob = $res->GetNext()) {
            $citys[$ob['ID']] = $ob['NAME'];
        }

        $result = array(
            'reference_id' => array_keys($citys),
            'reference' => array_values($citys)
        );
        $obCache->EndDataCache($result);

        return $result;
    }
}

function getCityId()
{
    $cityObj = new CCity();
    $cityInfo = $cityObj->GetFullInfo();
    $name = $cityInfo['CITY_NAME']['VALUE'];

    if (!CModule::IncludeModule("iblock")) {
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }

    $res = CIBlockElement::GetList(
        false,
        array('IBLOCK_ID' => 5, 'NAME' => $name)
    );

    if ($el = $res->Fetch()) {
        return $el['ID'];
    }
    return 0;
}

function GetDefCity()
{
    if ($_POST['HEADER_SELECT_CITY_SET']) {
        $_SESSION['SESS_UF_CITY_ID'] = intval($_POST['HEADER_SELECT_CITY_SET']);
    }

    if ($_SESSION['SESS_UF_CITY_ID'] > 0) {
        return intval($_SESSION['SESS_UF_CITY_ID']);
    }

    if ($GLOBALS['USER']->IsAuthorized()) {
        $arUser = mar_getUser();
        $_SESSION['SESS_UF_CITY_ID'] = $arUser['UF_CITY'];
        return intval($_SESSION['SESS_UF_CITY_ID']);
    }

    if ($city_id = getCityId()) {
        $_SESSION['SESS_UF_CITY_ID'] = $city_id;
        return intval($_SESSION['SESS_UF_CITY_ID']);
    }

    return 398;
}

function plural_form($x, $w1, $w2, $w5)
{
    $w = array($w1, $w2, $w5);
    $d = ($p = $x % 100) % 10;

    return $w[$p == 11 || $d == 0 || ($p >= 10 && $p <= 20) || ($d >= 5 && $d <= 9) ? 2 : ($d == 1 ? 0 : 1)];
}

class getStats
{
    static function getStatsFunction($IblockId)
    {
        CModule::IncludeModule("iblock");
        $filter = array(
            'IBLOCK_ID' => $IblockId,
        );
        $sec = CIBlockElement::GetList(null, $filter);
        while ($t = $sec->GetNext()) {

            $db_props = CIBlockElement::GetProperty($IblockId, $t['ID']);
            if ($ar_props = $db_props->Fetch()) {
                $res = CIBlockElement::GetByID($ar_props['VALUE']);
                if ($ar_res = $res->GetNext())
                    echo  '<p>' . '<a href="/article/' . $ar_res["IBLOCK_SECTION_ID"] . '/" target="new" class="new_link">' . $ar_res["NAME"] . '</a>' . '</p>';
                    echo $ar_res['PREVIEW_TEXT'];
            }

        }
    }
}