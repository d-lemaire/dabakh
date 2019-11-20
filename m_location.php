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
$req=$db->prepare('SELECT * FROM location WHERE id= ?');
$req->execute(array($_GET['id']));
$nbr=$req->rowCount();
if ($nbr>0) {
	$donnees=$req->fetch();
	$id=$donnees['0'];
	$date_debut=$donnees['1'];
	$caution=$donnees['2'];
	$montant_mensuel=$donnees['3'];
	$id_logement=$donnees['4'];
	$id_locataire=$donnees['5'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification Location</title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url(<?=$image ?>m_location.jpg);">
		<?php
		include 'verification_menu_immo.php';
		?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Modification location</h3>
				<form class="col s12" method="POST" id="form" action="m_location_trmnt.php?id=<?=$_GET['id'] ?>" >
					<div class="row">
						<div class="col s8 input-field">
							<select class="browser-default" name="locataire" required>
								<option value="" disabled selected>Choisissez le locataire</option>
								<?php
								include 'connexion.php';
								$reponse=$db->query("SELECT * FROM locataire  ORDER BY nom");
								while ($donnees=$reponse->fetch()) {
									echo "<option value='".$donnees['0']."'";
									if ($donnees['0']==$id_locataire) {
										echo "selected";
									}
									echo ">";
									echo $donnees['1']." ".$donnees['2']."; Tel : ".$donnees['3'];
									echo"</option>";
								}
								$reponse->closeCursor();
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s8 input-field">
							<select class="browser-default" name="logement" required>
								<option value="" disabled selected>Choisissez le logement</option>
								<?php
								include 'connexion.php';
								$reponse=$db->query("SELECT * FROM logement");
								while ($donnees=$reponse->fetch()) {
									echo "<option value='".$donnees['0']."'";
									if ($donnees['0']==$id_logement) {
										echo "selected";
									}
									echo ">";
									echo $donnees['1']."; Lieu : ".$donnees['2'];
									echo"</option>";
								}
								$reponse->closeCursor();
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="date" value="<?=$date_debut?>" name="date_debut" class="" id="date_debut">
							<label for="date_debut">Date début</label>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="number" value="<?=$caution?>" name="caution" id="caution">
							<label for="caution">Caution</label>
						</div>
						<div class="col s5 input-field">
							<input type="number" value="<?=$montant_mensuel?>" name="montant_mensuel"  id="montant_mensuel">
							<label for="montant_mensuel">Redevence mensuelle</label>
						</div>
					</div>
					<div class="row">
						<div class="col s2 offset-s8 input-field">
							<input class="btn" type="submit" name="enregistrer" value="Enregistrer" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			$('select').formSelect();
			$('#form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement de cette nouvelle location ?')) {
					return false;
				}
			});
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
		});
		
	</script>
</html>