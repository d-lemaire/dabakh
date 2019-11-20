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
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ajout</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_personnel.jpg) ;">
		<?php
            include 'verification_menu_sante.php';         
        ?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Ajout d'un nouveau personnel</h3>
				<form class="col s12" method="POST" id="form" action="e_personnel_trmnt.php" >
					<div class="row">
						<div class="col s6 input-field">
							<input type="text" name="prenom" id="prenom" required>
							<label for="prenom">Prénom</label>
						</div>
						<div class="col s5 input-field">
							<input type="text" name="nom" id="nom" required>
							<label for="nom">Nom</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<input type="text" name="telephone" id="telephone" required>
							<label for="telephone">Téléphone</label>
						</div>
						<div class="col s7 input-field">
							<select name="fonction" class="browser-default" required>
								<option value="" disabled="" selected="" >Veillez choisir la fonction</option>
								<option value="administrateur">
									Administrateur
								</option>
								<option value="daf">
									DAF
								</option>
								<option value="secretaire">
									Secrétaire
								</option>
								<option value="medecin">
									Medecin
								</option>
								<option value="infirmier">
									Infirmier(e)
								</option>
								<option value="agent immobilier">
									Agent immobilier(e)
								</option>
								<option value="agent de sante">
									Agent de santé
								</option>
								<option value="femme de charge">
									Femme de charge
								</option>
								<option value="chauffeur">
									Chauffeur
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="date" name="date_embauche" class="" id="date_embauche" required>
							<label for="date_embauche">Date d'embauche</label>
						</div>
						<div class="col s6 input-field">
							<select name="service" class="browser-default" required>
								<option value="" disabled="" selected="" >Veillez choisir le service</option>
								<option value="sante">Santé</option>
								<option value="immmobilier">Immobilier</option>
								<option value="service general">Service Général</option>
							</select>
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
				if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
					return false;
				}
			});
		});
		
	</script>
</html>