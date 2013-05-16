<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<div class="login-container">
	<form name="form_auth" method="post" target="_top" action="/auth/?login=yes">

		<input type="hidden" name="AUTH_FORM" value="Y"/>
		<input type="hidden" name="TYPE" value="AUTH"/>
		<?if (strlen($arResult["BACKURL"]) > 0): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>"/>
		<? endif?>
		<?foreach ($arResult["POST"] as $key => $value): ?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>"/>
		<? endforeach?>

		<div class="form-box">
			<input name="USER_LOGIN" class="input-pop" type="text" value="" placeholder="<?=GetMessage("AUTH_LOGIN")?>" />
		</div>
		<div class="form-box">
			<input name="USER_PASSWORD" class="input-pop" type="password" value="" placeholder="<?=GetMessage("AUTH_PASSWORD")?>" />
		</div>
		<div class="form-box">
			<div class="form-option">
				<?if ($arResult["STORE_PASSWORD"] == "Y"): ?>
				<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/>Запомнить меня
				<? endif?>
				<?if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
				<span><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">Забыли пароль?</a></span>
				<? endif?>
			</div>
			<div class="button-box">
				<input name="Login" class="button" type="submit" value="<?=GetMessage("AUTH_AUTHORIZE")?>"/>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"]) > 0): ?>
	try {
		document.form_auth.USER_PASSWORD.focus();
	} catch (e) {
	}
		<? else: ?>
	try {
		document.form_auth.USER_LOGIN.focus();
	} catch (e) {
	}
		<?endif?>
</script>
