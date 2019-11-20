<?php
include 'connexion.php';
$type=htmlspecialchars($_POST['type']);
$section=htmlspecialchars($_POST['section']);
$motif=htmlspecialchars(strtoupper($_POST['motif']));
$montant=htmlspecialchars($_POST['montant']);
$date_operation=htmlspecialchars($_POST['date_operation']);

$req=$db->prepare('UPDATE caisse_caution SET type=?, section=?, motif=?, montant=?,date_operation=? WHERE id=?');
$nbr=$req->execute(array($type, $section, $motif, $montant, $date_operation,$_GET['id'])) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Opération modifiée');
	window.location="etat_caisse_caution.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur operation non modifiée');
	window.history.go(-1);
</script>
<?php
}
?>