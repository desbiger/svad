<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Баннеры в зависимости от города нижний банер",
	"DESCRIPTION" => "Выводит картинки баннеров в зависимости от текущего нижний банер",
	"ICON" => "/images/user_register.gif",
	"PATH" => array(
			"ID" => "HIT-MEDIA 1",
			"CHILD" => array(
				"ID" => "user",
				"NAME" => "Баннер нижний"
			),
		),
);
?>