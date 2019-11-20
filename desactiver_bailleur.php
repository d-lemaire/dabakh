<?php
include 'connexion.php';
$id=htmlspecialchars($_GET['id']);
$etat=htmlspecialchars($_GET['etat']);
if ($etat=="activer") 
{
	$etat="desactiver";
}
else
{
	$etat="activer";
}

$req=$db->prepare('UPDATE bailleur SET etat=? WHERE id=? ');
$req->execute(array($etat,$id)) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();
?>
<script type="text/javascript">
	alert('bailleur <?=$etat?>');
	window.location="l_bailleur.php";
</script>