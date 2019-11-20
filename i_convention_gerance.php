<?php
$formatter = \NumberFormatter::create('fr_FR', \NumberFormatter::SPELLOUT);
$formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
$formatter->setAttribute(\NumberFormatter::ROUNDING_MODE, \NumberFormatter::ROUND_HALFUP);
include 'connexion.php';
	$db->query("SET lc_time_names='fr_FR';");

	$req=$db->prepare('SELECT * FROM `contrat` WHERE id=?');
	$req->execute(array(1));
	$donnees=$req->fetch();
	$part1=$donnees['2'];
	$part2=$donnees['3'];

	$req=$db->prepare('SELECT CONCAT(bailleur.prenom," ",bailleur.nom),bailleur.cni, CONCAT(day(bailleur.date_debut)," ",monthname(bailleur.date_debut)," ",year(bailleur.date_debut)), CONCAT(day(now())," ",monthname(now())," ",year(now()))
		FROM bailleur 
		WHERE bailleur.id=?');
	$req->execute(array($_GET['id']));
	$donnees=$req->fetch();
	$bailleur=$donnees['0'];
	$cni=$donnees['1'];						
	$date_debut=$donnees['2'];						
	$date_actuelle=$donnees['3'];						
	$req->closeCursor();

	$req=$db->prepare('SELECT CONCAT(bailleur.prenom," ", bailleur.nom), type_logement.type_logement, logement.designation, logement.adresse,(logement.nbr+ logement.nbr_occupe), logement.pu
						FROM bailleur, logement, type_logement
						WHERE bailleur.id=logement.id_bailleur AND logement.id_type=type_logement.id AND bailleur.id=?');
	$req->execute(array($_GET['id']));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Location du <?=$date_debut ?></title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url(<?=$image ?>i_mensualite.png);">
		<a href="" class="btn "  onclick="window.print();">Imprimer</a>
		<a href="l_bailleur.php" class="btn " >Retour au menu</a>
		
	
	<div class="container white">
		<div class="row center white" style="margin-bottom: 1px" >
			<img class="col s8 offset-s2" src="../css/images/entete_immo.jpg" >
		</div>
		<div class="row">
			<h5 class="col s12 center"><b>CONTRAT DE REPRESENTATION
										<br>CONVENTION DE GERANCE IMMOBILIERE
			</b>
		</h5>
			<div class="col s12" style="font: 12pt 'times new roman';">
				Par ce présent contrat
				<br>
				<b><?=$bailleur ?> CNI : <?=$cni ?></b>
				<br>
				<?=nl2br($part1) ?>
				<br>
				<?php
					while ($donnees=$req->fetch()) 
					{
						echo "<b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-".(str_pad($donnees['4'], 2,"0", STR_PAD_LEFT))." ".ucfirst(strtolower($donnees['1']))." à/au ".ucfirst(strtolower($donnees['3']))."</b>";
						echo "<br>";
					}
				?>
				<?=nl2br($part2) ?>

			</div>
			<h6 class="col s12 right-align ">
			Fait le <b><?=$date_actuelle ?></b>
			</h6>
			<h6 class="col s6 left-align center"><b>Visas du propiétaire <br><br><br>Lu et approuvé</b></h6>
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
		margin-bottom: 50px;

	}
	@media print
	{
		.btn{
			display: none;
		}
		
	}
</style>
</html>