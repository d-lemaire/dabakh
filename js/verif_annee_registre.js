$(document).ready(function () {
	$('#annee_registre').blur(function () {
		$.post(
			'verif_annee_registre.php'
			);
	});
});