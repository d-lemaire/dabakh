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
$annee= date('Y');
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $mois[date("n")-1];
//recupération des informations sur la location
$db->query("SET lc_time_names = 'fr_FR';");
$req=$db->prepare("SELECT location.id,CONCAT(day(location.date_debut),' ', monthname(location.date_debut),' ', year(location.date_debut)),location.caution, location.prix_location, CONCAT(locataire.prenom,' ', locataire.nom), CONCAT(logement.designation,' à ',logement.adresse)
	FROM `location`, logement, locataire
	WHERE location.id_locataire=locataire.id AND location.id_logement=logement.id AND location.id=?
	ORDER BY location.date_debut DESC");
$req->execute(array($_GET['id']));
$nbr=$req->rowCount();
if ($nbr>0) {
	$donnees=$req->fetch();
	$id=$donnees['0'];
	$date_debut=$donnees['1'];
	$caution=$donnees['2'];
	$montant_mensuel=$donnees['3'];
	$locataire=$donnees['4'];
	$designation=$donnees['5'];
}
//Recupération des informations sur les mensualités 
$req=$db->prepare('SELECT CONCAT(day(mensualite.date_versement)," ", monthname(mensualite.date_versement)," ", year(mensualite.date_versement)), CONCAT(mensualite.mois," ", mensualite.annee), mensualite.montant, mensualite.type 
FROM `mensualite` 
WHERE id_location=? ORDER BY date_versement ASC');
$req->execute(array($_GET['id']));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Nouvelle mensualité</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>e_mensualite.jpg) ;">
		<?php
		//include 'verification_menu_immo.php';
		?><br>
		<a href="e_mensualite.php" class="btn " >Retour</a>
		<div class="container white">
			<div class="row z-depth-5" style="padding: 10px;">
				<h3 class="center">Nouvelle mensualité</h3>
				<h5 class="col s12">Locataire : <b><?=$locataire ?></b></h5>
				<h5 class="col s12">Logement : <b><?=$designation ?></b></h5>
				<h5 class="col s6">Mensualité : <b><?=number_format($montant_mensuel,0,'.',' ') ?> Fcfa</b></h5>
				<!--<h5 class="col s12">Mois : <b><?=$_GET['m'] ?></b></h5>-->
				<form class="col s12" method="POST" id="form" action="e_mensualite_trmnt.php?id=<?=$id ?>" >
					<br>
					<div class="row">
						<table class="col s8 offset-s2 centered">
							<thead>
								<tr>
									<th>Mois</th>
									<th>Date versement</th>
									<th>Montant versé</th>
									<th>Reliquat</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total_verse=0;
								$total_reliquat=0;
									while ($donnees=$req->fetch()) 
									{
										echo "<tr>";
											echo "<td>".$donnees['1']."</td>";
											echo "<td>".$donnees['0']."</td>";
											echo "<td>".number_format($donnees['2'],0,'.',' ')."</td>";
											if (($donnees['3'])=="avance") 
											{	
											echo "<td>".number_format(($montant_mensuel-$donnees['2']),0,'.',' ')."</td>";
											$total_reliquat=$total_reliquat+($montant_mensuel-$donnees['2']);
											}
											else
											{
												echo "<td>0 Fcfa</td>";
											}
											
										echo "</tr>";
										$total_verse=$total_verse+$donnees['2'];
									}
									echo "<tr class='grey white-text bold'>";
										echo"<td colspan='2'><b>TOTAL</b></td>";
										echo "<td><b>".number_format($total_verse,0,'.',' ')." Fcfa</b></td>";
										echo "<td><b>".number_format($total_reliquat,0,'.',' ')." Fcfa</b></td>";

									echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col s10">
							<label>
								<input type="radio" name="type" value="complet" checked>
								<span>Montant complet</span>
							</label>
							<label>
								<input type="radio" name="type" value="avance">
								<span>Avance</span>
							</label>
							<label>
								<input type="radio" value="reliquat" name="type">
								<span>Reliquat</span>	
							</label>
							
						</div>
					</div>
					<div class="row">

						<div class="col s4">
							<label for="mois">Mois de :</label>
							<select class="browser-default" name="mois" id="mois" required="">
								<option disabled="" selected="" value="">Sélectionner le mois</option>
								<?php
								for ($i=1; $i <= 12; $i++) 
								{
									echo "<option value='".$mois[$i]."'";
									/*if ($mois[$i]==$datefr) {
										echo "selected";
									}*/
									echo ">".$mois[$i]."</option>";
								}
								?>
							</select>
						</div>
						<div class="col s3">
							<label for="annee">Année</label>
							<select class="browser-default " name="annee" id="annee" required="">
								<option value="" disabled>--Choisir Annee--</option>
								<?php
								echo '<option value="'. $annee .'" selected>'. $annee .'</option>';
								echo '<option value="'. ($annee + 1) .'" >'. ($annee + 1) .'</option>';
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col s5 input-field">
							<input type="text" value="<?php echo date('Y').'-'.date('m').'-'.date('d') ?>"  name="date_versement" class=datepicker id="date_versement" required>
							<label for="date_versement">Date versement</label>
						</div>
						<div class="col s4 input-field">
							<input type="number" value="<?= $montant_mensuel ?>" name="montant" id="montant" required>
							<label for="montant">Montant</label>
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
	<style type="text/css">
		tr td {
			border: 1px solid;
		}
		th{
			border: 1px solid;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
			$('select').formSelect();
			$('#form').submit(function () {
				if (!confirm('Voulez-vous confirmer l\'enregistrement de cette nouvelle mensualité ?')) {
					return false;
				}
			});
		});
		$('.datepicker').datepicker({
		autoClose: true,
		yearRange:[2014,2020],
		showClearBtn: true,
		i18n:{
			nextMonth: 'Mois suivant',
			previousMonth: 'Mois précédent',
			labelMonthSelect: 'Selectionner le mois',
			labelYearSelect: 'Selectionner une année',
			months: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
			monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Dec' ],
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
	</script>
</html>