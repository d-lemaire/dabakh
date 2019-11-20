<?php
include 'supprim_accents.php';
$designation=suppr_accents(strtoupper(htmlspecialchars($_POST['designation'])));
$cout=$_POST['cout'];
try {
	include 'connexion.php';
	$req=$db->prepare('UPDATE hospitalisation SET designation=?, cout=? WHERE id=?');
	$req->execute(array($designation, $cout, $_GET['id'])) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreur".$e->message();
}
?>
	<script type="text/javascript">
	alert('Modification réussi');
	window.location="hospitalisation.php";
	</script>