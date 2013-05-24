<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?= ShowError($arResult["strProfileError"]); ?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
    echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<form id="profile_edit" method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>?"
      enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?= LANG ?>"/>
    <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
    <table>
        <thead>
        <td colspan="2">
            <?=GetMessage("USER_PERSONAL_INFO")?>
        </td>
        </thead>

        <?if ($arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP']['VALUE'] == 16): ?>
            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP'] ?>
            <tr>
                <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"] == "Y"): ?><span
                        class="starrequired">*</span><? endif;?>:
                </td>
                <td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
                </td>
            </tr>

            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_STATUS'] ?>
            <tr style="display: <?= $_POST['UF_GROUP'] == 14 ? 'table-row' : 'none' ?>" class="SHOW_GROUP_14">
                <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?>*:
                </td>
                <td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
                </td>
            </tr>
            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_WED_DATE'] ?>
            <tr style="display: <?= $_POST['UF_GROUP'] == 15 ? 'table-row' : 'none' ?>" class="SHOW_GROUP_15">
                <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?>*:
                </td>
                <td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
                </td>
            </tr>
        <? endif?>

        <tr>
            <td class="lable"><?=GetMessage('LOGIN')?></td>
            <td>
                <input type="text" name="LOGIN" maxlength="50" value="<?= $arResult["arUser"]["LOGIN"] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('NAME')?></td>
            <td>
                <input type="text" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('LAST_NAME')?></td>
            <td>
                <input type="text" name="LAST_NAME" maxlength="50" value="<?= $arResult["arUser"]["LAST_NAME"] ?>"/>
            </td>
        </tr>
        <tr style="display: <?= $_POST['UF_GROUP'] == 15 ? 'table-row' : 'none' ?>" class="SHOW_GROUP_15">
            <td class="lable"><?=GetMessage('USER_GENDER')?></td>
            <td>
                <select name="PERSONAL_GENDER">
                    <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                    <option
                        value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                    <option
                        value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('NEW_PASSWORD_REQ')?></td>
            <td>
                <input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off"
                       class="bx-auth-input"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></td>
            <td>
                <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('EMAIL')?><span class="starrequired">*</span></td>
            <td>
                <input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"] ?>"/>
            </td>
        </tr>
        <?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_CITY']?>
        <tr>
            <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"] == "Y"): ?><span
                    class="starrequired">*</span><? endif;?>:
            </td>
            <td>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.field.edit",
                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
            </td>
        </tr>
        <?if ($arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP']['VALUE'] == 15): ?>
            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_WED_DATE'] ?>
            <tr>
                <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"] == "Y"): ?><span
                        class="starrequired">*</span><? endif;?>:
                </td>
                <td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
                </td>
            </tr>
        <? endif?>

        <thead>
        <td colspan="2">
            <?=GetMessage("USER_CONTACT_DATA")?>
        </td>
        </thead>

        <tr>
            <td class="lable"><?=GetMessage('USER_PHONE')?></td>
            <td>
                <input type="text" name="PERSONAL_PHONE" maxlength="255"
                       value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('USER_MOBILE')?></td>
            <td>
                <input type="text" name="PERSONAL_MOBILE" maxlength="255"
                       value="<?= $arResult["arUser"]["PERSONAL_MOBILE"] ?>"/>
            </td>
        </tr>
        <?$arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_SKYPE']?>
        <tr>
            <td class="lable"><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"] == "Y"): ?><span
                    class="starrequired">*</span><? endif;?>:
            </td>
            <td>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.field.edit",
                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('USER_ICQ')?></td>
            <td>
                <input type="text" name="PERSONAL_ICQ" maxlength="255"
                       value="<?= $arResult["arUser"]["PERSONAL_ICQ"] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('USER_WWW')?></td>
            <td>
                <input type="text" name="PERSONAL_WWW" maxlength="255"
                       value="<?= $arResult["arUser"]["PERSONAL_WWW"] ?>"/>
            </td>
        </tr>

        <thead>
        <td colspan="2">
            <?=GetMessage("USER_ADDITION_INFO")?>
        </td>
        </thead>

        <tr>
            <td class="lable"><?=GetMessage('USER_PHOTO')?></td>
            <td>
                <?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
                <?
                if (strlen($arResult["arUser"]["PERSONAL_PHOTO"]) > 0) {
                    ?>
                    <br/>
                    <?= $arResult["arUser"]["PERSONAL_PHOTO_HTML"] ?>
                <?
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="lable"><?=GetMessage('USER_NOTES')?></td>
            <td>
                <textarea cols="60" rows="8" name="PERSONAL_NOTES"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></textarea>
            </td>
        </tr>
    </table>
    <input class="button right" type="submit" name="save"
           value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
</form>

<script type="text/javascript">
    $('[name="UF_GROUP"]').change(function () {
        $('.SHOW_GROUP_15,.SHOW_GROUP_14').hide();
        $('.SHOW_GROUP_' + $(this).val()).show();
    });
</script>