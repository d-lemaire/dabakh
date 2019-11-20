<?php
include 'supprim_accents.php';
$analyse=suppr_accents(strtoupper(htmlspecialchars($_POST['analyse'])));
$cout=$_POST['cout'];
try {
	include 'connexion.php';
	$req=$db->prepare('INSERT INTO analyse(analyse, cout) values (?,?) ');
	$req->execute(array($analyse, $cout)) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreu".$e->message();
}
?>
	<script type="text/javascript">
	alert('insrtion réussi');
	window.location="analyse.php";
	</script>