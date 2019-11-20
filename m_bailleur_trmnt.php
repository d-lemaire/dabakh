<?php
include 'connexion.php';
include 'supprim_accents.php';
$pourcentage=htmlspecialchars($_POST['pourcentage']);
$annee_inscription=htmlspecialchars($_POST['annee_inscription']);
$num_dossier=htmlspecialchars($_POST['num_dossier']);
$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
$telephone=htmlspecialchars($_POST['telephone']);
$cni=htmlspecialchars($_POST['cni']);
$date_debut=htmlspecialchars($_POST['date_debut']);
$adresse=htmlspecialchars(strtoupper(suppr_accents($_POST['adresse_bailleur'])));
$req=$db->prepare('UPDATE bailleur SET prenom=?, nom=?, tel=?, adresse=?, num_dossier=?,annee_inscription=?, pourcentage=?, cni=?, date_debut=? WHERE id=? ');
$req->execute(array($prenom,$nom,$telephone,$adresse,$num_dossier, $annee_inscription, $pourcentage, $cni, $date_debut, $_GET['id'])) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
?>
<script type="text/javascript">
	alert('bailleur modifié');
	window.location="l_bailleur.php";
</script>