<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>


<? //if(count($arResult['errors']) > 0):?>
<!--    <pre>--><?//print_r($arResult['errors'])?><!--</pre>-->
<? //endif?>
<?
$pages = array(
    '18' => 'newlyweds.php', //Новобрачные
    '19' => 'wedding_date.php', //Дата свадьбы
    '20' => 'registry_office.php', //ЗАГС
    '21' => 'glans.php', //Венчание
    '22' => 'wedding_rings.php', //Обручальные кольца
    '23' => 'celebrations.php', //Организация торжества
    '24' => 'groom.php', //Жениху
    '25' => 'bride.php', //Невесте
    '26' => 'choreographer.php', //Хореограф
    '27' => 'accessories.php', //Аксессуары
    '28' => 'guest_list.php', //Список гостей
    '29' => 'places_walks.php', //Места прогулок
//    '30' => '',//
    '31' => 'redemption_bride.php', //Выкуп невесты
    '32' => 'plan_day.php', //План свабедного дня
    '33' => 'honeymoon.php' //Свадебное путешествие
)
?>


<div class="left-menu-container">
    <div class="content-header">
        Подготовка к свадьбе:
    </div>
    <div class="end"></div>
    <div class="left-menu">
        <ul>
            <li><a href="/test.php?page_id=18"><span>Новобрачные</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=19"><span>Дата свадьбы</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=20"><span>ЗАГС</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=21"><span>Венчание</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=22"><span>Обручальные кольца</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=23"><span>Организация торжества</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=24"><span>Жениху</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=25"><span>Невесте</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=26"><span>Хореограф</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=27"><span>Аксессуары</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=28"><span>Список гостей</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=29"><span>Места прогулок</span></a>
                <b class="red_col"></b>
            </li>
            <!--            <li><a href="/test.php?page_id=30"><span>Свадебный торт</span></a></li>-->
            <!--            <li><a href="#"><span>Мальчишник/Девичник</span></a></li>-->
            <li><a href="/test.php?page_id=31"><span>Выкуп невесты</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=32"><span>План свабедного дня</span></a>
                <b class="red_col"></b>
            </li>
            <li><a href="/test.php?page_id=33"><span>Свадебное путешествие</span></a>
                <b class="red_col"></b>
            </li>
        </ul>
    </div>
</div>
<div class="content-right-2">
    <?
    if ($_REQUEST['page_id']) {

        include_once('forms/' . $pages[$_REQUEST['page_id']]);
    }
    ?>
</div>

<div class="end"></div>
