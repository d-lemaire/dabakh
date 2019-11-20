<?php
include 'supprim_accents.php';
$designation=suppr_accents(strtoupper(htmlspecialchars($_POST['designation'])));
$cout=$_POST['cout'];
try {
	include 'connexion.php';
	$req=$db->prepare('INSERT INTO hospitalisation(designation, cout) values (?,?) ');
	$req->execute(array($designation, $cout)) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreu".$e->message();
}
?>
	<script type="text/javascript">
	alert('insrtion réussi');
	window.location="hospitalisation.php";
	</script>