<?php
include 'connexion.php';
$req=$db->prepare('DELETE FROM consultation WHERE id_consultation=?');
$req->execute(array($_GET['id']));
?>
<script type="text/javascript">
	alert('Consultation annulée');
	window.location="l_consultation.php";
</script>
