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
$medecin="";
if ($_SESSION['fonction']=="infirmier")
{
	$medecin="hide";
}
$secretaire="";
$pour_secretaire="";
if ($_SESSION['fonction']=="secretaire")
{
	$secretaire="hide";
}
else
{
	$pour_secretaire="hide";
}
if ($_SESSION['id']=='' ) {
	header("location:index.php");
} ?>
<?php
include 'connexion.php';
$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),'-',month(patient.date_naissance),'-',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, patient.telephone, patient.sexe, patient.situation_matrimoniale, consultation.poids, consultation.temperature, consultation.pouls, consultation.tension, consultation.glycemie, consultation.tdr, consultation.plaintes, consultation.date_consultation, consultation.ant_medicaux, consultation.ant_chirurgicaux, consultation.traitement_cours, consultation.allergie, consultation.histoire_maladie, consultation.neurologie, consultation.hemodynamique, consultation.respiratoire, consultation.autres_appareils, consultation.ecg, consultation.biologie, consultation.radiographie, consultation.tdm,  consultation.echographie, consultation.autres_examen, consultation.id_service, consultation.traitement, consultation.evolution, consultation.traitement_sortie, consultation.resume, consultation.reglement
FROM `consultation`, patient
WHERE patient.id_patient=consultation.id_patient AND consultation.id_consultation=?");
$reponse->execute(array($_GET['id']));
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
$poids=$donnees['10'];
$temperature=$donnees['11'];
$pouls=$donnees['12'];
$tension=$donnees['13'];
$glycemie=$donnees['14'];
$tdr=$donnees['15'];
$plaintes=$donnees['16'];
$date_consultation=$donnees['17'];
$ant_medicaux=$donnees['18'];
$ant_chirurgicaux=$donnees['19'];
$traitement_cours=$donnees['20'];
$allergie=$donnees['21'];
$histoire_maladie=$donnees['22'];
$neurologie=$donnees['23'];
$hemodynamique=$donnees['24'];
$respiratoire=$donnees['25'];
$autres_appareils=$donnees['26'];
$ecg=$donnees['27'];
$biologie=$donnees['28'];
$radiographie=$donnees['29'];
$tdm=$donnees['30'];
$echographie=$donnees['31'];
$autres_examen=$donnees['32'];
$id_service=$donnees['33'];
$traitement=$donnees['34'];
$evolution=$donnees['35'];
$traitement_sortie=$donnees['36'];
$resume=$donnees['37'];
$reglement=$donnees['38'];
$req_service=$db->query("SELECT * FROM service ORDER BY service.service");
$req_produit=$db->query("SELECT * FROM produit ORDER BY produit.produit");
$req_hospitalisation=$db->query("SELECT * FROM hospitalisation ORDER BY hospitalisation.designation ");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification d'une consultation</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_o.jpg);">
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
				Modification d'une consultation
				</h4>
				<form class="col s12" method="POST" id="form" action="m_consultation_trmnt.php?id=<?=$_GET['id']?>&amp;reglement=<?=$reglement ?>" >
					<div class="row">
						<div class="input-field">
							<input type="hidden" name="consultation" class="cons" id="cons" value="<?= $_GET['id'] ?>">
						</div>
					</div>
					<div class="row">
						<div class="col s12 m3 input-field">
							<input type="text" value="<?= $date_consultation ?>" class="datepicker" name="date_consultation" id="date_consultation" required>
							<label for="date_consultation">Date de la consultation</label>
						</div>
					</div>
					<div class="row <?=$secretaire ?>">
						<div class="col s12 m2 input-field">
							<input type="text" value="<?= $poids ?>"  name="poids" id="poids" >
							<label for="poids">Poids en Kg</label>
						</div>
						<div class="col s12 m2 input-field">
							<input type="text" value="<?= $tension ?>" name="tension" id="tension" >
							<label for="tension">Tension</label>
						</div>
						<div class="col s12 m2 input-field">
							<input type="text" value="<?= $pouls ?>" name="pouls" id="pouls" >
							<label for="pouls">Pouls</label>
						</div>
						<div class="col s12 m2 input-field">
							<input type="text" value="<?= $temperature ?>" name="temperature" id="temperature" >
							<label for="temperature">Température</label>
						</div>
					</div>
					<div class="row <?=$secretaire ?>">
						<div class="col s12 m2 input-field">
							<input type="text" value="<?= $glycemie ?>" name="glycemie" id="glycemie">
							<label for="glycemie">Glycémie</label>
						</div>
						<div class="col s input-field">
							<select class="browser-default" required="" name="tdr" id="tdr">
								<option disabled value=""  >TDR</option>
								<option value="non defini" <?php if ($tdr=='non defini')
												{
													echo "selected";
								}?>>Non défini</option>
								<option value="negatif" <?php if ($tdr=='negatif')
												{
													echo "selected";
								}?>>Négatif</option>
								<option value="positif" <?php if ($tdr=='positif')
												{
													echo "selected";
								}?>>Positif</option>
							</select>
						</div>
						
						<div class="input-field col s12 m4">
							<textarea id="plaintes" name="plaintes" class="materialize-textarea"><?=$plaintes?></textarea>
							<label for="plaintes">Plaintes</label>
						</div>
						<div class="input-field col s12 m4">
							<textarea id="allergie" name="allergie" class="materialize-textarea"><?=$allergie?></textarea>
							<label for="allergie">Allergie</label>
						</div>
					</div>
					<div class="row <?=$secretaire ?>">
						
					</div>
					
					
					<div class="<?=$medecin?> <?=$secretaire ?>">
						<div class="row">
							<h5 class="center"><b><u>Histoire de la maladie :</u></b></h5>
							<div class="col s10 input-field">
								<textarea class="materialize-textarea" name="histoire_maladie" id="histoire_maladie"><?= $histoire_maladie ?></textarea>
								<label for="histoire_maladie"><b>Histoire de la maladie</b></label>
							</div>
						</div>
						
						<h5 class="center"><b><u>Antécédant :</u></b></h5>
						<div class="row">
							<div class="col s5 input-field">
								<input type="text" value="<?=$ant_medicaux?>" id="ant_medicaux" name="ant_medicaux">
								<label for="ant_medicaux">Médicaux</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$ant_chirurgicaux ?>" id="ant_chirurgicaux" name="ant_chirurgicaux">
								<label for="ant_chirurgicaux">Chirurgicaux</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$traitement_cours ?>" id="traitement_cours" name="traitement_cours">
								<label for="traitement_cours">Traitement en cours</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$allergie ?>" id="allergie" name="allergie">
								<label for="allergie">Allergie</label>
							</div>
						</div>
						
						<h5 class="center <?=$secretaire ?>"><b><u>Examens des appareils :</u></b></h5>
						<div class="row">
							<div class="col s5 input-field">
								<input type="text"  value="<?=$neurologie ?>" id="neurologie" name="neurologie">
								<label for="neurologie">Neurologie</label>
							</div>
							<div class="col s5 input-field">
								<input type="text"  value="<?=$hemodynamique ?>" id="hemodynamique" name="hemodynamique">
								<label for="hemodynamique">Hémodynamique</label>
							</div>
							<div class="col s5 input-field">
								<input type="text"  value="<?=$respiratoire ?>" id="respiratoire" name="respiratoire">
								<label for="respiratoire">Respiratoire</label>
							</div>
							<div class="col s5 input-field">
								<input type="text"  value="<?=$autres_appareils ?>" id="autres_appareils" name="autres_appareils">
								<label for="autres_appareils">Autres appareils</label>
							</div>
						</div>
						<h5 class="center"><b><u>Examens complémentaires :</u></b></h5>
						<div class="row">
							<div class="col s5 input-field">
								<input type="text" value="<?=$ecg ?>" id="ecg" name="ecg">
								<label for="ecg">ECG</label>
							</div>
							<div class="col s5 input-field">
								<input type="text"value=" <?=$biologie ?>" id="biologie" name="biologie">
								<label for="biologie">Biologie</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$radiographie ?>" id="radiographie" name="radiographie">
								<label for="radiographie">Radiographie</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$tdm ?>" id="tdm" name="tdm">
								<label for="tdm">TDM</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$echographie ?>" id="echographie" name="echographie">
								<label for="echographie">Echographie</label>
							</div>
							<div class="col s5 input-field">
								<input type="text" value="<?=$autres_examen ?>" id="autres_examen" name="autres_examen">
								<label for="autres_examen">Autres</label>
							</div>
						</div>
						
						<div class="row">
							<div class="col s10 input-field">
								<textarea class="materialize-textarea" name="traitement" id="traitement"><?=$traitement ?></textarea>
								<label for="traitement"><b><u>Traitement : </u></b></label>
							</div>
						</div>
						<div class="divider black"></div>
						<div class="row">
							<div class="col s10 input-field">
								<textarea class="materialize-textarea"  name="evolution" id="evolution"><?=$evolution ?></textarea>
								<label for="evolution"><b>Evolution : </b></label>
							</div>
						</div>
						<div class="row">
							<div class="col s10 input-field">
								<textarea class="materialize-textarea" name="traitement_sortie" id="traitement_sortie"><?=$traitement_sortie ?></textarea>
								<label for="traitement_sortie"><b><u>Traitement de sortie</u></b></label>
							</div>
						</div>
						<div class="row">
							<div class="col s10 input-field">
								<textarea class="materialize-textarea"  name="resume" id="resume"><?=$resume ?></textarea>
								<label for="resume"><b><u>Résumé : </u></b></label>
							</div>
						</div>
						
						<div class="row">
						<h5 class="col s12 center">Services</h5>

							<div class="col s12 m6 input-field">
								<select class="browser-default" required="" name="service" id="service">
									<option disabled value="" >Veillez sélectionner le service dispensé</option>
									<?php
									while ($donnees_service=$req_service->fetch()) {
										echo "<option value='".$donnees_service['0']."'";
												if ($id_service==$donnees_service['0'])
												{
													echo "selected";
												}
												echo ">".$donnees_service['1'];
										echo "</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="row <?=$secretaire ?>">
					<h5 class="col s12 center">Produit(s)</h5>

						<table class="bordered highlight centered">
							<thead>
								<tr>
									<th>Produit</th>
									<th>Pu</th>
									<th>Quantité</th>
									<th>Montant</th>
								</tr>
							</thead>
							<tbody class="t_produit">
								<?php
								$req=$db->prepare("SELECT  produit.produit, produit.pu, vente_produit.quantite,vente_produit.montant, produit.id
								FROM consultation, vente_produit, produit
								WHERE consultation.id_consultation=vente_produit.id_consultation AND vente_produit.id_produit=produit.id AND consultation.id_consultation=? " );
								$req->execute(array($_GET['id']));
								$nbr=$req->rowCount();
								while ($donnees_l_produits=$req->fetch())
								{
									echo "<tr>";
												echo "<td>".$donnees_l_produits['0']."</td>";
												echo "<td>".$donnees_l_produits['1']."</td>";
												echo "<td>".$donnees_l_produits['2']."</td>";
												echo "<td>".$donnees_l_produits['3']."</td>";
												echo "<td><a href='supprimer_produit.php?id_cons=".$_GET['id']."&amp;id_prod=".$donnees_l_produits['4']."&amp;p=m'><i class='material-icons red-text'>clear</i></a></td>";
											echo "</tr>";
									}
								$req=$db->prepare("SELECT SUM(vente_produit.montant) FROM vente_produit WHERE vente_produit.id_consultation=?");
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
					<div class="row <?=$secretaire ?>">
						<div class="col s12 m4 input-field">
							<select class="browser-default"  id="produit" class="produit">
								<option disabled value="" selected="">Veillez sélectionner le produit </option>
								<?php
								while ($donnees_produit=$req_produit->fetch()) {
									echo "<option value='".$donnees_produit['0']."'>".$donnees_produit['1'];
									echo "</option>";
								}
								?>
							</select>
						</div>
						<div class="col s12 m2 input-field">
							<input type="number" class="qt"  name="qt" id="qt">
							<label for="qt">Quantité</label>
						</div>
						<div class="col s12 m2  input-field">
							<a  class="btn ajouter_produit">Ajouter+</a>
						</div>
					</div>
					<!--Fin produits-->
					<div class="row <?=$pour_secretaire?>">
					<h5 class="col s12 center">Hospitalisation</h5>
						<table class="bordered highlight centered">
							<thead>
								<tr>
									<th>Designation</th>
									<th>Pu</th>
									<th>Quantité</th>
									<th>Montant</th>
								</tr>
							</thead>
							<tbody class="t_hospitalisation">
								<?php
								$req=$db->prepare("SELECT hospitalisation.designation, hospitalisation.cout, consultation_hospitalisation.quantite, consultation_hospitalisation.montant, hospitalisation.id
									FROM `consultation_hospitalisation`, hospitalisation 
									WHERE consultation_hospitalisation.id_hospitalisation=hospitalisation.id AND consultation_hospitalisation.id_consultation=? " );
								$req->execute(array($_GET['id']));
								$nbr=$req->rowCount();
								while ($donnees_l_hospi=$req->fetch())
								{
									echo "<tr>";
										echo "<td>".$donnees_l_hospi['0']."</td>";
										echo "<td>".$donnees_l_hospi['1']."</td>";
										echo "<td>".$donnees_l_hospi['2']."</td>";
										echo "<td>".$donnees_l_hospi['3']."</td>";
										echo "<td><a href='supprimer_ligne_hospitalisation.php?id_cons=".$_GET['id']."&amp;id_hos=".$donnees_l_hospi['4']."&amp;p=m'><i class='material-icons red-text'>clear</i></a></td>";
									echo "</tr>";
									}
								$req=$db->prepare("SELECT SUM(consultation_hospitalisation.montant) FROM consultation_hospitalisation WHERE id_consultation=?");
								$req->execute(array($_GET['id']));
								$donnees=$req->fetch();
								$cout_hospitalisation=$donnees['0'];
								if (!isset($cout_hospitalisation)) 
								{
									$cout_hospitalisation=0;
								}
									echo '<input type="hidden" name="cout_hospitalisation" class="cout_hospitalisation" id="cout_hospitalisation" value="'.$cout_hospitalisation.'">';
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
					<div class="row <?=$pour_secretaire?>">
						<div class="col s12 m4 input-field">
							<select class="browser-default"  id="hospitalisation">
								<option disabled value="" selected="">Veillez sélectionner l'hospitalisation </option>
								<?php
								while ($donnees_hospitalisation=$req_hospitalisation->fetch()) {
									echo "<option value='".$donnees_hospitalisation['0']."'>".$donnees_hospitalisation['1'];
									echo "</option>";
								}
								?>
							</select>
						</div>
						<div class="col s12 m2 input-field">
							<input type="number" class="qt_hospitalisation"  name="qt_hospitalisation" id="qt_hospitalisation">
							<label for="qt_hospitalisation">Nombre</label>
						</div>
						<div class="col s12 m2  input-field">
							<a  class="btn ajouter_hospitalisation">Ajouter+</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col s12 m2 offset-m8 input-field">
							<input class="btn" type="submit" name="enregistrer" value="Enregistrer modification(s)" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			//ajout produit
			$('.ajouter_produit').click(function(){
				var produit = $('#produit').val();
				var qt = $('#qt').val();
				var consultation = $('#cons').val();
				if (produit==null || qt=="" )
				{
					alert('Produit et ou Quantité null');
						}
				else
				{
					$.ajax({
						type:'POST',
						url:'ajout_produit_ajax.php',
						data:'produit='+produit+'&qt='+qt+'&consultation='+consultation,
						success:function (html) {
							alert(produit);
							$('.t_produit').html(html);
												}
					});
				}
			});
			//ajout hospitalisation
			$('.ajouter_hospitalisation').click(function(){
				var hospitalisation = $('select:last').val();
				var qt = $('#qt_hospitalisation').val();
				var consultation = $('#cons').val();
				if (hospitalisation==null || qt=="" )
				{
					alert('Hospitalisation et ou Nombre null');
						}
				else
				{
					$.ajax({
						type:'POST',
						url:'ajout_hospitalisation_ajax.php',
						data:'hospitalisation='+hospitalisation+'&qt='+qt+'&consultation='+consultation,
						success:function (html) {
							$('.t_hospitalisation').html(html);
												}
					});
				}
			});
			$('#form').submit(function () {
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
		});
	</script>
</html>