<?php
include 'connexion.php';
$type=htmlspecialchars($_POST['type']);
$section=htmlspecialchars($_POST['section']);
$motif=htmlspecialchars(strtoupper($_POST['motif']));
$num_cheque=htmlspecialchars(strtoupper($_POST['num_cheque']));
$montant=htmlspecialchars($_POST['montant']);
$date_operation=htmlspecialchars($_POST['date_operation']);
$pj=htmlspecialchars($_POST['pj']);

$req=$db->prepare('UPDATE banque SET type=?, section=?, motif=?,num_cheque=?, montant=?,date_operation=?, pj=? WHERE id=?');
$nbr=$req->execute(array($type, $section, $motif, $num_cheque, $montant, $date_operation, $pj, $_GET['id'])) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Opération modifiée');
	window.location="etat_banque.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur operation non modifiée');
	window.location="banque.php";
</script>
<?php
}
?>