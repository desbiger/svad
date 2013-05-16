<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Баннеры в зависимости от города",
	"DESCRIPTION" => "Выводит картинки баннеров в зависимости от текущего города",
	"ICON" => "/images/user_register.gif",
	"PATH" => array(
			"ID" => "HIT-MEDIA",
			"CHILD" => array(
				"ID" => "user",
				"NAME" => "Баннеры"
			),
		),
);
?>