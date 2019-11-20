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

$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),'-',month(patient.date_naissance),'-',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, patient.telephone, patient.sexe, patient.situation_matrimoniale
FROM patient
WHERE patient.id_patient=?");
$reponse->execute(array($_GET['id_patient']));
$donnees=$reponse->fetch();
$id_patient=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$date_naissance=$donnees['3'];
$lieu_naissance=$donnees['4'];
$profession=$donnees['5'];
$domicile=$donnees['6'];
$telephone=$donnees['7'];
$sexe=$donnees['8'];
$situation_mat=$donnees['9'];


$req_service=$db->query("SELECT * FROM service ORDER BY service.service");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enregistrement d'une consultation</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_o.jpg) ;">
		<?php include 'verification_menu_sante.php'; ?>

		<div class="row grey white-text">
			<div class="col s5">
					<h6 class="col s12">Prénom et Nom : <b><?=$prenom?> <?=$nom?></b></h6>
					<h6 class="col s12">Profession &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$profession?></b></h6>
			</div>
			<div class="col s3">
				<h6 class="col s12">Domicile &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$domicile?></b></h6>
				<h6 class="col s12">Téléphone &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$telephone?></b></h6>
			</div>
			<div class="col s3">
				<h6 class="col s12">Sexe &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$sexe?></b></h6>
				<h6 class="col s12">Situation matrimoniale : <b><?=$situation_mat ?></b></h6>
			</div>
		</div>

		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h4 class="center">
				Enregistrement d'une consultation
				</h4>
				<form class="col s12" method="POST" id="form" action="ajout_file_dattente_trmnt.php?id_patient=<?=$_GET['id_patient']?>" >

					<div class="row">
						<div class="input-field">
							<input type="hidden" name="consultation" class="cons" id="cons" value="<?= $_GET['id_patient'] ?>">
						</div>
					</div>

					<div class="row">
						<div class="col s12 m6 input-field">
							<select class="browser-default" required="" name="service" id="service">
								<option disabled selected="" value="">Veillez sélectionner le service dispensé</option>
								<?php
								while ($donnees_service=$req_service->fetch()) {
									echo "<option value='".$donnees_service['0']."'";
									echo ">";
									echo $donnees_service['1'];
									echo "</option>";
								}
								?>
							</select>
						</div>
					</div>
							
					<div class="row">
						<div class="col s12 m2 offset-m8 input-field">
							<input class="btn" type="submit" name="enregistrer" value="Enregistrer" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			
			$('#form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement de cet nouvelle consultation ?')) {
					return false;
				}
			});
			$('select').formSelect();
			$('.datepicker').datepicker({
				autoClose: true,
				yearRange:[2017,2021],
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
		});
	</script>
</html>