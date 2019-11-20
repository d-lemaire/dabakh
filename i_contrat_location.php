<?php
$formatter = \NumberFormatter::create('fr_FR', \NumberFormatter::SPELLOUT);
$formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
$formatter->setAttribute(\NumberFormatter::ROUNDING_MODE, \NumberFormatter::ROUND_HALFUP);
include 'connexion.php';
$db->query("SET lc_time_names='fr_FR';");


$req=$db->prepare('SELECT * FROM `contrat` WHERE id=?');
$req->execute(array(2));
$donnees=$req->fetch();
$part1=$donnees['2'];
$part2=$donnees['3'];

$req=$db->prepare('SELECT  location.id, type_logement.type_logement, logement.adresse, CONCAT(day(location.date_debut)," ",monthname(location.date_debut)," ",year(location.date_debut)), logement.pu, CONCAT(bailleur.prenom," ",bailleur.nom), CONCAT(locataire.prenom," ", locataire.nom), location.caution, CONCAT(day(now())," ",monthname(now())," ",year(now())), location.type_contrat, location.id_user, locataire.cni
FROM `location`, logement, bailleur, locataire, type_logement 
WHERE logement.id_bailleur=bailleur.id AND location.id_logement=logement.id AND logement.id_type=type_logement.id AND location.id_locataire=locataire.id AND location.id=?
ORDER BY location.date_debut DESC');
	$req->execute(array($_GET['id']));
	$donnees=$req->fetch();
	$id=$donnees['0'];
	$designation=$donnees['1'];						
	$adresse=$donnees['2'];						
	$date_debut=$donnees['3'];
	$pu=$donnees['4'];
	$bailleur=$donnees['5'];
	$locataire=$donnees['6'];
	$caution=$donnees['7'];	
	$date_actuelle=$donnees['8'];	
	$type_location=$donnees['9'];	
	$id_user=$donnees['10'];	
	$cni=$donnees['11'];	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Location du <?=$date_debut ?></title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url(<?=$image ?>i_mensualite.png);">
		<a href="" class="btn "  onclick="window.print();">Imprimer</a>
		<a onclick="window.history.go(-1)" class="btn " >Retour</a>
		
	
	<div class="container white">
		<div class="row center white" style="margin-bottom: 1px" >
			<img class="col s8 offset-s2" src="../css/images/entete_immo.jpg" >
			<p class="col s12 right-align" style="font-family: 'times new roman'; font-size: 8px"><?=$id_user ?></p>
		</div>
		<div class="row">
			<h4 class="col s12 center"><b>CONTRAT DE LOCATION - <?=strtoupper($type_location) ?></b></h4>
			<div class="col s12" style="font: 12pt 'times new roman';">
				Entre les soussignés :
				<br>
				<br>
				Le cabinet, Agissant au Nom et pour le Compte de :
				<br>
				<br>
				Mr/Mme <b><?=$bailleur ?></b>
				<br>
				<br>
				Et
				<br>
				Mr/Mme/Mlle <b><?=$locataire ?> CNI <?=$cni?></b>
				<br>
				<br>
				Il a été arrêté et convenu ce qui suit :
				<br>
				<br>
				I.	L’agence donne en location au signataire :
				<br>
				<br>
				<b><?= $designation ?></b> à/au <b><?= $adresse ?></b>
				<br>
				<br>
				II.	le locataire a obligation de remplacer toutes les vitres et serrures Détériorés par ses propres frais, et de remettre en états des lieux, comme cela lui avait donné en location
				<br>
				<br>
				<?=nl2br($part2) ?>
			</div>
			<h6 class="col s12 right-align ">
			Fait le <b><?=$date_actuelle ?></b>
			</h6>
			<h6 class="col s6 left-align center"><b>Visas du locataire <br><br><br>Lu et approuvé</b></h6>
			<h6 class="col s6 right-align"><b>Visa du cabinet</b></h6>
		</div>
		
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function () {
		window.print();
	})
</script>
<style type="text/css">

	/*import du css de materialize*/
	@import "../css/materialize.min.css" print;
	/*CSS pour la page à imprimer */
	/*Dimension de la page*/
	@page
	{
		size: A4 portrait ;
		margin-top: 25px;
		margin-bottom: 25px;

	}
	@media print
	{
		.btn{
			display: none;
		}
		
	}
</style>
</html>