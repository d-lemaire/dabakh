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
$reponse=$db->prepare("SELECT CONCAT(patient.prenom,' ',patient.nom), consultation_domicile.date_consultation
FROM `patient`, consultation_domicile 
WHERE consultation_domicile.id_patient=patient.id_patient AND consultation_domicile.id_consultation=?");
$reponse->execute(array($_GET['id']));
$donnees=$reponse->fetch();
$patient=$donnees['0'];
$date_consultation=$donnees['1'];

$req_consultation=$db->prepare("SELECT  soins_domicile.soins, soins_domicile.pu, soins_domicile_patient.quantite, soins_domicile_patient.montant
FROM soins_domicile_patient, soins_domicile 
WHERE soins_domicile_patient.id_soins=soins_domicile.id AND soins_domicile_patient.id_consultation=?");
$req_consultation->execute(array($_GET['id']));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Demande de régularisation</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>dossier_patient.jpg) ;">
		<?php include 'verification_menu_sante.php'; ?>
		<div class="container">
			<div class="row white" style="border-radius: 25px">
				<form class="col s12" method="POST" action="d_regularisation_cons_dom_trmnt.php?id=<?=$_GET['id']?>">
					<div class="container">
						<div class="row">
							<h4 class="col s12 center">
							Demande de régularisation pour le patient :<br>
							<b><?=$patient ?></b>
							</h4>
						</div>
						<div class="row">
							<div class="col s12 m6 input-field">
								<input type="text" value="<?= $date_consultation ?>" class="datepicker" name="date_obs" id="date_obs" required>
								<label for="date_obs">Date de la consultation</label>
							</div>
						</div>
						<div class="row">
								<h5 class="center col s12 m12"><b>Soins dispensé(s)</b></h5>
							<h6 class="col s12 m12">
								<br>
								<?php
								$total=0;
								while ($donnees=$req_consultation->fetch()) 
								{
									echo "-".$donnees['0']." : ".number_format($donnees['3'],0,'.',' ')."<br>";
									$total=$total+$donnees['3'];
								}
								echo "<br>";
								echo "<b>TOTAL : ".number_format($total,0,'.',' ')." Fcfa"."</b>";
								?>
							</h6>
						</div>
						<div class="row">
							<div class="col s12 m6 input-field">
								<input type="text" value="<?=date('Y').'-'.date('m').'-'.date('d') ?>" class="datepicker" name="date_emission" id="date_emission" required>
								<label for="date_emission">Date d'émission</label>
							</div>
							<div class="col s12 m6 input-field">
								<input type="number" value="<?=$total?>"  name="montant" id="montant" required>
								<label for="montant">Montant</label>
							</div>
						</div>
						<div class="row">
							<div class="col s12 m2 offset-m8 input-field">
								<input class="btn" type="submit" name="enregistrer" value="Enregistrer" >
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	<style type="text/css">
		
		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 10px;
			margin: 5px;
		}
		@media print
		{
			.btn, a{
				display: none;
			}
			div
			{
			font: 12pt "times new roman";
			}
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
			$('form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
					return false;
				}
			});
			$('select').formSelect();
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
			$('.timepicker').timepicker({
				showClearBtn:true,
				twelveHour:false,
				i18n:{
					cancel:'Annuler',
					done:'OK',
					clear:'Réinitialiser'
				}
			});
		});
	</script>
</html>