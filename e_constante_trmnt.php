<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_prise=htmlspecialchars($_POST['date_prise']);
$heure_prise=htmlspecialchars($_POST['heure_prise']);
$pouls=htmlspecialchars($_POST['pouls']);
$tension=htmlspecialchars($_POST['tension']);
$dextro=htmlspecialchars($_POST['dextro']);
$temperature=htmlspecialchars($_POST['temperature']);
$conscience=htmlspecialchars(strtoupper(suppr_accents($_POST['conscience'])));
$vomissement=htmlspecialchars(strtoupper(suppr_accents($_POST['vomissement'])));
$diarrhee=htmlspecialchars(strtoupper(suppr_accents($_POST['diarrhee'])));

$req=$db->prepare('INSERT INTO constante (date_prise, heure_prise, pouls, tension, temperature, dextro, conscience, vomissement, diarrhee, id_patient,  id_infirmier) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
$req->execute(array($date_prise, $heure_prise, $pouls, $tension, $temperature, $dextro, $conscience, $vomissement, $diarrhee,$_GET['id'], $_SESSION['id'])) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Constante');
	window.location="l_constante.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur constante non enregistrée');
	window.history.go(-1);
</script>
<?php
}
?>