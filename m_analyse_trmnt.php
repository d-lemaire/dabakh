<?php
include 'supprim_accents.php';
$analyse=suppr_accents(strtoupper(htmlspecialchars($_POST['analyse'])));
$cout=$_POST['cout'];
try {
	include 'connexion.php';
	$req=$db->prepare('UPDATE analyse SET analyse=?, cout=? WHERE id=?');
	$req->execute(array($analyse, $cout, $_GET['id'])) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreur".$e->message();
}
?>
	<script type="text/javascript">
	alert('Modification réussi');
	window.location="analyse.php";
	</script>