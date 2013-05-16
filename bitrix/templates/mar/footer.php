<div class="end"></div>
<br/>

<div class="baner">

    <?$APPLICATION->IncludeComponent(
        "mar:banners.generalPagebottom",
        "",
        Array(
            "TOWN_ID" => ""
        )
    );?>

</div>

</div>
<div class="footer-container gradient">
    <div class="footer-container-2">
        <div class="footer-container-3">
            <div class="container">
                <a class="footer-logo" href="/">&nbsp;</a>

                <div class="footer-info">
                    <span>&copy; 2013 Свадебный портал “Клуб новобрачных”<br><h1>18+</h1></span>
                </div>
                <div class="footer-menu">
                    <ul>
                        <li><a href="/page/project.php">О проекте</a></li>
                        <li><a href="/page/advertisers.php">Рекламодателям</a></li>
                        <li><a href="/page/contacts.php">Контакты</a></li>
                    </ul>
                </div>
                <?if ($APPLICATION->GetCurPage() == '/'): ?>
                <div class="footer-shared">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/shared.php",
                    "EDIT_TEMPLATE" => ""
                ), false);?>
                </div>
                <? endif;?>
                <div class="footerCounters">
                    <!--LiveInternet counter-->
                    <script type="text/javascript">
                    new Image().src = "//counter.yadro.ru/hit?r" +
                            escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
                            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                                    screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
                            ";" + Math.random();</script>
                    <a href="http://www.liveinternet.ru/click"
                       target="_blank"><img src="//counter.yadro.ru/logo?45.18"
                                            title="LiveInternet"
                                            alt="" border="0" width="31" height="31"/></a><!--/LiveInternet-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grayCap"></div>

<div class="popapSocNetWork">
    <div class="gradient float-pop">
        <div class="gradient-2">
            <div class="reg-container">
                <div class="content-header">
                    <?=GetMessage("MENU_MAIN_IN_SOC")?>
                </div>
                <div class="end"></div>
                <div class="socseti">
                    <ul>
                        <li><a class="soc-7" target="_blank" href="http://www.odnoklassniki.ru/group/54107240726528">
                            &nbsp;</a></li>
                        <li><a class="soc-2" target="_blank" href="http://vk.com/newlywedsclub">&nbsp;</a></li>
                        <li><a class="soc-3" target="_blank"
                               href="http://www.facebook.com/pages/%D0%9A%D0%BB%D1%83%D0%B1-%D0%BD%D0%BE%D0%B2%D0%BE%D0%B1%D1%80%D0%B0%D1%87%D0%BD%D1%8B%D1%85/530183330326832">
                            &nbsp;</a></li>
                        <li><a class="soc-1" target="_blank" href="https://twitter.com/newlywedsclubb ">&nbsp;</a></li>
                    </ul>
                    <div class="end"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="end"></div>
</div>

<script type="text/javascript">
    $('.we-social-networks').click(function () {
        $('.popapSocNetWork, .grayCap').fadeIn('fast');
        $('.grayCap').click(function () {
            $('.popapSocNetWork, .grayCap').fadeOut('fast');
        });
    });
</script>

<div class="popapAuthSoc">
    <div class="gradient float-pop">
        <div class="gradient-2">
            <div class="reg-container">
                <?
                $arResult["AUTH_SERVICES"] = false;
                $arResult["CURRENT_SERVICE"] = false;

                $arResult["AUTH_URL"] = $APPLICATION->GetCurPageParam("login=yes");

                $arVarExcl = array("USER_LOGIN" => 1, "USER_PASSWORD" => 1, "backurl" => 1, "auth_service_id" => 1);
                $arResult["POST"] = array();
                foreach ($_POST as $vname => $vvalue) {
                    if (!array_key_exists($vname, $arVarExcl) && !is_array($vvalue))
                        $arResult["POST"][htmlspecialcharsbx($vname)] = htmlspecialcharsbx($vvalue);
                }

                if (!$USER->IsAuthorized() && CModule::IncludeModule("socialservices")) {
                    $oAuthManager = new CSocServAuthManager();
                    $arServices = $oAuthManager->GetActiveAuthServices($arResult);

                    if (!empty($arServices)) {
                        $arResult["AUTH_SERVICES"] = $arServices;
                        if (isset($_REQUEST["auth_service_id"]) && $_REQUEST["auth_service_id"] <> '' && isset($arResult["AUTH_SERVICES"][$_REQUEST["auth_service_id"]])) {
                            $arResult["CURRENT_SERVICE"] = $_REQUEST["auth_service_id"];
                            if (isset($_REQUEST["auth_service_error"]) && $_REQUEST["auth_service_error"] <> '') {
                                $arResult['ERROR_MESSAGE'] = $oAuthManager->GetError($arResult["CURRENT_SERVICE"], $_REQUEST["auth_service_error"]);
                            } elseif (!$oAuthManager->Authorize($_REQUEST["auth_service_id"])) {
                                $ex = $APPLICATION->GetException();
                                if ($ex)
                                    $arResult['ERROR_MESSAGE'] = $ex->GetString();
                            }
                        }
                    }
                }

//					var_dump($arResult['ERROR_MESSAGE']);

                $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                    array(
                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                        "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
                        "AUTH_URL" => $arResult["AUTH_URL"],
                        "POST" => $arResult["POST"],
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );
                ?>


            </div>
        </div>
    </div>
    <div class="end"></div>
</div>

<script type="text/javascript">
    $('.popapAuthSocShow').click(function () {
        $('.popapAuthSoc, .grayCap').fadeIn('fast');
        $('.grayCap').click(function () {
            $('.popapAuthSoc, .grayCap').fadeOut('fast');
            return false;
        });
        return false;
    });
</script>

<div class="popapRegister">
    <div class="gradient float-pop">
        <div class="gradient-2">

            <?$APPLICATION->IncludeComponent("mar:main.register", ".default", array(
                "SHOW_FIELDS" => array(
                    0 => "PERSONAL_GENDER"
                ),
                "REQUIRED_FIELDS" => array(),
                "AUTH" => "Y",
                "USE_BACKURL" => "Y",
                "SUCCESS_PAGE" => "",
                "SET_TITLE" => "N",
                "USER_PROPERTY" => array(
                    0 => "UF_GROUP",
                    1 => "UF_STATUS",
                    2 => "UF_CITY",
                    3 => "UF_WED_DATE"
                ),
                "USER_PROPERTY_NAME" => ""
            ),
            null
        );?>

        </div>
    </div>
    <div class="end"></div>
</div>

<? if ($_POST['register_submit_button'] && !$USER->IsAuthorized()): ?>
<script type="text/javascript">
    $('.popapRegister, .grayCap').fadeIn('fast');
    $('.grayCap').click(function () {
        $('.popapRegister, .grayCap').fadeOut('fast');
    });
</script>
<? endif; ?>

<script type="text/javascript">
    $('.popapRegShow').click(function () {
        $('.popapRegister, .grayCap').fadeIn('fast');
        $('.grayCap').click(function () {
            $('.popapRegister, .grayCap').fadeOut('fast');
            return false;
        });
        return false;
    });
</script>

<div class="popapEnter">
    <div class="gradient float-pop">
        <div class="gradient-2">
            <?    $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "layout", Array(), null, array());    ?>
        </div>
    </div>
    <div class="end"></div>
</div>

<script type="text/javascript">
    $('.popapEnterShow').click(function () {
        $('.popapEnter, .grayCap').fadeIn('fast');
        $('.grayCap').click(function () {
            $('.popapEnter, .grayCap').fadeOut('fast');
        });
    });
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter19690048 = new Ya.Metrika({id:19690048,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="//mc.yandex.ru/watch/19690048" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>