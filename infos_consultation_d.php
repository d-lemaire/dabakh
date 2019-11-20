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

$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),' ',monthname(patient.date_naissance),' ',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, patient.telephone, patient.sexe, patient.situation_matrimoniale, consultation_domicile.poids, consultation_domicile.temperature, consultation_domicile.pouls, consultation_domicile.tension, consultation_domicile.dextro, consultation_domicile.tdr, CONCAT(day(consultation_domicile.date_consultation), ' ', monthname(consultation_domicile.date_consultation),' ', year(consultation_domicile.date_consultation)), consultation_domicile.plaintes, consultation_domicile.allergie, consultation_domicile.remarques
FROM consultation_domicile, patient
WHERE patient.id_patient=consultation_domicile.id_patient AND consultation_domicile.id_consultation=?");
$reponse->execute(array($_GET['id']));
$donnees=$reponse->fetch();
$id_patient=$donnees['0'];
$patient=$donnees['1']." ".$donnees['2'];
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
$dextro=$donnees['14'];
$tdr=$donnees['15'];
$date_consultation=$donnees['16'];
$plaintes=$donnees['17'];
$allergie=$donnees['18'];
$remarques=$donnees['19'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Soins à domicile du <?=$date_consultation ?></title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url('<?=$image ?>i_consultation.png'); font: 12pt 'times new roman';">
		<a href="" class="btn" onclick="window.print();">Imprimer</a>
		&nbsp &nbsp &nbsp
		<a href="" class="btn" onclick="window.close();">Fermer</a>
		<div class="container  white" style="padding:  10px">
			<div class="row center " >
				<img class="col s12" src="../css/images/entete.jpg" >
			</div>
			<h4 class="center">Soins à domicile du <?=$date_consultation ?></h4>
			<br>
			<!--Dossier du patient -->
			<div class="row">
				<p class="col s6">
				Prénom et Nom : <b><?=$patient?></b><br>
				Profession &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$profession?></b><br>
				Date et lieu de naissance : <b><?=$date_naissance?></b>
				</p>
				<p class="col s6">
					Domicile &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$domicile?></b><br>
					Téléphone &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$telephone?></b><br>
				</p>
			</div>
			<div class="row">
				<div class="col s2">Poids : <b><?=$poids ?></b></div>
				<div class="col s2">Pouls : <b><?=$pouls ?></b></div>
				<div class="col s2">Tension : <b><?=$tension ?></b></div>
				<div class="col s3">Température : <b><?=$temperature ?></b></div>
				<br><br>
			</div>
			<div class="row">
				<div class="col s2">Dextro : <b><?=$dextro ?></b></div>
				<div class="col s3">TDR : <b><?=$tdr ?></b></div>
			</div>
			<br><br>
			<div class="row">
				<h6 class="col s6">
					<b><u>Plaintes</u></b><br>
					<?= nl2br($plaintes) ?>
				</h6>
				<h6 class="col s6">
					<b><u>Allergie</u></b><br>
					<?= nl2br($allergie) ?>
				</h6>
			</div>
			<div class="row">
				<h6 class="col s6">
					<b><u>Remarques</u></b><br>
					<?= nl2br($remarques) ?>
				</h6>
			</div>
			<div class="row">
				<h5 class="col s12"><u>Soins dispensés</u></h5>			
					<?php
					$req=$db->prepare('SELECT  soins_domicile.soins, soins_domicile_patient.quantite, soins_domicile.pu
						FROM `soins_domicile_patient`, soins_domicile 
						WHERE soins_domicile_patient.id_soins=soins_domicile.id AND soins_domicile_patient.id_consultation=?');
					$req->execute(array($_GET['id']));
					
					while ($donnees=$req->fetch()) 
					{
						echo '<h6 class="col s12">'.str_pad($donnees['1'], 2, "0", STR_PAD_LEFT).' '.$donnees['0'].'</h6>';	
					}
					?>
			</div>

			

		</div>
		
	</body>
	<style type="text/css">

		

		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 0px;
			margin-bottom: 10px;
			margin-top: 10px;
		}
		@media print
		{
			.btn{
				display: none;
			}
			
			p {
				margin-top : -5px;
			}
			.row h6{
				margin-top: -5px;
			}
			
		}
		td{
			border:1px solid black;
		}
		th{
			border:1px solid black;
		}
		
			img
			{
				margin-top: 10px;
			}
			p{
				

				margin-top : -5px;
			}
			.row{
				margin-top: -20px;
			}
	</style>
</html>