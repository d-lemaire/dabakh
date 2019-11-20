<?php
include 'connexion.php';
$prenom=htmlspecialchars(strtoupper($_POST['prenom']));
$nom=htmlspecialchars(strtoupper($_POST['nom']));
$telephone=htmlspecialchars($_POST['telephone']);
$cni=htmlspecialchars($_POST['cni']);
$annee_inscription=htmlspecialchars($_POST['annee_inscription']);
$num_dossier=htmlspecialchars($_POST['num_dossier']);
$statut=htmlspecialchars($_POST['statut']);
$req=$db->prepare('UPDATE locataire SET prenom=?, nom=?, tel=?, statut=?, num_dossier=?, annee_inscription=?, cni=? WHERE id=?');
$req->execute(array($prenom,$nom,$telephone, $statut, $num_dossier, $annee_inscription, $cni, $_GET['id'])) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Locataire modifié');
	window.location="l_locataire_actif.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur locataire non modifié');
	window.history.go(-1);
</script>
<?php
}
?>