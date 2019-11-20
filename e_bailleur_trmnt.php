<?php
include 'connexion.php';
include 'supprim_accents.php';
$annee_inscription=htmlspecialchars($_POST['annee_inscription']);
$num_dossier=htmlspecialchars($_POST['num_dossier']);
$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
$telephone=htmlspecialchars($_POST['telephone']);
$pourcentage=htmlspecialchars($_POST['pourcentage']);
$cni=htmlspecialchars($_POST['cni']);
$date_debut=htmlspecialchars($_POST['date_debut']);
$adresse=htmlspecialchars(strtoupper(suppr_accents($_POST['adresse'])));
$req=$db->prepare('INSERT INTO bailleur(prenom, nom, tel, adresse, num_dossier,annee_inscription, pourcentage, etat, cni, date_debut) values (?,?,?,?,?,?,?,"activer",?, ?) ');
$req->execute(array($prenom,$nom,$telephone,$adresse,$num_dossier, $annee_inscription, $pourcentage, $cni, $date_debut)) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
$id=$db->lastInsertId();
if ($nbr>0) 
{
	header("location:e_logement.php?id=$id");

}
else
{
?>
<script type="text/javascript">
	alert('Erreur bailleur non enregistré');
	window.history.go(-1);
</script>
<?php
}
?>