<?php
include 'connexion.php';
include 'supprim_accents.php';
$bailleur=htmlspecialchars(strtoupper($_POST['bailleur']));
$designation=htmlspecialchars(strtoupper(suppr_accents($_POST['designation'])));
$type_logement=htmlspecialchars($_POST['type_logement']);
$adresse=htmlspecialchars(strtoupper(suppr_accents($_POST['adresse'])));
$etat="libre";
$date_location=date('y')."-".date('m')."-".date('d');
	
$req=$db->prepare('UPDATE logement SET designation=?, adresse=?, id_type=?, id_bailleur=? WHERE id=? ');
$req->execute(array($designation, $adresse, $type_logement, $bailleur, $_GET['id'])) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Logement modifié');
	window.location="l_logement.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur logement non modifié');
	window.location="l_logement.php";
</script>
<?php
}
?>