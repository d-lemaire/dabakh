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
$req=$db->prepare("SELECT * FROM personnel WHERE id=? ");
$req->execute(array($_GET['id']));
$resultat=$req->rowCount();
$donnees= $req->fetch();
$id=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$fonction=$donnees['3'];						
$telephone=$donnees['4'];
$date_embauche=$donnees['5'];	
$login=$donnees['6'];	
$service=$donnees['8'];
$etat=$donnees['9'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ajout</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_bailleur.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Modification personnel</h3>
				<form class="col s12" method="POST" id="form" action="m_personnel_trmnt.php?id=<?=$_GET['id']?>" >
					<div class="row">
						<div class="col s6 input-field">
							<input type="text" value="<?=$prenom?>" name="prenom" id="prenom" required>
							<label for="prenom">Prénom</label>
						</div>
						<div class="col s5 input-field">
							<input type="text" value="<?=$nom?>" name="nom" id="nom" required>
							<label for="nom">Nom</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<input type="text" value="<?=$telephone?>" name="telephone" id="telephone" required>
							<label for="telephone">Téléphone</label>
						</div>
						<div class="col s7 input-field">
							<select name="fonction" class="browser-default" required>
								<option value="" disabled="" >
									Veillez choisir la fonction
								</option>
								<option value="administrateur" <?php if ($fonction=="administrateur"){echo "selected";} ?>>
									Administrateur
								</option>
								<option value="daf" <?php if ($fonction=="daf"){
									echo "selected";} ?>>
									DAF
								</option>
								<option value="secretaire" <?php if ($fonction=="secretaire"){echo "selected";} ?>>
									Secrétaire
								</option>
								<option value="medecin" 
								<?php if ($fonction=="medecin"){echo "selected";} ?>>
									Medecin
								</option>
								<option value="infirmier" <?php 
								if ($fonction=="infirmier"){echo "selected";} ?>>
									Infirmier(e)
								</option>
								<option value="agent immobilier" <?php if ($fonction=="agent immobilier"){echo "selected";} ?>>
									Agent immobilier(e)
								</option>
								<option value="agent de sante" <?php if ($fonction=="agent de sante"){echo "selected";} ?>>
									Agent de santé
								</option>
								<option value="femme de charge" <?php if ($fonction=="femme de charge"){echo "selected";} ?>>
									Femme de charge
								</option>
								<option value="chauffeur" <?php if ($fonction=="chauffeur"){echo "selected";} ?>>
									Chauffeur
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="date" value="<?=$date_embauche?>" name="date_embauche" class="" id="date_embauche" required>
							<label for="date_embauche">Date d'embauche</label>
						</div>
						<div class="col s6 input-field">
							<select name="service" class="browser-default" required>
								<option value="" disabled="" >
									Veillez choisir le service
								</option>
								<option value="sante" <?php if ($service=="sante") {echo "selected";} ?>>
									Santé
								</option>
								<option value="immobilier" <?php if ($service=="immobilier") {echo "selected";} ?>>
									Immobilier
								</option>
								<option value="service general" <?php if ($service=="service general") {echo "selected";} ?>>Service Général
							</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="text" value="<?=$login?>" name="login" id="login" required>
							<label for="login">Login</label>
						</div>
					</div>
					<div class="row">
						<div class="col s2  input-field">
							<?php
								if ($etat=="desactiver") 
								{
									?>
									<a href="desactiver_personnel.php?id=<?= $id ?>&amp;etat=<?= $etat ?>" class="btn blue">Activer</a>
									<?php
									
								}
								else
								{
									?>
									<a href="desactiver_personnel.php?id=<?= $id ?>&amp;etat=<?= $etat ?>" class="btn red">Déscativer</a>			
									<?php
									
								}
							?>
							
						</div>
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