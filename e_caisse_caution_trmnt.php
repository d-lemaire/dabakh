<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$type=htmlspecialchars($_POST['type']);
$section=htmlspecialchars($_POST['section']);
$motif=htmlspecialchars(strtoupper(suppr_accents($_POST['motif'])));
$montant=htmlspecialchars($_POST['montant']);
$date_operation=htmlspecialchars($_POST['date_operation']);

$req=$db->prepare('INSERT INTO caisse_caution(type, section, motif, montant,date_operation) values (?,?,?,?,?) ');
$nbr=$req->execute(array($type, $section, $motif, $montant, $date_operation)) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Opération enregistrée');
	window.location="etat_caisse_caution.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur operation non enregistrée');
	window.history.go(-1);
</script>
<?php
}
?>