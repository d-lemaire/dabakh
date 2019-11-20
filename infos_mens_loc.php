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
$req=$db->prepare('SELECT CONCAT(locataire.prenom," ", locataire.nom) FROM locataire WHERE id=?');
$req->execute(array($_GET['id']));
$donnee=$req->fetch();
$locataire=$donnee['0'];
$req->closeCursor();

$req=$db->prepare('SELECT location.id FROM locataire, location 
WHERE location.id_locataire=locataire.id AND locataire.id=?');
$req->execute(array($_GET['id']));
$donnee=$req->fetch();
$id_location=$donnee['0'];
$req->closeCursor();

$db->query("SET lc_time_names = 'fr_FR';");
$req=$db->prepare('SELECT mensualite.mois, CONCAT(day(mensualite.date_versement), " " , monthname(mensualite.date_versement), year(mensualite.date_versement)), mensualite.montant, logement.designation, logement.adresse, type_logement.type_logement, CONCAT(bailleur.prenom," ", bailleur.nom),  mensualite.id
FROM locataire, location, logement, type_logement, mensualite, bailleur
WHERE locataire.id=location.id_locataire AND location.id_logement=logement.id AND logement.id_type=type_logement.id AND location.id=mensualite.id_location AND logement.id_bailleur=bailleur.id  
AND locataire.id=?');
$req->execute(array($_GET['id'])) OR die($req->errorInfo());

?>
<!DOCTYPE html>
<html>
<head>
	<title>Infos des mensualités</title>
	<?php include 'entete.php'; ?>
</head>
<body style="background-image: url('<?=$image ?>infos_mens_loc.png');">
	<?php
		include 'verification_menu_immo.php';
		?>
		<br>
		<a class="btn brown" onclick="window.history.go(-1)">Retour</a>
	<div class="container white" style="padding-bottom: 40px">
		<br>
		<div class="row">
			<a class="btn col s8 m4 brown"  href="i_fac_ins_loc.php?id=<?=$id_location ?>">Facture locative</a>
			&nbsp&nbsp&nbsp&nbsp
			<a class="btn col s8 m4 offset-m1 brown" href="i_contrat_location.php?id=<?=$id_location ?>">Contrat location</a>
		</div>
		<div class="row">
			<h5 class="col s12 center">Mensualité(s) payé</h5>
		</div>
		<div class="row">
			<table class="col s10 offset-s1">
				<thead>
					<th>Date payement</th>
					<th>Mois</th>
					<th>Montant</th>
					<th>Logement</th>
					<th>Bailleur</th>
				</thead>
				<tbody>
					<?php
						while ($donnees=$req->fetch()) 
						{
							$mois=$donnees['0'];
							$date_versement=$donnees['1'];
							$montant=$donnees['2'];
							$designation=$donnees['3'];
							$adresse=$donnees['4'];
							$type_logement=$donnees['5'];
							$bailleur=$donnees['6'];
							$id=$donnees['7'];
							echo "<tr>\n";
								echo "<td>".$date_versement."</td>\n";
								echo "<td>".$mois."</td>\n";
								echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>\n";
								echo "<td>".$type_logement." : ".$designation." à ".$adresse."</td>\n";
								echo "<td>".$bailleur."</td>\n";
								echo "<td> <a target='_blank' class='btn' href='i_mensualite.php?id=$id'><i class='material-icons left'></i> Facture</a> </td>";
							echo "</tr>\n";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
<style type="text/css">
	td{
			text-align: center;
			border:1px solid black;
		}
		
		th{
			text-align: center;
			border:1px solid black;
		}
</style>
</html>