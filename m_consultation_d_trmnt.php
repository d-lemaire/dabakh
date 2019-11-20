<?php
session_start();
include 'connexion.php';
//recupération du prix du service dispensé

$id_consultation=$_POST['consultation'];
$date_consultation=$_POST['date_consultation'];
$poids=$_POST['poids'];
$tension=$_POST['tension'];
$pouls=$_POST['pouls'];
$temperature=$_POST['temperature'];
$dextro=$_POST['dextro'];
$tdr=$_POST['tdr'];
$cout_soins=$_POST['cout_soins'];
$cout_produit=$_POST['cout_produit'];
$allergie=$_POST['allergie'];
$plaintes=$_POST['plaintes'];
$remarques=$_POST['remarques'];
if ($cout_soins=="") 
{
	$cout_soins=0;
}
if ($cout_produit=="") 
{
	$cout_produit=0;
}
$montant=$cout_produit+$cout_soins;

$req=$db->prepare('UPDATE `consultation_domicile` SET `date_consultation`=?, `poids`=?, `tension`=?, `pouls`=?, `temperature`=?, dextro=?, `tdr`=?, `montant`=?, `reglement`="non", allergie=?, plaintes=?, remarques=? WHERE id_consultation=?');
$nbr=$req->execute(array($date_consultation, $poids, $tension, $pouls, $temperature, $dextro, $tdr, $montant, $allergie, $plaintes, $remarques, $id_consultation))  or die(print_r($req->errorInfo()));
	$req->closeCursor();
	if ($nbr>0) {
	?>
	<script type="text/javascript">
		alert('Soins modifié');
		window.location="l_consultation_d.php";
	</script>
	<?php
	}
	else
	{
	?>
	<script type="text/javascript">
		alert('Erreur soins non modifié');
		window.history.go(-1);
	</script>
	<?php
	}


?>