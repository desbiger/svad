<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="left-menu-container">
	<div class="content-header">
		<?=GetMessage("CT_POST_ARTICLE")?>:
	</div>
	<div class="end"></div>
	<? if(!$_GET['show']) $_GET['show'] = 'new'; ?>
	<div class="left-menu">
		<ul>
			<?$vite_end = strtotime($arResult["PROPERTIES"]['CON_VOTE_END']['VALUE']);?>
			<li><a<?=$vite_end >= time()?' class="active"':''?> href="/contest/?show=new"><span>Новые</span></a></li>
			<li><a<?=$vite_end <= time()?' class="active"':''?> href="/contest/?show=old"><span>Завершённые</span></a></li>
		</ul>
	</div>
</div>

<div class="content-right-2">
	<div class="content-container">
		<? if ($arResult["SECTION"]): ?>
		<div class="kroski-box">
				<?$vite_end = strtotime($arResult["PROPERTIES"]['CON_VOTE_END']['VALUE']);?>
				<?if($vite_end >= time()):?>
					<a href="/contest/?show=new"><?=GetMessage('CT_ARTICLE_BACK')?>Новые"</a>
				<?else:?>
					<a href="/contest/?show=old"><?=GetMessage('CT_ARTICLE_BACK')?>Завершённые"</a>
				<?endif;?>
			<div class="end"></div>
		</div>
		<? endif; ?>

		<?if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
		<div class="content-header-2"><?=$arResult["NAME"]?></div>
		<? endif;?>
		<?
			$date_begin = strtotime($arResult["PROPERTIES"]['CON_DATE_START']['VALUE']);
			$vote_begin = strtotime($arResult["PROPERTIES"]['CON_VOTE_BEGIN']['VALUE']);
			$vite_end = strtotime($arResult["PROPERTIES"]['CON_VOTE_END']['VALUE']);
			$time = time();
		?>
		<div class="content-header-2 date-small">Дата начала приема работ:
			<span style="text-transform: lowercase"><?=CIBlockFormatProperties::DateFormat(
				'j F Y',
				MakeTimeStamp($arResult["PROPERTIES"]['CON_DATE_START']['VALUE'],
					CSite::GetDateFormat()));?></span></div>
		<div class="content-header-2 date-small">Дата начала голосования:
			<span style="text-transform: lowercase"><?=CIBlockFormatProperties::DateFormat(
				'j F Y',
				MakeTimeStamp($arResult["PROPERTIES"]['CON_VOTE_BEGIN']['VALUE'],
					CSite::GetDateFormat()));?></span></div>
		<div class="content-header-2 date-small">Дата завершения голосования:
			<span style="text-transform: lowercase"><?=CIBlockFormatProperties::DateFormat(
				'j F Y',
				MakeTimeStamp($arResult["PROPERTIES"]['CON_VOTE_END']['VALUE'],
					CSite::GetDateFormat()));?></span></div>
		<?if($time >= $vite_end):?>
			<div class="content-header-2">Конкурс завершен</div>
		<?endif;?>
		<div class="content-box">
			<?if (is_array($arResult["PREVIEW_PICTURE"])): ?>
			<img style="float: left; padding: 0 10px 10px 0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>">
			<? endif?>
			<?=$arResult["DETAIL_TEXT"]?>
			<div class="end"></div>
			<?if($date_begin <= $time  && $time <= $vite_end && $USER->IsAuthorized()):?>
			<?
			if(!CModule::IncludeModule("iblock"))
			{
				ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
				return;
			}

			if($_POST && !empty($_FILES['contest-file-upload']['tmp_name']))
			{
				$images = $_FILES['contest-file-upload'];
				$caption = strip_tags($_POST['caption-contest-file-upload']);
				if(empty($caption))
				{
					$caption = strip_tags($images['name']);
				}
				$blockElement = new CIBlockElement();
				$arFields = array(
					'ACTIVE' => 'Y',
					'NAME' => $caption,
					'IBLOCK_SECTION_ID' => null,
					'IBLOCK_ID' => 13,
					'PREVIEW_PICTURE' => $images,
					'PREVIEW_TEXT' => $caption,
					'DETAIL_TEXT' => $caption,
					'CREATED_BY' => $USER->GetID(),
					'PROPERTY_VALUES' => array(
						36 => 'Y',
						38 => 'Y',
						37 =>	$images,
					)
				);

				if($id = $blockElement->Add($arFields))
				{
					$result = $DB->Query('
						INSERT
						INTO b_iblock_element_property (IBLOCK_PROPERTY_ID,IBLOCK_ELEMENT_ID,`VALUE`,VALUE_ENUM)
						VALUES(46,'.intval($arResult['ID']).','.intval($id).','.intval($id).')
					');

					if($result->AffectedRowsCount())
					{
						CMar::push('contest_add_photo', 'Ваше фото успешно загружено');
					}

					PClearComponentCacheEx(37, array(null));

					LocalRedirect($APPLICATION->GetCurPage());
					return;
				}
			}
			?>

			<p><font class="notetext"><?=CMar::pop('contest_add_photo');?></font></p>

			<form method="post" enctype="multipart/form-data">
				<div class="box-file-upload">
					<input type="file" class="file-upload" name="contest-file-upload">
					<input class="button" type="button" value="Участвовать">
					<div class="hide-file-upload">
						Название файла: <div class="text-file-upload"></div>
						<div>
							Описание:<br>
							<textarea name="caption-contest-file-upload" cols="30" rows="10"></textarea>
						</div>
						<input class="button submit-file-upload" type="submit" value="Загрузить">
					</div>
				</div>
			</form>
			<script type="text/javascript">
				$('.file-upload').change(function () {
					var fakePath = "C:\\fakepath\\";
					$('.text-file-upload').text($(this).val().replace(fakePath, ""));
					$('.hide-file-upload').show();
				});
			</script>
			<?endif;?>
		</div>

		<?if($vote_begin <= $time):?>
		<div class="content-box">
			<?
			$url = '/contest/'.$arResult['IBLOCK_SECTION_ID'].'/'.$arResult['ID'].'/';
			?>
			<?$APPLICATION->IncludeComponent("mar:photogallery.detail.list.ex", "contest", array(
				"USER" => $arResult['USER'],
				"PERMISSION" => "0",
				"IBLOCK_TYPE" => "photos",
				"IBLOCK_ID" => "13",
				"BEHAVIOUR" => "SIMPLE",
				"FID" => $arResult['PROPERTIES']['CON_ELEMENTS']['VALUE'],
				"DRAG_SORT" => "N",
				"ELEMENT_LAST_TYPE" => "",
				"ELEMENT_SORT_FIELD" => ($time >= $vite_end ? 'rating' : 'created'),
				"ELEMENT_SORT_ORDER" => ($time >= $vite_end ? 'desc' : 'asc'),
				"ELEMENT_SORT_FIELD1" => "",
				"ELEMENT_SORT_ORDER1" => "asc",
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"USE_DESC_PAGE" => "Y",
				"PAGE_ELEMENTS" => "100000",
				"PAGE_NAVIGATION_TEMPLATE" => "",
				"SECTION_URL" => $url,
				"DETAIL_URL" => $url . "?photo=#ELEMENT_ID#",
				"DETAIL_SLIDE_SHOW_URL" => $url . "?photo=#ELEMENT_ID#",
				"SEARCH_URL" => "search.php",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"SET_TITLE" => "Y",
				"USE_PERMISSIONS" => "Y",
				"GROUP_PERMISSIONS" => array(
					0 => "1",
					1 => "7",
					2 => "8",
					3 => "9",
				),
				"DATE_TIME_FORMAT" => "j F Y",
				"SET_STATUS_404" => "N",
				"PATH_TO_USER" => "/profile/#USER_ID#/",
				"NAME_TEMPLATE" => "#NOBR##LAST_NAME# #NAME##/NOBR#",
				"SHOW_LOGIN" => "Y",
				"ADDITIONAL_SIGHTS" => array(
				),
				"PICTURES_SIGHT" => "",
				"THUMBNAIL_SIZE" => "160",
				"SHOW_PAGE_NAVIGATION" => "bottom",
				"SHOW_RATING" => "Y",
				"SHOW_SHOWS" => "Y",
				"SHOW_COMMENTS" => "Y",
				"MAX_VOTE" => "1",
				"VOTE_NAMES" => array(
					0 => "1",
					1 => "",
				),
				"DISPLAY_AS_RATING" => "rating_main",
				"RATING_MAIN_TYPE" => "like",
				"RATING_MAIN_READONLY" => ($vote_begin <= $time && $time <= $vite_end ? 'N' : 'Y'),
				"USE_COMMENTS" => "Y",
				"COMMENTS_TYPE" => "forum",
				"FORUM_ID" => "40",
				"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
				"CURRENT_ELEMENT_ID" => intval($_GET['photo'])
			),
			false
		);?>
		</div>
		<?endif;?>

		<div class="content-header-2">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/shared.php",
			"EDIT_TEMPLATE" => ""
				), false);?>
			<div class="end"></div>
		</div>
	</div>
</div>