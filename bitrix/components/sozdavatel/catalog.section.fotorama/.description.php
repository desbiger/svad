<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("SOZDAVATEL_FOTORAMA_NAME"),
	"DESCRIPTION" => GetMessage("SOZDAVATEL_FOTORAMA_DESCRIPTION"),
	"ICON" => "/images/fotorama.png",
	"CACHE_PATH" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "sozdavatel",
		"NAME" => GetMessage("SOZDAVATEL_NAME"),
		"SORT" => 10,
	),
);

?>