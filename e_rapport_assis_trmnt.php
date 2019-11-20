<?php
session_start();
include 'connexion.php';

$id=htmlspecialchars($_POST['id']);
$r_patient=htmlspecialchars($_POST['r_patient']);
$r_famille=htmlspecialchars($_POST['r_famille']);
$r_personnel=htmlspecialchars($_POST['r_personnel']);
$conclusion=htmlspecialchars($_POST['conclusion']);
$date_rapport=htmlspecialchars($_POST['date_rapport']);
$infirmier=$_SESSION['prenom']." ".$_SESSION['nom'];
if ($r_patient=="") 
{
	$r_patient="Rien à signaler";
}

$req=$db->prepare('INSERT INTO rapport_consultation_domicile(date_rapport, r_patient, r_famille, r_personnel, conclusion, infirmier, id_consultation) VALUES(?,?,?,?,?,?,?)');
$req->execute(array($date_rapport, $r_patient, $r_famille, $r_personnel, $conclusion, $infirmier, $id)) or die(print_r($req->errorInfo()));
$id_rapport=$db->lastInsertId();
?>
<script type="text/javascript">
	alert('Rapport enregistré');
</script>
<?php
header("location:i_rapport_assis.php?id=".$id_rapport);
?>
