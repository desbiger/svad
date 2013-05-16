<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arResult = array();
$town = GetDefCity();
//$town_link ='';

CModule::IncludeModule('iblock');

$filter = array(
    'IBLOCK_ID' => 15,
    'ACTIVE' => 'Y',
    'PROPERTY_TOWN' => $town
);
$temp = CIblockElement::GetList(
    null,
    $filter
);

$count = 1;
while ($el = $temp->Fetch()) {
    $item = $el;
    $db_props = CIBlockElement::GetProperty(15, $item[ID], "sort", "asc", array());
    $PROPS = array();
    while ($ar_props = $db_props->Fetch()) {
        $PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
//        echo $PROPS[town_link], '<br>';
        $arTownLink[$count] = $PROPS[town_link];
    }

    $item['PREVIEW_PICTURE'] = Cfile::GetPath($item['PREVIEW_PICTURE']);
    $arTown[$count] = $item;
    $count++;
}
//echo $count;
$rand = rand(1, $count - 1);
//shuffle($array);
$arResult[town] = $arTown[$rand];
$arResult[townLink] = $arTownLink[$rand];


$this->IncludeComponentTemplate();


?>