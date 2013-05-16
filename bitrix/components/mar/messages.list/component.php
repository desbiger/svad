<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$BLOCK_ID = 8;

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

$arDefaultVariableAliases404 = array();

$SEF_URL_TEMPLATES = array(
	"new" => '',
	"action" => "#ACTION#/"
);

$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultVariableAliases404, $SEF_URL_TEMPLATES);
$arVariables = array();
$componentPage = CComponentEngine::ParseComponentPath(
	"/messages/",
	$arUrlTemplates,
	$arVariables
);

$user = mar_getUser();

if(!$user['ID'])
{
	return;
}

$arParams['PERMISSION'] = 'W';

if($_GET['delete'])
{
	$idElement = $_GET['delete'];
	$orElement = CIBlockElement::GetByID($idElement)->GetNextElement();
	$arElement = $orElement->GetFields();
	$author = $orElement->GetProperty(29);
	$author = $author['VALUE'];

	$blockElement = new CIBlockElement();
	if($author != $user['ID'] && $arElement['ACTIVE'] == 'Y')
	{
		$blockElement->Update($idElement, array('ACTIVE' => 'N'));
	}
	else
	{
		$blockElement->Delete($idElement);
	}
}

$arResult['COUNT_FROM'] = CIBlockElement::GetList(array(), array(
	'ACTIVE' => 'Y',
	'IBLOCK_ID' => 8,
	'CREATED_BY' => $user['ID'],

	'PROPERTY_US_AUTHOR' => $user['ID']
), array());
$arResult['COUNT_TO'] = CIBlockElement::GetList(array(), array(
	'ACTIVE' => 'Y',
	'IBLOCK_ID' => 8,
	'CREATED_BY' => $user['ID'],

	'PROPERTY_US_ADDRESSEE' => $user['ID']
), array());
$arResult['COUNT_HISTORY'] = CIBlockElement::GetList(array(), array(
	'ACTIVE' => 'N',
	'IBLOCK_ID' => 8,
	'CREATED_BY' => $user['ID'],

	'PROPERTY_US_ADDRESSEE' => $user['ID']
), array());

$arResult['STATUS'] = array(
	array(
		'CODE' => 'to',
		'NAME' => GetMessage('STATUS_TO'),
		'COUNT' => $arResult['COUNT_TO'],
	),
	array(
		'CODE' => 'from',
		'NAME' => GetMessage('STATUS_FROM'),
		'COUNT' => $arResult['COUNT_FROM'],
	),
	array(
		'CODE' => 'history',
		'NAME' => GetMessage('STATUS_HISTORY'),
		'COUNT' => $arResult['COUNT_HISTORY'],
	)
);

$filter = Array
(
	"ACTIVE" => "Y",
	'IBLOCK_ID' => 8,
	'CREATED_BY' => $user['ID']
);

$select = array(
	'PREVIEW_TEXT',
	'PROPERTY_US_ADDRESSEE',
	'PROPERTY_US_AUTHOR'
);

switch ($arVariables['ACTION'])
{
	default:
	case 'to':
		$arResult['STATUS'][0]['SELECT'] = true;
		$filter['PROPERTY_US_ADDRESSEE'] = $user['ID'];
		break;
	case 'from':
		$arResult['STATUS'][1]['SELECT'] = true;
		$filter['PROPERTY_US_AUTHOR'] = $user['ID'];
		break;
	case 'history':
		$arResult['STATUS'][2]['SELECT'] = true;
		$filter['ACTIVE'] = 'N';
		$filter['PROPERTY_US_ADDRESSEE'] = $user['ID'];
		break;
}

$orMessages = CIBlockElement::GetList(array('ID'=>'DESC'), $filter, false, false, $select);
$orMessages->NavStart(10);

$arResult['itemsCount'] = $rsUsers->NavRecordCount;
$arResult['items'] = array();

while($arMessages = $orMessages->GetNext())
{
	$userProp = 'PROPERTY_US_AUTHOR_VALUE';
	if($arVariables['ACTION'] == 'from')
	{
		$userProp = 'PROPERTY_US_ADDRESSEE_VALUE';
	}

	$arElement = CUser::GetByID($arMessages[$userProp])->Fetch();

    $datetime = strtotime($arElement['UF_WED_DATE']);
    if($datetime > time()){
        $arElement['is_married'] = false;
    } else {
        $arElement['is_married'] = true;
    }

	if($arElement['UF_CITY'])
	{
		$arElement['UF_CITY'] = CIBlockElement::GetByID($arElement['UF_CITY'])->GetNext();
	}

	$arUserGroup = CUser::GetUserGroup($arElement['ID']);
	if(in_array('7', $arUserGroup))
	{
		if($arElement['UF_STATUS'])
		{
			$arElement['STATUS'] = CIBlockElement::GetByID($arElement['UF_STATUS'])->GetNext();
		}
	}
	elseif(in_array('8', $arUserGroup))
	{
		if($arElement['PERSONAL_GENDER'])
		{
            if($arElement['is_married']) {
                $arElement['STATUS']['NAME'] = GetMessage('GENDER_S_'.$arElement['PERSONAL_GENDER']);
            } else {
                $arElement['STATUS']['NAME'] = GetMessage('GENDER_'.$arElement['PERSONAL_GENDER']);
            }
		}
	}

	if($arFile = CFile::ResizeImageGet($arElement['PERSONAL_PHOTO'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_EXACT, true))
	{
		$arElement['PERSONAL_PHOTO'] = $arFile['src'];
	}
	$arMessages['USER'] = $arElement;

	$arResult['items'][] = $arMessages;
}

$arResult['navigation'] = $orMessages->GetNavPrint(
	GetMessage("PAGES"),
	false,
	"text",
	'/bitrix/components/mar/catalog.list/templates/.default/pagenavigation.php'
);

/*
$rsUsers = CUser::GetList(array('ID'=>'DESC'), $filter);
$is_filtered = $rsUsers->is_filtered;
$rsUsers->NavStart(10);

$arResult['itemsCount'] = $rsUsers->NavRecordCount;
$arResult['items'] = array();

while($arUser = $rsUsers->Fetch())
{
	if($arFile = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width'=>62, 'height'=>62), BX_RESIZE_IMAGE_PROPORTIONAL, true))
	{
		$arUser['PERSONAL_PHOTO'] = $arFile['src'];
	}
	$arResult['items'][] = $arUser;
}

$arResult['navigation'] = $rsUsers->GetNavPrint(
	GetMessage("PAGES"),
	false,
	"text",
	'/bitrix/components/mar/catalog.list/templates/.default/pagenavigation.php'
);*/

$this->IncludeComponentTemplate();