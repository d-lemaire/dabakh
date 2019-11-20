<?php
include 'connexion.php';
$req=$db->prepare('UPDATE mensualite SET montant=?, date_versement=?, mois=?, annee=?, type=? WHERE id= ?');
$req->execute(array($_POST['montant'], $_POST['date_versement'], $_POST['mois'], $_POST['annee'], $_POST['type'], $_GET['id']));
$nbr=$req->rowCount();
if ($nbr>0)
{
	$req=$db->prepare('UPDATE caisse_immo SET montant=?, date_operation=? WHERE id_mensualite=?');
	$req->execute(array($_POST['montant'], $_POST['date_versement'], $_GET['id']));
	?>
	<script type="text/javascript">
		alert('Mensualité modifiée');
		window.location="l_mensualite_paye.php";
	</script>
	<?php
}
else
	{
?>
<script type="text/javascript">
	alert('Mensualité non modifiée');
	window.history.go(-1);
</script>
<?php
}

?>