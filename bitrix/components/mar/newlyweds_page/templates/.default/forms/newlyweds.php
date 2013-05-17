<div class="content-container">
    <div class="kroski-box">
        <a href="/profile/<?= $arResult['user']['ID'] ?>/">Вернуться к профилю</a>

        <div class="end"></div>
    </div>
    <!--    <h2 class="new">Невеста:</h2>-->

    <?

    $current_user = CUser::GetById($USER->GetID())->Fetch();

    ?>
    <!--    --><?//
    //    echo "<pre>";
    //    echo print_r($current_user);
    //    echo "</pre>";
    //    ?>

    <!--    <script type="text/javascript">-->
    <!--        $(function(){-->
    <!--            if($('.input-pop').val() != ""){-->
    <!--                $('.red_col').css({-->
    <!--                   'background' : '#56A108'-->
    <!--                });-->
    <!--            }-->
    <!--        });-->
    <!--    </script>-->


    <form action="" method="post">

        <div class="form-box-2">
            <span>Имя:<i>*</i></span>
            <input size="30" type="text" name="name_Groom" value="<?= $current_user['NAME'] ?>"
                   class="input-pop enable"/>
            <!--            --><?//=$arResult['errors']['Имя невесты'][0]?>
        </div>


        <div class="form-box-2">
            <span>Фамилия:</span>
            <input size="30" type="text" name="surname_Groom" value="<?= $current_user['LAST_NAME'] ?>"
                   class="input-pop enable"/>
            <!--            --><?//=$arResult['errors']['Фамилия невесты'][0]?>
        </div>

        <div class="form-box-2">
            <span>E-mail:<i>*</i></span>
            <input size="30" class="input-pop enable" type="text" name="email_Groom"
                   value="<?= $current_user['EMAIL'] ?>" autocomplete="off"/>
            <!--            --><?//=$arResult['errors']['Email невесты'][0]?>
        </div>

        <div class="form-box-2">
            <span>Город:<i>*</i></span>
            <?=SelectBoxFromArray('town_Groom', GetCitys($current_user['PERSONAL_CITY']), 'class="select-2" onchange="$(this).closest(\'form\').trigger(\'submit\');"');?>

            <?=$arResult['errors']['Город невесты'][0]?>
        </div>


        <div class="form-box-2">
            <span>Телефон:</span>
            <input size="30" type="text" name="phone_Groom" value="<?= $current_user['PERSONAL_PHONE'] ?>"
                   class="input-pop"/>
        </div>
        <div class="form-box-2">
            <span>Скайп:</span>
            <input size="30" type="text" name="skype_Groom" value="<?= $current_user['UF_SKYPE'] ?>"
                   class="input-pop"/>
        </div>


        <h2 class="new">Жених:</h2>


        <div class="form-box-2">
            <span>Имя:<i>*</i></span>
            <input size="30" type="text" name="name_Bride" value="" class="input-pop enable"/>
            <?=$arResult['errors']['Имя жениха'][0]?>
        </div>

        <div class="form-box-2">
            <span>Фамилия:</span>
            <input size="30" type="text" name="surname_Bride" value="" class="input-pop enable"/>
            <?=$arResult['errors']['Фамилия жениха'][0]?>
        </div>

        <div class="form-box-2">
            <span>E-mail:<i>*</i></span>
            <input size="30" class="input-pop enable" type="text" name="email_Bride" value="" autocomplete="off"/>
            <?=$arResult['errors']['Email жениха'][0]?>
        </div>

        <div class="form-box-2">
            <span>Город:<i>*</i></span>

            <?=SelectBoxFromArray('town_Bride', GetCitys(), 'class="select-2" onchange="$(this).closest(\'form\').trigger(\'submit\');"');?>

            <?=$arResult['errors']['Город жениха'][0]?>
        </div>

        <div class="form-box-2">
            <span>Телефон:</span>
            <input size="30" type="text" name="phone_Bride" value="" class="input-pop"/>
        </div>
        <div class="form-box-2">
            <span>Скайп:</span>
            <input size="30" type="text" name="skype_Bride" value=""
                   class="input-pop"/>
        </div>
        <!---->
        <div style="text-align: right; margin-bottom: 60px">
            <input type="submit" class="button marg" name="submit" value="Сохранить"/>
        </div>
        <!---->
        <!--        <script type="text/javascript">-->
        <!--            $(function () {-->
        <!--                $('.enable').change(function () {-->
        <!--                    var span = $('.button');-->
        <!--                    if ($(':input[name=name_Groom]').val() != '' && $(':input[name=email_Groom]').val() != '' && $(':input[name=town_Groom]').val() != '' && $(':input[name=name_Bride]').val() !=  '' && $(':input[name=email_Bride]').val() != '' && $(':input[name=town_Bride]').val() != '') {-->
        <!--                        span.removeAttr('disabled');-->
        <!--                        span.removeClass('opac');-->
        <!--                    }-->
        <!--                });-->
        <!--            });-->
        <!--        </script>-->
    </form>
    <div class="end"></div>
</div>