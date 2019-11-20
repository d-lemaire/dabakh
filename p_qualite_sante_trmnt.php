<?php
include 'supprim_accents.php';
$remarque_suggestion=suppr_accents(htmlspecialchars($_POST['remarque_suggestion']));
$service=$_POST['service'];
$infirmier=$_POST['infirmier'];
try {
	include 'connexion.php';
	$req=$db->prepare('UPDATE consultation_domicile SET service=?, remarque_suggestion=?, infirmer=? WHERE id_consultation=?');
	$req->execute(array($service, $remarque_suggestion, $infirmier, $_GET['id'])) or die(print_r($req->errorInfo()));
	} catch (Exception $e) {
	echo "erreu".$e->message();
}
?>
	<script type="text/javascript">
	alert('Insertion réussi');
	window.location="sante.php";
	</script>