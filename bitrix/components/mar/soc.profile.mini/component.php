<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

$arResult['user'] = mar_getUser();

$arResult['COUNT_TO'] = CIBlockElement::GetList(array(), array(
	'ACTIVE' => 'Y',
	'NAME' => 'TO',
	'IBLOCK_ID' => 8,
	'PROPERTY_US_ADDRESSEE' => $arResult['user']['ID']
), array());

//if ($this->StartResultCache()) {
	$this->IncludeComponentTemplate();
//}

