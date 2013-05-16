$(document).ready(function () {
	function getModelHtml(id, name, type) {
		if(name.length == 0)
		{
			return false;
		}
		$.get("/bitrix/components/hm/models.ajax/templates/.default/ajax.php", { 'name':name, 'type':type },
			function (data) {
				$(id).append(data);
				$(id).attr('disabled', false);
			});
	}
	$('#select_model_1').change(function () {
		var select = $(this).val();
		$('#select_model_2').html('<option value="">Модельный ряд</option>').attr('disabled', true);
		$('#select_model_3').html('<option value="">Серия</option>').attr('disabled', true);
		$('#select_model_4').html('<option value="">Модель</option>').attr('disabled', true);
		getModelHtml('#select_model_2', select, 'section');
	});
	$('#select_model_2').change(function () {
		var select = $(this).val();
		$('#select_model_3').html('<option value="">Серия</option>').attr('disabled', true);
		$('#select_model_4').html('<option value="">Модель</option>').attr('disabled', true);
		getModelHtml('#select_model_3', select, 'section');
	});
	$('#select_model_3').change(function () {
		var select = $(this).val();
		$('#select_model_4').html('<option value="">Модель</option>').attr('disabled', true);
		getModelHtml('#select_model_4', select, 'element');
	});
	$('#select_model_4').change(function () {
		var select_element = $(this).val();
		var select_section = $('#select_model_3').val();
		window.location = '/catalog/models/' + select_section + '/' + select_element + '/';
	});
});