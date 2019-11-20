<?php
session_start();
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $mois[date("n")];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Prescription(s) du mois</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_consultation.jpg) ;">
		<?php include 'verification_menu_sante.php'; ?>
		<div class="row">
			<h3 class="center #0d47a1 col s12" style="color: white">Prescription(s) du </h3>
			<div class="row">
			<div class="col s3 offset-s5 white input-field">
				<input type="date" name="date_cons" id="date_cons" value="<?php echo date("Y-m-d");?>" required>
				<label  for="date_cons">Date prescription</label>
			</div>
		</div>
			<div class="col s12   ">
				<table class="bordered striped highlight centered ">
					<thead>
						<tr style="color: #0d47a1;">
							<th>Patient</th>
							<th>Date et lieu de naissance</th>
							<th>Prescription</th>
							<th>Heure prescription</th>
							<th>Etat</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		
	</body>
	<style type="text/css">
		table
		{
			background: white;
		}
		
		td
		{
			font: 14pt "times new roman";
			
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			var jour = $('input').val();
			$.ajax({
				type:'POST',
				url:'l_prescription_ajax.php',
				data:'jour='+jour,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			$('input').change(function () {
				jour=$('input').val();
				$.ajax({
				type:'POST',
				url:'l_prescription_ajax.php',
				data:'jour='+jour,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			})
			$('.datepicker').datepicker({
			autoClose: true,
			yearRange:[2017,2020],
			showClearBtn: true,
			i18n:{
				nextMonth: 'Mois suivant',
				previousMonth: 'Mois précédent',
				labelMonthSelect: 'Selectionner le mois',
				labelYearSelect: 'Selectionner une année',
				months: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
				monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
				weekdays: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
				weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
				weekdaysAbbrev: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
				today: 'Aujourd\'hui',
				clear: 'Réinitialiser',
				cancel: 'Annuler',
				done: 'OK'
					
				},
				format: 'yyyy-mm-dd'
			});
			
			$('.tooltipped').tooltip();
		});
	</script>
	<style type="text/css">

		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 0;
			margin-top: 25px;
		}
		@media print
		{
			.btn{
				display: none;
			}
			nav{
				display: none;
			}
			div
			{
			font: 12pt "times new roman";
			}
			select{
				border-color: transparent
			}
		}
	</style>
</html>