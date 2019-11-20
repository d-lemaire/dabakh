<?php
session_start();
include 'connexion.php';

$id=htmlspecialchars($_POST['id']);
$r_patient=htmlspecialchars($_POST['r_patient']);
$r_famille=htmlspecialchars($_POST['r_famille']);
$r_personnel=htmlspecialchars($_POST['r_personnel']);
$conclusion=htmlspecialchars($_POST['conclusion']);
$date_rapport=htmlspecialchars($_POST['date_rapport']);
$personnel=$_SESSION['prenom']." ".$_SESSION['nom'];
if ($r_patient=="") 
{
	$r_patient="Rien à signaler";
}

$req=$db->prepare('UPDATE rapport_consultation_domicile SET r_patient=?, r_personnel=?, r_famille=?, conclusion=?, date_rapport=? WHERE id=?');
$req->execute(array($r_patient, $r_personnel, $r_famille, $conclusion, $date_rapport, $id)) or die(print_r($req->errorInfo()));

?>
<script type="text/javascript">
	alert('Rapport modifié');
</script>
<?php
header("location:i_rapport_assis.php?id=".$id);
?>
