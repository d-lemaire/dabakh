<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$motif=htmlspecialchars(strtoupper(suppr_accents($_POST['motif'])));
$mois=htmlspecialchars($_POST['mois']);
$annee=htmlspecialchars($_POST['annee']);
$type_depense=htmlspecialchars($_POST['type_depense']);
$date_depense=htmlspecialchars($_POST['date_depense']);
$montant=htmlspecialchars($_POST['montant']);
$id_user=$_SESSION['prenom']." ".$_SESSION['nom'];

$req=$db->prepare('INSERT INTO depense_locataire(motif, mois, annee, type_depense, date_depense, montant, id_locataire, id_user) values (?, ?, ?, ?, ?, ?, ?, ?) ');
$req->execute(array($motif, $mois, $annee, $type_depense, $date_depense, $montant,  $_GET['id'], $id_user)) or die(print_r($req->errorInfo()));
$id_depense_locataire=$db->lastInsertId();
$nbr=$req->rowCount();

$req=$db->prepare('INSERT INTO caisse_immo(type, section, motif, montant,date_operation, id_depense_locataire, id_user) values ("sortie","Depense locataire",?,?,?,?,?) ');
$req->execute(array($motif, $montant, $date_depense, $id_depense_locataire, $id_user)) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Dépense enregistrée');
	window.location="l_depense_locataire.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur dépense non enregistrée');
	window.history.go(-1);
</script>
<?php
}
?>