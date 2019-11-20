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
$req=$db->prepare('SELECT * FROM patient WHERE id_patient=?');
$req->execute(array($_GET['id']));
$donnees=$req->fetch();
$id_patient=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$date_naissance=$donnees['3'];
$lieu_naissance=$donnees['4'];
$profession=$donnees['5'];
$domicile=$donnees['6'];
$telephone=$donnees['7'];
$sexe=$donnees['8'];
$situation_matrimoniale=$donnees['9'];
$antecedant=$donnees['10'];
$allergie=$donnees['11'];
$num_dossier=$donnees['12'];
$annee_inscription=$donnees['13'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification dossier</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_a.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Modification Dossier Patient</h3>
				<form class="col s12" method="POST" id="form" action="m_patient_trmnt.php?id_patient=<?=$_GET['id'] ?>" >
					<div class="row">
						<div class="col s5 input-field">
							<i class="material-icons prefix">folder_shared</i>
							<input type="number"  value="<?=$num_dossier ?>" name="num_dossier" id="num_dossier" required>
							<label for="num_dossier">Numéro dossier</label>
						</div>
						<div class="col s2 input-field">
							<select class="browser-default" name="annee_inscription" required>
								<option disabled="" >Année d'inscription</option>
								<?php

								for ($i=12; $i >0 ; $i--) { 
									echo "<option value='".(date('Y')-$i)."'";
									if ($annee_inscription==(date('Y')-$i)) 
									{
										echo "selected";
									}
									echo ">".(date('Y')-$i)."</option>";
								}
								echo "<option value='".(date('Y'))."'";
									if ($annee_inscription==(date('Y'))) {
										echo "selected";
									}
								echo ">".(date('Y'))."</option>";
								echo "<option value='".(date('Y')+1)."'";
									if ($annee_inscription==(date('Y')+1)) {
										echo "selected";
									}
								echo ">".(date('Y')+1)."</option>";
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<i class="material-icons prefix">account_circle</i>
							<input type="text" value="<?=$prenom ?>" name="prenom" id="prenom" required>
							<label for="prenom">Prénom</label>
						</div>
						<div class="col s5 input-field">
							<i class="material-icons prefix">account_box</i>
							<input type="text" value="<?=$nom ?>" name="nom" id="nom" required>
							<label for="nom">Nom</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<input type="date" value="<?=$date_naissance ?>" class="" name="date_naissance" id="date_naissance" required>
							<label for="date_naissance">Date de naissance</label>
						</div>
						<div class="col s5 input-field">
							<i class="material-icons prefix">add_location</i>
							<input type="text" value="<?=$lieu_naissance ?>" class="" name="lieu_naissance" id="lieu_naissance" required>
							<label for="lieu_naissance">Lieu de naissance</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<i class="material-icons prefix">location_on</i>
							<input type="text" value="<?=$domicile ?>" class="" name="domicile" id="domicile">
							<label for="domicile">Domicile</label>
						</div>
						<div class="col s3 input-field">
							<i class="material-icons prefix">call</i>
							<input type="text" value="<?=$telephone ?>" class="" name="telephone" id="telephone" required>
							<label for="telephone">Téléphone</label>
						</div>
						<div class="col s5 input-field">
							<input type="text" value="<?=$profession ?>" class="" name="profession" id="profession">
							<label for="profession">Profession</label>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<select class="browser-default" name="sexe" required>
								<option value="" disabled >Sexe</option>
								<option <?php if ($sexe=="Masculin") {
										echo "selected";
								} ?> value="Masculin">Masculin</option>
								<option <?php if ($sexe=="Feminin") {
										echo "selected";
								} ?> value="Feminin">Feminin</option>
								
							</select>
						</div>
						<div class="col s5 input-field">
							<select class="browser-default" name="situation_matrimoniale" required>
								<option value="" disabled >Situation matrimonaile</option>
								<option <?php if ($situation_matrimoniale=="Marie(e)") {
										echo "selected";
								} ?> value="Marie(e)">Marie(e)</option>
								<option <?php if ($situation_matrimoniale=="Celibataire") {
										echo "selected";
								} ?> value="Celibataire">Celibataire</option>
								
							</select>
						</div>
					</div>
					<!--
					<div class="row">
						<div class="input-field col s6">
							<textarea id="allergie" name="allergie" class="materialize-textarea"><?=$allergie ?></textarea>
							<label for="allergie">Allergie</label>
						</div>
						<div class="input-field col s6">
							<textarea id="antecedant" name="antecedant" class="materialize-textarea"><?=$antecedant ?></textarea>
							<label for="antecedant">Antécedant</label>
						</div>
					</div>
					-->
					<div class="row">
						<div class="col s2 offset-s8 input-field">
							<input class="btn" type="submit" name="enregistrer" value="Enregistrer modification(s)" >
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
				if (!confirm('Voulez-vous confirmer l\'enregistrement de nouveau  patient ?')) {
					return false;
				}
			});
		});
	</script>
</html>