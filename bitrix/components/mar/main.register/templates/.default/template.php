<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="over_scroll">


<div class="reg-container">

	<div class="content-header">
		Регистрация пользователя
	</div>
	<div class="end"></div>

	<?
	if (count($arResult["ERRORS"]) > 0):
		foreach ($arResult["ERRORS"] as $key => $error)
			if (intval($key) == 0 && $key !== 0)
				$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

		ShowError(implode("<br />", $arResult["ERRORS"])); elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
		?>
		<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		<?endif?>

	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">

		<?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP'];?>
		<div class="form-box-2">
			<span><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"] == "Y"): ?><i>*</i><? endif;?></span>
			<?$APPLICATION->IncludeComponent(
			"bitrix:system.field.edit",
			$arUserField["USER_TYPE"]["USER_TYPE_ID"],
			array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y"));?>
		</div>

		<?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_STATUS'];?>
		<div style="display: <?=$_POST['UF_GROUP'] == 14 ? 'block' : 'none'?>" class="form-box-2 SHOW_GROUP_14">
			<span><?=$arUserField["EDIT_FORM_LABEL"]?>:<i>*</i></span>
			<?$APPLICATION->IncludeComponent(
			"bitrix:system.field.edit",
			$arUserField["USER_TYPE"]["USER_TYPE_ID"],
			array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y"));?>
		</div>

		<div style="display: <?=$_POST['UF_GROUP'] == 15 ? 'block' : 'none'?>" class="form-box-2 SHOW_GROUP_15">
			<span>Пол:<i>*</i></span>
			<select name="REGISTER[PERSONAL_GENDER]">
				<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
				<option value="M"<?=$arResult["VALUES"]["PERSONAL_GENDER"] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
				<option value="F"<?=$arResult["VALUES"]["PERSONAL_GENDER"] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
			</select>
		</div>

		<?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_WED_DATE'];?>
		<div style="display: <?=$_POST['UF_GROUP'] == 15 ? 'block' : 'none'?>" class="form-box-2 SHOW_GROUP_15">
<!--            --><?//print_r($arUserField)?>
			<span><?=$arUserField["EDIT_FORM_LABEL"]?>:<i>*</i></span>
			<?$APPLICATION->IncludeComponent(
			"bitrix:system.field.edit",
			$arUserField["USER_TYPE"]["USER_TYPE_ID"],
			array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y"));?>
		</div>

		<div class="form-box-2">
			<span>Логин:<i>*</i></span>
			<input size="30" type="text" name="REGISTER[LOGIN]" value="<?=$arResult["VALUES"]['LOGIN']?>" class="input-pop"/>
		</div>

		<div class="form-box-2">
			<span>Почта:<i>*</i></span>
			<input size="30" type="text" name="REGISTER[EMAIL]" value="<?=$arResult["VALUES"]['EMAIL']?>" class="input-pop"/>
		</div>

		<div class="form-box-2">
			<span>Пароль:<i>*</i></span>
			<input size="30" class="input-pop" type="password" name="REGISTER[PASSWORD]" value="" autocomplete="off"/>
		</div>

		<div class="form-box-2">
			<span>Подтверждение пароля:<i>*</i></span>
			<input size="30" class="input-pop" type="password" name="REGISTER[CONFIRM_PASSWORD]" value="" autocomplete="off"/>
		</div>

		<div class="form-box-2">
			<span>Имя:<i>*</i></span>
			<input size="30" type="text" name="REGISTER[NAME]" value="<?=$arResult["VALUES"]['NAME']?>" class="input-pop"/>
		</div>
		<div class="form-box-2">
			<span>Фамилия:<i>*</i></span>
			<input size="30" type="text" name="REGISTER[LAST_NAME]" value="<?=$arResult["VALUES"]['LAST_NAME']?>"
			       class="input-pop"/>
		</div>

		<?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_CITY'];?>
		<div class="form-box-2">
			<span><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"] == "Y"): ?><i>*</i><? endif;?></span>
			<?$APPLICATION->IncludeComponent(
			"bitrix:system.field.edit",
			$arUserField["USER_TYPE"]["USER_TYPE_ID"],
			array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y"));?>
		</div>

		<div class="form-box-2 form-option">
			<input name="conditions" type="checkbox" value="Y"/> Я согласен с условиями регистрации
		</div>

		<div class="form-box-2 form-option">
			<div class="button-box-2">
				<input class="button" type="submit" name="register_submit_button" value="Зарегистрироваться"/>
			</div>
		</div>

	</form>

	<script type="text/javascript">
		$('[name="UF_GROUP"]').change(function () {
			$('.SHOW_GROUP_15,.SHOW_GROUP_14').hide();
			$('.SHOW_GROUP_' + $(this).val()).show();
		});
	</script>

	<?//if($USER->IsAuthorized()):?>
	<!---->
	<!--<p>--><?//echo GetMessage("MAIN_REGISTER_AUTH")?><!--</p>-->
	<!---->
	<?//else:?>
	<?//
//if (count($arResult["ERRORS"]) > 0):
//	foreach ($arResult["ERRORS"] as $key => $error)
//		if (intval($key) == 0 && $key !== 0)
//			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
//
//	ShowError(implode("<br />", $arResult["ERRORS"]));
//
//elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
//?>
	<!--<p>--><?//echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?><!--</p>-->
	<?//endif?>
	<!---->
	<!---->
	<?//endif?>
</div>

</div>