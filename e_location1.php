<?php
session_start();
unset($_SESSION['id_locataire']);
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
$req=$db->prepare('SELECT * FROM logement WHERE id=?');
$req->execute(array($_GET['id']));
$donnees=$req->fetch();
$logement=$donnees['1'];
$adresse=$donnees['2'];
$pu=$donnees['3'];
$nbr=$donnees['4'];
$req->closeCursor();

$req_locataire=$db->prepare('SELECT COUNT(*) FROM locataire WHERE annee_inscription=?');
$req_locataire->execute(array(date('Y')));
$donnee_locataire=$req_locataire->fetch();
$num_dossier= $donnee_locataire['0'] + 1;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Nouveau Dossier</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>wood.jpg);">
		<?php
		include 'verification_menu_immo.php';
		?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Nouveau Dossier de locatif</h3>
				<form class="col s12" method="POST" id="form" action="e_location_trmnt.php?id=<?=$_GET['id']?>&amp;nbr=<?=$nbr?>" >
					<?php
					if (isset($_GET['id_locataire'])) {
						?>
						<input type="text" hidden name="id_locataire" value="<?=$_GET['id_locataire'] ?>">
						<?php
					}
					?>
					<div class="row">
						<h5 class="col s12">
							Logement : <b><?= $logement ?></b> &nbsp&nbsp&nbsp Prix location : <b><?= number_format($pu,0,'.',' ') ?> Fcfa</b>
						</h5>
					</div>
					<div class="row">
						<div class="col s12 m2 input-field">
							<input type="number" value="<?=str_pad($num_dossier, 3, "0", STR_PAD_LEFT) ?>" name="num_dossier" id="num_dossier" required>
							<label for="num_dossier">Numéro dossier</label>
						</div>
						<div class="col s12 m3 input-field">
							<select class="browser-default" name="annee_inscription" required="">
								<option disabled="" selected="">Année d'inscription</option>
								<?php

								for ($i=12; $i >0 ; $i--) { 
									echo "<option value='".(date('Y')-$i)."'>".(date('Y')-$i)."</option>";
								}
								echo "<option selected value='".(date('Y'))."'>".(date('Y'))."</option>";
								echo "<option value='".(date('Y')+1)."'>".(date('Y')+1)."</option>";
								?>
								
							</select>
						</div>
						<div class="col s12 m3 input-field">
							<select class="browser-default" name="type_contrat" required="">
								<option disabled="" selected="">Type de contrat</option>			
								<option value="habitation">Habitation</option>				
								<option value="commercial">Commercial</option>								
							</select>
						</div>
					</div>
					<?php
					if (!isset($_GET['id_locataire'])) 
					{
						
					?>
					<div class="row">
						<div class="col s12 m6 input-field">
							<input type="text" name="prenom" id="prenom" required>
							<label for="prenom">Prénom</label>
						</div>
						<div class="col s5 input-field">
							<input type="text" name="nom" id="nom" required>
							<label for="nom">Nom</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m4 input-field">
							<input type="text" name="telephone" id="telephone" required>
							<label for="telephone">Téléphone</label>
						</div>
						<div class="col s4 input-field">
							<input type="text" name="cni" id="cni" required>
							<label for="cni">N° CNI</label>
						</div>

					</div>
					<?php
					}
					?>
					<div class="row">
						<div class="col s12 m5 input-field">
							<input type="date" name="date_debut" class="" id="date_debut" required>
							<label for="date_debut">Date début</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m3 input-field hide">
							<input type="number"  value="<?=$pu?>" name="prix_location"  id="prix_location" required>
							<label for="prix_location">Prix location</label>
						</div>
						<div class="col s12 m3 input-field">
							<input type="number" value="<?=$pu?>" name="caution" id="caution" required>
							<label for="caution">Caution</label>
						</div>
						<div class="col s12 m3 input-field">
							<input type="number" value="<?=$pu?>" name="commision" id="commision" required>
							<label for="commision">Commission</label>
						</div>
						<div class="col s12 m3 input-field">
							<input type="number" value="<?=$pu?>" name="mensualite" id="mensualite" required>
							<label for="mensualite">Premier mois</label>
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