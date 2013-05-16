<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arDefaultVariableAliases404 = array();

$PAGE_NAME = '';

$SEF_URL_TEMPLATES = array(
	"profile" => "#USER_ID#/",
	"portfolio" => "#USER_ID#/portfolio/",

	"albums" => "#USER_ID#/albums/",
	'album_detal' => '#USER_ID#/albums/#ALBUM_ID#/',
	'album_new' => '#USER_ID#/albums/action/new/',
	'album_action' => '#USER_ID#/albums/#ALBUM_ID#/action/#ACTION#/',
	'album_edit_icon' => '#USER_ID#/albums/#ALBUM_ID#/icon/action/edit/',
	'album_photo' => '#USER_ID#/albums/#ALBUM_ID#/#PHOTO_ID#/',

	"portfolios" => "#USER_ID#/portfolio/",
	'portfolio_detal' => '#USER_ID#/portfolio/#PHOTO_ID#/',

	"favorite" => "#USER_ID#/favorite/",
	"infavorite" => "#USER_ID#/infavorite/",
	"work" => "#USER_ID#/work/",
	"reviews" => "#USER_ID#/reviews/"
);

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultVariableAliases404, $SEF_URL_TEMPLATES);

$arVariables = array();

$componentPage = CComponentEngine::ParseComponentPath(
	"/profile/",
	$arUrlTemplates,
	$arVariables
);

$userId = $arVariables['USER_ID'];
$rsUser = CUser::GetByID($userId);
$asUser = $rsUser->GetNext();
if(!$asUser){
	LocalRedirect('/');
	die();
}
$arUserGroup = CUser::GetUserGroup($userId);
$asUser['GROUPS'] = $arUserGroup;

$datetime = strtotime($asUser['UF_WED_DATE']);
if($datetime > time()){
    $asUser['is_married'] = false;
} else {
    $asUser['is_married'] = true;
}

if(!$asUser)
{
	LocalRedirect('/');
}

if($userId == $USER->GetID())
{
	$asUser['MODER_BY'] = 'Y';
}

if($componentPage == 'album_new')
{
	$arFilter = array(
		'IBLOCK_ID' => 1,
		'=CREATED_BY' => $asUser['ID'],
		'=SECTION_ID' => null
	);

	if($mainAlbum = CIBlockSection::GetList(Array(), $arFilter)->GetNext())
	{
		$arVariables['ALBUM_ID'] = $mainAlbum['ID'];
	}
}

$arResult["PAGE"] = $componentPage;
$arResult["VARIABLES"] = $arVariables;

if(in_array('7', $arUserGroup))
{
	$asUser['GROUP_PROF'] = 'Y';

	$menus = array(
		array('TEXT' => 'О себе', 'LINK' => '/profile/' . $userId. '/'),
		array('TEXT' => 'Портфолио', 'LINK' => '/profile/' . $userId. '/portfolio/'),
		array('TEXT' => 'Альбомы', 'LINK' => '/profile/' . $userId. '/albums/'),
		array('TEXT' => 'В избранном', 'LINK' => '/profile/' . $userId. '/infavorite/'),
		array('TEXT' => 'Занятость', 'LINK' => '/profile/' . $userId. '/work/'),
		array('TEXT' => 'Отзывы', 'LINK' => '/profile/' . $userId. '/reviews/')
	);
}
else
{
	$menus = array(
		array('TEXT' => 'О себе', 'LINK' => '/profile/' . $userId. '/'),
		array('TEXT' => 'Альбомы', 'LINK' => '/profile/' . $userId. '/albums/'),
		array('TEXT' => 'В избранном', 'LINK' => '/profile/' . $userId. '/infavorite/')
	);
}

$menuUrl = $APPLICATION->GetCurPage(false);
$menuSelect = false;

foreach($menus as $key => $menu)
{
	$pos = strpos($menuUrl, $menu['LINK']);
	if($pos === 0)
	{
		$menuSelect = $key;
	}
}
foreach($menus as $key => &$menu)
{
	if($menuSelect === $key)
	{
		$menu['SELECTED'] = true;
	}
	$GLOBALS['BX_MENU_CUSTOM']->AddItem('profile', $menu);
}
if($arFile = CFile::ResizeImageGet($asUser['PERSONAL_PHOTO'], array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_EXACT, true))
{
	$asUser['SHARED_PHOTO'] = $arFile['src'];
}
if($arFile = CFile::ResizeImageGet($asUser['PERSONAL_PHOTO'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_EXACT, true))
{
	$asUser['PERSONAL_PHOTO'] = $arFile['src'];
}
$asUser['RATING'] = like::get($asUser['ID']);

if($asUser['UF_GROUP'])
{
	$asUser['GROUP'] = CIBlockElement::GetByID($asUser['UF_GROUP'])->GetNext();
}
if($asUser['UF_CITY'])
{
	$resCity = CIBlockElement::GetByID($asUser['UF_CITY'])->GetNext();
	if($resCity['ACTIVE'] == 'Y') {
		$asUser['CITY'] = $resCity;
	}
}


if(in_array('7', $arUserGroup))
{
	if($asUser['UF_STATUS'])
	{
		$arSelect = array(
			'ID', 'NAME', 'CODE', 'PROPERTY_A_NAMES'
		);
		$asUser['STATUS'] = CIBlockElement::GetList(Array(), array('=ID' => intval($asUser['UF_STATUS'])), $arSelect)->GetNext();
	}

	$arFilter = array(
		'ACTIVE' => "Y",
		'IBLOCK_ID' => 9,
		'CREATED_BY' => $asUser['ID'],
	);
	$orService = CIBlockElement::GetList(Array(), $arFilter, false, false, array('ID', 'NAME','PROPERTY_PRICE_FROM','PROPERTY_PRICE_TO'));
	$arResult['SERVICES'] = array();
	while($arService = $orService->GetNext())
	{
		$arResult['SERVICES'][] = $arService;
	}
}
elseif(in_array('8', $arUserGroup))
{
	if($asUser['PERSONAL_GENDER'])
	{
        if($asUser['is_married']) {
            $asUser['STATUS']['NAME'] = GetMessage('GENDER_S_'.$asUser['PERSONAL_GENDER']);
        } else {
            $asUser['STATUS']['NAME'] = GetMessage('GENDER_'.$asUser['PERSONAL_GENDER']);
        }
	}
}

$arFilter = array(
	'ACTIVE' => "Y",
	'IBLOCK_ID' => 6,
	'CREATED_BY' => $USER->GetID(),
	'PROPERTY_FAV_USER_FAV' => $asUser['ID']
);
$arResult["IS_FAVORITE"] = CIBlockElement::GetList(Array(), $arFilter)->GetNext();

$arResult["USER"] = $asUser;

$tags = array(
	'#NAME#' => $asUser['NAME'],
	'#LAST_NAME#' => $asUser['LAST_NAME'],
	'#STATUS#' => $asUser['STATUS']['NAME'],
	'#CITY#' => $asUser['CITY']['NAME'],
);

CMar::$_title_tags['#PAGE#'] = 'Профиль';

if($arResult['USER']['SHARED_PHOTO'])
{
	CMar::SetSocialImage($arResult['USER']['SHARED_PHOTO']);
}

$this->IncludeComponentTemplate();

CMar::SetTitle('#NAME# #LAST_NAME# #STATUS#, #PAGE#, #CITY#', $tags);