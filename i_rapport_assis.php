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
$reponse=$db->prepare("SELECT patient.id_patient, patient.prenom, patient.nom, CONCAT(day(patient.date_naissance),' ',monthname(patient.date_naissance),' ',year(patient.date_naissance)), patient.lieu_naissance, patient.profession, patient.domicile, CONCAT(day(consultation_domicile.date_consultation), ' ', monthname(consultation_domicile.date_consultation),' ', year(consultation_domicile.date_consultation)), CONCAT(day(rapport_consultation_domicile.date_rapport),' ',monthname(rapport_consultation_domicile.date_rapport),' ',year(rapport_consultation_domicile.date_rapport)), rapport_consultation_domicile.r_patient, rapport_consultation_domicile.r_famille, rapport_consultation_domicile.r_personnel, rapport_consultation_domicile.conclusion, rapport_consultation_domicile.infirmier
FROM consultation_domicile, patient, rapport_consultation_domicile
WHERE patient.id_patient=consultation_domicile.id_patient AND consultation_domicile.id_consultation=rapport_consultation_domicile.id_consultation AND rapport_consultation_domicile.id=?");
$reponse->execute(array($_GET['id']));
$donnees=$reponse->fetch();
$id_patient=$donnees['0'];
$patient=$donnees['1']." ".$donnees['2'];
$date_naissance=$donnees['3'];
$lieu_naissance=$donnees['4'];
$profession=$donnees['5'];
$domicile=$donnees['6'];
$date_consultation=$donnees['7'];
$date_rapport=$donnees['8'];
$r_patient=$donnees['9'];
$r_famille=$donnees['10'];
$r_personnel=$donnees['11'];
$conclusion=$donnees['12'];
$infirmier=$donnees['13'];
$reponse->closeCursor();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rapport Soins à domicile du <?=$date_consultation ?></title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url('<?=$image ?>i_consultation.png'); font: 12pt 'times new roman';">
		<a href="" class="btn" onclick="window.print();">Imprimer</a>
		&nbsp &nbsp &nbsp
		<a  onclick="window.history.go(-1)" class="btn " >Retour</a>
		<?php
		if ($_SESSION['fonction']=="administrateur" or $_SESSION['fonction']=="daf") 
		{
			?>
			<a href="m_rapport_assis.php?id=<?= $_GET['id'] ?>" class="btn" >Modifier</a>
			<?php
		}
		?>
		<div class="container  white" style="padding:  10px">
			<div class="row center " >
				<img class="col s12" src="<?=$image ?>entete.jpg" >
				<div class="col s4 offset-s8">Dakar<?= $date_rapport ?></div>
			</div>
			<h4 class="center">Rapport d’assistance et de surveillance du patient à l’hôpital et/ou à domicile le <?=$date_consultation ?></h4>
			<br>
			<!--Dossier du patient -->
			<div class="row">
				<div class="col s5 " style="border: 1px solid">
					<h5 class="center">Infirmier(e)</h5>
					Prénom et Nom :<b><?=$infirmier?></b><br>
					<br>
					<br>
					<br>
				</div>
				<div class="col s6 offset-s1" style="border: 1px solid" >
					<h5 class="center">Patient(e)</h5>
					Prénom et Nom : <b><?=$patient?></b><br>
					Profession &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$profession?></b><br>
					Date de naissance : <b><?=$date_naissance. " à ". $lieu_naissance ?></b>
				</div>
			</div>
			<br>
			<div class="row" style="margin-left: 20px; margin-right: 20px;">
				<h6 class="col s12 ">
					<b><u>Remarques sur le patient</u></b><br>
				</h6>
				<h6>
					<?= nl2br($r_patient) ?>
				</h6>
				<br>
				<h6 class="col s12 ">
					<b><u>Remarques sur la famille du patient</u></b><br>
				</h6>
				<h6>
					<?= nl2br($r_famille) ?>
				</h6>
				<br>
				<h6 class="col s12 ">
					<b><u>Remarques sur le personnel hôspitalier</u></b><br>
				</h6>
				<h6>
					<?= nl2br($r_personnel) ?>
				</h6>
				<br>
				<h6 class="col s12 ">
					<b><u>Conclusion</u></b><br>
				</h6>
				<h6>
					<?= nl2br($conclusion) ?>
				</h6>
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