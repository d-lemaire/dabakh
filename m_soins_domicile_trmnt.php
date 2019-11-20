<?php
include 'supprim_accents.php';
$soins=suppr_accents(strtoupper(htmlspecialchars($_POST['soins'])));
$pu=$_POST['pu'];
try {
	include 'connexion.php';
	$req=$db->prepare('UPDATE soins_domicile SET soins=?, pu=? WHERE id=?');
	$req->execute(array($soins, $pu, $_GET['id'])) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreu".$e->message();
}
?>
	<script type="text/javascript">
	alert('Modification réussi');
	window.location="soins_domicile.php";
	</script>