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
$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),' ',monthname(patient.date_naissance),' ',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, patient.telephone, patient.sexe, patient.situation_matrimoniale, consultation.poids, consultation.temperature, consultation.pouls, consultation.tension, consultation.glycemie, consultation.tdr, consultation.plaintes, CONCAT(day(consultation.date_consultation), ' ', monthname(consultation.date_consultation),' ', year(consultation.date_consultation)), consultation.ant_medicaux, consultation.ant_chirurgicaux, consultation.traitement_cours, consultation.allergie, consultation.histoire_maladie, consultation.neurologie, consultation.hemodynamique, consultation.respiratoire, consultation.autres_appareils, consultation.ecg, consultation.biologie, consultation.radiographie, consultation.tdm,  consultation.echographie, consultation.autres_examen, consultation.id_service, consultation.traitement, consultation.evolution, consultation.traitement_sortie, consultation.resume, consultation.resume 
FROM `consultation`, patient
WHERE patient.id_patient=consultation.id_patient AND consultation.id_consultation=?");
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
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Infos consultation du <?=$date_consultation ?></title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url('<?=$image ?>i_consultation.png'); font: 12pt 'times new roman';">
		<a href="" class="btn" onclick="window.print();">Imprimer</a>
		&nbsp &nbsp &nbsp
		<a href="" class="btn" onclick="window.close();">Fermer</a>
		<div class="container  white" style="padding:  10px">
			
			<!--
			<table>
				<tr>
					<td class="" rowspan="5" class="center">
						<img src="../css/images/logo_sante.jpg" width="140px" height="140px"><br>
					Parcelles Unités 14 N°348<br>
					Immeuble BHS 1er étage
					</td>
					<td class="center">STRUCTURE SANITAIRE CHERIF OUSSEYNOU LAYE SYSTEME DE MANAGEMENT QUALITE (SMQ)</td>
					<td>Cabinet d'aides, de soins, de consultation, de médecinegénérale et de soins à domicile</td>
				</tr>
				<tr>
					<td rowspan="3" class="center" height="40px">
						AUTO : N° 11006  /  11007 / 11008 DU 02/12/09MSP/DS/DM/DMPMTMTMT<br>
						AUTO : N°16703 DU 20/05/14/MINT/DGAT/DLP/DLA-PA<br>
						TEL : 33 835 99 49 / 76 330 41 13 / 77 093 87 18 / NINEA : 29374752e6<br>
						EMAIL : gdiappalm@hotmail.com 
					</td>
					<td>Date d'application : 01/01/2019</td>
				</tr>
				<tr>
					<td>Validé par : Administration</td>
				</tr>
				<tr>
					<td>DOSSIER FICHE N° : /19</td>
				</tr>
				<tr>
					<td class="center"><b>FACTURE N°001</b></td>
					<td>TEL :</td>
				</tr>
			</table>
			-->
			<div class="row center " >
				<img class="col s12" src="../css/images/entete.jpg" >
			</div>
			<h4 class="center">Consultation du <?=$date_consultation ?></h4>
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
				<div class="col s2">Température : <b><?=$temperature ?></b></div>
				<div class="col s2">Glycémie : <b><?=$glycemie ?></b></div>
				<div class="col s2">TDR : <b><?=$tdr ?></b></div><br><br>
				<p class="col s12"><b>Plaintes : </b><?= nl2br($plaintes)?></p>
			</div>


			<div class="row">
				<h6 class="col s12"><b><u>Histoire de la maladie</u></b></h6>
				<?=nl2br($histoire_maladie)?>
			</div>
			<div class="row">
				<h6 class="col s12"><b><u>Antécedant</u></b></h6>
				<p class="col s12"><u>Medicaux :</u> &nbsp<?=$ant_medicaux?></p> 
				<p class="col s12"><u>Chirurgicaux :</u> &nbsp<?=$ant_chirurgicaux ?></p>
				<p class="col s12"><u>Traitement en cours :</u> &nbsp<?=$traitement_cours ?></p>
				<p class="col s12"><u>Allergie :</u> &nbsp<?=$allergie ?></p>
			</div>

			<div class="row">
				<h6 class="col s12"><b><u>Examen des appareils</u></b></h6>
				<p class="col s12"><u>Neurologie :</u><?=$neurologie ?></p>
				<p class="col s12"><u>Hemodynamique :</u> &nbsp<?=$hemodynamique ?></p>
				<p class="col s12"><u>Respiratoire :</u> &nbsp<?=$respiratoire ?></p>
				<p class="col s12"><u>Autres appareils :</u> &nbsp<?=$autres_appareils ?></p>
			</div>
			
			<div class="row">
				<h6 class="col s12"><b><u>Examens complémentaires</u></b></h6>
				<p class="col s12"><u>ECG :</u> &nbsp<?=$ecg ?></p>
				<p class="col s12"><u>Biologie :</u> &nbsp<?=$biologie ?></p>
				<p class="col s12"><u>Radiographie :</u> &nbsp<?=$radiographie ?></p>
				<p class="col s12"><u>TDM : </u> &nbsp<?=$tdm ?></p>
				<p class="col s12"><u>Echographie :</u> &nbsp<?=$echographie ?></p>
				<p class="col s12">Autres : &nbsp<?=$autres_examen ?></p>
				<p class="col s12"><b><u>Traitement :</u></b> &nbsp<?=$traitement ?></p>
			</div>
			<div class="row">
				<p class="col s12"><u>Evolution :</u> &nbsp<?=$evolution ?></p>
				<p class="col s12"><u>Traitement de sortie :</u> &nbsp<?=$traitement_sortie ?></p>
				<p class="col s12"><b><u>Résumé</u></b> <br> <?=nl2br($resume)?></p>
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