<div class="content-container">
    <div class="kroski-box">
        <a href="/profile/<?= $arResult['user']['ID'] ?>/">Вернуться к профилю</a>

        <div class="end"></div>
    </div>


    <h3 class="statii">Введите Дату свадьбы:</h3>

    <form method="post" action="/" name="regform" enctype="multipart/form-data">


        <div class="fields integer" id="main_UF_WED_DATE">
            <div class="fields datetime">


                <?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
                        "SHOW_INPUT" => "Y",
                        "FORM_NAME" => "",
                        "INPUT_NAME" => "date_fld",
//                        "INPUT_NAME_FINISH" => "date_fld_finish",
                        "INPUT_VALUE" => "",
                        "INPUT_VALUE_FINISH" => "",
                        "SHOW_TIME" => "Y",
                        "HIDE_TIMEBAR" => "Y"
                    )
                );?>

                <!--                <input type="text" name="UF_WED_DATE" value="" class="fields datetime">-->
                <!---->
                <!--                <img src="/bitrix/js/main/core/images/calendar-icon.gif" alt="Выбрать дату в календаре"-->
                <!--                     class="calendar-icon"-->
                <!--                     onclick="BX.calendar({node:this, field:'UF_WED_DATE', form: 'regform', bTime: true, currentTime: '1366630060', bHideTime: false});"-->
                <!--                     onmouseover="BX.addClass(this, 'calendar-icon-hover');"-->
                <!--                     onmouseout="BX.removeClass(this, 'calendar-icon-hover');" border="0"/>-->
            </div>
        </div>

        <input class="button marg" type="submit" value="Сохранить" name="submit">
    </form>

    <br/>

    <h3 class="statii">Возможно вам будут интересны статьи:</h3>

    <?=getStats::getStatsFunction(19);?>

</div>