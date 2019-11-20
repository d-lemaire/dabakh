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
$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),' ',monthname(patient.date_naissance),' ',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, patient.telephone, patient.sexe, patient.situation_matrimoniale
FROM consultation_domicile, patient
WHERE patient.id_patient=consultation_domicile.id_patient AND consultation_domicile.id_consultation=?");
$reponse->execute(array($_GET['id']));
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rapport d’assistance</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>choix_logement.jpg) ;">
		<?php
		include 'verification_menu_sante.php';
		?>
		<form method="POST" action="e_rapport_assis_trmnt.php">
			
		
		<input type="number" hidden="" name="id" value="<?= $_GET['id'] ?>">
		<div class="container white">
		<div class="row">
			<h3 class="center col s12 black-text" >Rapport d’assistance et de surveillance du patient à l’hôpital et/ou à domicile</h3>
		</div>
			<div class="row">
				<div class="col s3 m3 offset-m1 input-field">
					<input type="text" value="<?php echo date('Y').'-'.date('m').'-'.date('d') ?>"  name="date_rapport" class=datepicker id="date_rapport" required>
					<label for="date_rapport">Date d'enregistrement</label>
				</div>
			</div>
			<div class="row">
				<h5 class="col s12 m12 center">Rapport sur le patient</h5>
				<div class="input-field col s12 m8 offset-m1">
					<textarea id="r_patient" name="r_patient" class="materialize-textarea"></textarea>
					<label for="r_patient">Rapport sur le patient</label>
				</div>
			</div>
			<div class="row">
				<h5 class="col s12 m12 center">Rapport sur la famille</h5>
				<div class="input-field col s12 m8 offset-m1">
					<textarea id="r_famille" name="r_famille" class="materialize-textarea"></textarea>
					<label for="r_famille">Rapport sur la famille</label>
				</div>
			</div>
			<div class="row">
				<h5 class="col s12 m12 center">Rapport sur le personnel hospitalier (si c'est à l'hôpital)</h5>
				<div class="input-field col s12 m8 offset-m1">
					<textarea id="r_personnel" name="r_personnel" class="materialize-textarea"></textarea>
					<label for="r_personnel">Rapport sur le personnel hospitalier (si c'est à l'hôpital)</label>
				</div>
				<div class="row">
					<h5 class="col s12 m12 center"><b>Conclusion</b></h5>
					<div class="input-field col s12 m8 offset-m1">
						<textarea id="conclusion" name="conclusion" class="materialize-textarea"></textarea>
						<label for="conclusion">Conclusion</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m2 offset-m8 input-field">
					<input class="btn" type="submit" name="enregistrer" value="Enregistrer" >
				</div>
			</div>
		</div>
		</form>
	</body>
	<style type="text/css">
		body
		{
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		}
		table
		{
			background: white;
			font: 12pt "times new roman";
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.datepicker').datepicker({
		autoClose: true,
		yearRange:[2019,2022],
		showClearBtn: true,
		i18n:{
			nextMonth: 'Mois suivant',
			previousMonth: 'Mois précédent',
			labelMonthSelect: 'Selectionner le mois',
			labelYearSelect: 'Selectionner une année',
			months: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
			monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Dec' ],
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
			button{
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
			a, .btn{
				display: none;
			}
		}
	</style>
</html>