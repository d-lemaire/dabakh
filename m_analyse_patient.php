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

$req=$db->prepare('SELECT DISTINCT patient_externe.prenom, patient_externe.nom, patient_externe.date_naissance, patient_externe.lieu_naissance, patient_externe.profession, patient_externe.domicile, patient_externe.telephone, patient_externe.sexe 
FROM patient_externe 
WHERE patient_externe.id=?');
$req->execute(array($_GET['id']));
$donnees=$req->fetch();
$prenom=$donnees['0'];
$nom=$donnees['1'];
$date_naissance=$donnees['2'];
$lieu_naissance=$donnees['3'];
$profession=$donnees['4'];
$domicile=$donnees['5'];
$telephone=$donnees['6'];
$sexe=$donnees['7'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>m_analyse.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Modification </h3>
				<form class="col s12" method="POST" id="form" action="m_analyse_patient_trmnt.php?id=<?=$_GET['id'] ?>" >
					<div class="row">
						<div class="input-field">
							<input type="hidden" name="patient" class="patient" id="patient" value="<?= $_GET['id'] ?>" >
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<i class="material-icons prefix">account_circle</i>
							<input type="text" value="<?= $prenom ?>" name="prenom" id="prenom" required>
							<label for="prenom">Prénom</label>
						</div>
						<div class="col s5 input-field">
							<i class="material-icons prefix">account_box</i>
							<input type="text" value="<?= $nom ?>" name="nom" id="nom" required>
							<label for="nom">Nom</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<input type="date" value="<?= $date_naissance ?>" name="date_naissance" id="date_naissance"  >
							<label for="date_naissance">Date de naissance</label>
						</div>
						<div class="col s5 input-field">
							<i class="material-icons prefix">add_location</i>
							<input type="text" value="<?= $lieu_naissance ?>" class="" name="lieu_naissance" id="lieu_naissance" >
							<label for="lieu_naissance">Lieu de naissance</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<i class="material-icons prefix">location_on</i>
							<input type="text" value="<?= $domicile ?>" class="" name="domicile" id="domicile">
							<label for="domicile">Domicile</label>
						</div>
						<div class="col s3 input-field">
							<i class="material-icons prefix">call</i>
							<input type="text" value="<?= $telephone ?>" class="" name="telephone" id="telephone" >
							<label for="telephone">Téléphone</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 input-field">
							<select class="browser-default" name="sexe" required>
								<option value="" disabled >Sexe</option>
								<option value="Masculin" <?php if ($sexe=="Masculin"){echo "selected";}?>>Masculin</option>
								<option value="Feminin"<?php if ($sexe=="Feminin"){ echo "selected";}?>>Feminin</option>
								
							</select>
						</div>
						<div class="col s5 input-field">
							<input type="text" value="<?= $profession ?>" class="" name="profession" id="profession">
							<label for="profession">Profession</label>
						</div>
					</div>

					<!--Analyse -->			
					<h3 class="center">Analyse(s)</h3>
						<div class="row">
							<table class="bordered highlight centered col s10 offset-s1">
								<thead>
									<tr>
										<th>Analyse</th>
										<th>Pu</th>
										<th>Nombre</th>
										<th>Montant</th>
									</tr>
								</thead>
							<tbody class="tab_analyse">
								<?php
									$req=$db->prepare("SELECT  analyse.analyse, analyse.cout, analyse_patient.quantite, analyse_patient.montant, analyse_patient.id
									FROM analyse_patient, analyse 
									WHERE analyse_patient.id_analyse=analyse.id AND analyse_patient.id_patient=?");
									$req->execute(array($_GET['id']));
									$nbr=$req->rowCount();

									while ($donnees_l_analyse=$req->fetch()) 
									{
										echo "<tr>";
											echo "<td>".$donnees_l_analyse['0']."</td>";
											echo "<td>".$donnees_l_analyse['1']."</td>";
											echo "<td>".$donnees_l_analyse['2']."</td>";
											echo "<td>".$donnees_l_analyse['3']."</td>";
											echo "<td><a href='supprimer_analyse.php?id_pat=".$_GET['id']."&amp;id=".$donnees_l_analyse['4']."&amp;p=e'><i class='material-icons red-text'>clear</i></a></td>";
										echo "</tr>";		
									}	

									$req=$db->prepare("SELECT SUM(analyse_patient.montant) FROM analyse_patient WHERE analyse_patient.id_patient=?");
									$req->execute(array($_GET['id']));
									$donnees=$req->fetch();
										echo '<input type="hidden" name="cout" class="cout" id="cout" value="'.$donnees['0'].'">';
									echo "<tr class='grey'>";
										echo "<td>TOTAL</td>";			
										echo "<td></td>";			
										echo "<td></td>";			
										echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
									echo "</tr>";
								?>
							</tbody>
						</table>
						</div>
						<div class="row">
							<div class="col s12 m4 input-field">
								<select class="browser-default"  id="analyse">
									<option disabled value="" selected="">Veillez sélectionner l'analyse </option>
									<?php
									include 'connexion.php';
									$req=$db->query('SELECT * FROM `analyse`');	
									while ($donnees=$req->fetch()) {
										echo "<option value='".$donnees['0']."'>".$donnees['1'];
										echo "</option>";
									}
									?>
								</select>
							</div>
							<div class="col s12 m2 input-field">
								<input type="number" class="qt"  name="qt" id="qt_analyse">
								<label for="qt">Quantité</label>
							</div>
							<div class="col s12 m2  input-field">
								<a  class="btn ajouter_analyse">Ajouter+</a>
							</div>
						</div>

						<!--Soins externes -->
						<h3 class="center">Soins externes</h3>
							<div class="row">
								<table class="bordered highlight centered col s10 offset-s1">
									<thead>
										<tr>
											<th>Soins</th>
											<th>Pu</th>
											<th>Nombre</th>
											<th>Montant</th>
										</tr>
									</thead>
								<tbody class="tab_soins">
									<?php
										$req=$db->prepare("SELECT  soins_externes.soins, soins_externes.pu, soins_externes_patient.quantite, soins_externes_patient.montant, soins_externes_patient.id
											FROM soins_externes_patient, soins_externes 
											WHERE soins_externes_patient.id_soins=soins_externes.id AND soins_externes_patient.id_patient=?");
										$req->execute(array($_GET['id']));
										$nbr=$req->rowCount();

										while ($donnees_l_soins=$req->fetch()) 
										{
											echo "<tr>";
												echo "<td>".$donnees_l_soins['0']."</td>";
												echo "<td>".$donnees_l_soins['1']."</td>";
												echo "<td>".$donnees_l_soins['2']."</td>";
												echo "<td>".$donnees_l_soins['3']."</td>";
												echo "<td><a href='supprimer_soins_externes.php?id_pat=".$_GET['id']."&amp;id=".$donnees_l_soins['4']."&amp;p=e'><i class='material-icons red-text'>clear</i></a></td>";
											echo "</tr>";		
										}	

										$req=$db->prepare("SELECT SUM(soins_externes_patient.montant) FROM soins_externes_patient WHERE soins_externes_patient.id_patient=?");
										$req->execute(array($_GET['id']));
										$donnees=$req->fetch();
											echo '<input type="hidden" name="cout" class="cout" id="cout" value="'.$donnees['0'].'">';
										echo "<tr class='grey'>";
											echo "<td>TOTAL</td>";			
											echo "<td></td>";			
											echo "<td></td>";			
											echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
										echo "</tr>";
									?>
								</tbody>
							</table>
							</div>
							<div class="row">
								<div class="col s12 m4 input-field">
									<select class="browser-default"  id="soins_externes">
										<option disabled value="" selected="">Veillez sélectionner le soins </option>
										<?php
										include 'connexion.php';
										$req=$db->query('SELECT * FROM `soins_externes`');	
										while ($donnees=$req->fetch()) {
											echo "<option value='".$donnees['0']."'>".$donnees['1'];
											echo "</option>";
										}
										?>
									</select>
								</div>
								<div class="col s12 m2 input-field">
									<input type="number" class="qt"  name="qt" id="qt_soins">
									<label for="qt">Quantité</label>
								</div>
								<div class="col s12 m2  input-field">
									<a  class="btn ajouter_soins">Ajouter+</a>
								</div>
							</div>
							<br>

					<div class="row">
						<div class="col s2 offset-s8 input-field">
							<input class="btn" type="submit" name="enregistrer" value="Modifier" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			$('.ajouter').click(function(){
				var analyse = $('select:last').val();
				var qt = $('#qt').val();
				var patient = $('.patient').val();
				var p='m';
				if (produit==null || qt=="" )
				{
					alert('Analyse et ou Quantité null');
				}
				else
				{
					$.ajax({
						type:'POST',
						url:'ajout_analyse_ajax.php',
						data:'analyse='+analyse+'&qt='+qt+'&patient='+patient+'&p='+p,
						success:function (html) {
							$('tbody').html(html);
												}
					});
				}
			});
			$('select').formSelect();
			$('#form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement de nouveau  patient ?')) {
					return false;
				}
			});
		});
	</script>
</html>