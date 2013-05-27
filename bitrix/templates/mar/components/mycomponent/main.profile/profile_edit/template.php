<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?= ShowError($arResult["strProfileError"]); ?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
    echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<?$APPLICATION->SetTitle("Дата свадьбы");?>
<form id="profile_edit" method="post" name="form1" action=""
      enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?= LANG ?>"/>
    <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
    <table>
            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP']?>

        <tr style="display: none">
        <td>
            <input id="UF_GROUP_15" type="radio" checked="checked" name="UF_GROUP" value="15">
            <label for="UF_GROUP_15"></label>

            <br>
        </td>
        </tr>


            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_WED_DATE'] ?>
            <tr style="display: <?= $_POST['UF_GROUP'] == 15 ? 'table-row' : 'block' ?>" class="SHOW_GROUP_15">

                <td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
                </td>
            </tr>



        <script type="text/javascript">
            $('[name="UF_GROUP"]').change(function () {
                $('.SHOW_GROUP_15,.SHOW_GROUP_14').hide();
                $('.SHOW_GROUP_' + $(this).val()).show();
            });
        </script>





        <tr style="display: none">
            <td class="lable"><?=GetMessage('LOGIN')?></td>
            <td>
                <input type="text" name="LOGIN" maxlength="50" value="<?= $arResult["arUser"]["LOGIN"] ?>"/>
            </td>
        </tr>












        <tr style="display: <?= $_POST['UF_GROUP'] == 15 ? 'table-row' : 'none' ?>" class="SHOW_GROUP_15">
            <td class="lable" style="display: none"><?=GetMessage('USER_GENDER')?></td>
            <td style="display: none">
                <select name="PERSONAL_GENDER">
                    <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                    <option
                        value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                    <option
                        value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                </select>
            </td>
        </tr>

        <tr style="display: none">
            <td class="lable"><?=GetMessage('EMAIL')?><span class="starrequired">*</span></td>
            <td>
                <input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"] ?>"/>
            </td>
        </tr>



        <?if ($arResult["USER_PROPERTIES"]["DATA"]['UF_GROUP']['VALUE'] == 15): ?>
            <? $arUserField = $arResult["USER_PROPERTIES"]["DATA"]['UF_WED_DATE'] ?>
<!--            <tr>-->
<!--                <td class="lable">--><?//=$arUserField["EDIT_FORM_LABEL"]?><!----><?//if ($arUserField["MANDATORY"] == "Y"): ?><!--<span-->
<!--                        class="starrequired">*</span>--><?// endif;?><!--:-->
<!--                </td>-->
<!--                <td>-->
<!--                    --><?//$APPLICATION->IncludeComponent(
//                        "bitrix:system.field.edit",
//                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
//                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS" => "Y"));?>
<!--                </td>-->
<!--            </tr>-->
        <? endif?>


    </table>
    <input class="button marg1" type="submit" name="save"
           value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
</form>

