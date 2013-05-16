<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
include_once("classes/myvalidation.php");

$arResult = array();

CModule::IncludeModule('iblock');


$valid = new myValidation();

if ($_POST) {

    $arResult['errors'] = $valid->check($_POST['name_Groom'], array('noEmpty'), 'Имя невесты')->errors;
//    $arResult['errors'] = $valid->check($_POST['surname_Groom'], array('noEmpty'), 'Фамилия невесты')->errors;
    $arResult['errors'] = $valid->check($_POST['email_Groom'], array('email', 'noEmpty'), 'Email невесты')->errors;
    $arResult['errors'] = $valid->check($_POST['town_Groom'], array('noEmpty'), 'Город невесты')->errors;
    $arResult['errors'] = $valid->check($_POST['name_Bride'], array('noEmpty'), 'Имя жениха')->errors;
//    $arResult['errors'] = $valid->check($_POST['surname_Bride'], array('noEmpty'), 'Фамилия жениха')->errors;
    $arResult['errors'] = $valid->check($_POST['email_Bride'], array('email', 'noEmpty'), 'Email жениха')->errors;
    $arResult['errors'] = $valid->check($_POST['town_Bride'], array('noEmpty'), 'Город жениха')->errors;

    if ($valid->result) {
        $PROP = array(
            'name_Groom' => $_POST['name_Groom'],
            'surname_Groom' => $_POST['surname_Groom'],
            'email_Groom' => $_POST['email_Groom'],
            'town_Groom' => $_POST['town_Groom'],
            'name_Bride' => $_POST['name_Bride'],
            'surname_Bride' => $_POST['surname_Bride'],
            'email_Bride' => $_POST['email_Bride'],
            'town_Bride' => $_POST['town_Bride'],
            'phone_Groom' => $_POST['phone_Groom'],
            'skype_Groom' => $_POST['skype_Groom'],
            'phone_Bride' => $_POST['phone_Bride'],
            'skype_Bride' => $_POST['skype_Bride']
        );

        $arLoadProductArray = Array(
            "IBLOCK_ID" => 18,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => "Новобрачные",
            "ACTIVE" => "Y"
        );
        $el = new CIBlockElement;


        if ($arResult = $el->Add($arLoadProductArray))
            LocalRedirect('/test.php?page_id=18');

        else
            echo "Error: " . $el->LAST_ERROR;
    }


}

$arResult['user'] = mar_getUser();

$filter = array(
    'IBLOCK_ID' => 18,
    'ACTIVE' => 'Y',
);
$temp = CIblockElement::GetList(
    null,
    $filter
);


//$date = array(
//    'IBLOCK_ID' => 19,
//    'ACTIVE' => 'Y',
//);
//
//$temp = CIblockElement::GetList(
//    null,
//    $date
//);
//
//
//
//    $PROP = array(
//        'date_link' => $PROP
//    );

$this->IncludeComponentTemplate();

?>