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
$req=$db->prepare('SELECT * FROM `patient_externe` WHERE id=?');
$req->execute(array($_GET['id']));
$donnees=$req->fetch();
$id=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Nouveau soins</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_analyse.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="input-field">
			<input type="hidden" class="patient" value="<?= $id ?>">
		</div>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h5 class="">
					Patient : <b><?= $prenom." ".$nom ?></b>
				</h5>
				<!--Analyse -->			
				<h3 class="center">Analyse(s)</h3>
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
							<a href="l_analyse.php" class="btn">Terminer</a>
						</div>
					</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			//analyse
			$('.ajouter_analyse').click(function(){
				var analyse = $('select:eq(0)').val();
				var qt = $('#qt_analyse').val();
				var patient = $('.patient').val();
				var p='e';
				if (analyse==null || qt=="" )
				{
					alert('Analyse et ou Quantité null');
				}
				else
				{
					$.ajax({
						type:'POST',
						url:'ajout_analyse_ajax.php',
						data:'patient='+patient+'&qt='+qt+'&analyse='+analyse+'&p='+p,
						success:function (html) {
							$('.tab_analyse').html(html);
												}
					});
				}
			});

			//Soins
			$('.ajouter_soins').click(function(){
				var soins = $('select:eq(1)').val();
				var qt = $('#qt_soins').val();
				var patient = $('.patient').val();
				var p='e';
				if (soins==null || qt=="" )
				{
					alert('Soins et ou Quantité null');
				}
				else
				{
					$.ajax({
						type:'POST',
						url:'ajout_soins_ajax.php',
						data:'patient='+patient+'&qt='+qt+'&soins='+soins+'&p='+p,
						success:function (html) {
							$('.tab_soins').html(html);
												}
					});
				}
			});

			$('select').formSelect();
			$('#form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement de nouveau  patient ?')) 
				{
					return false;
				}
				else
				{
					window.location='l_analyse.php'
				}
			});
		});
	</script>
</html>