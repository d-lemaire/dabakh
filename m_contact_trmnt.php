<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$telephone=htmlspecialchars($_POST['telephone']);
$mail=htmlspecialchars(strtoupper(suppr_accents($_POST['mail'])));
$contact=htmlspecialchars(strtoupper(suppr_accents($_POST['contact'])));
$autres_infos=htmlspecialchars(strtoupper(suppr_accents($_POST['autres_infos'])));


$req=$db->prepare('UPDATE contact SET contact=?, mail=?, autres_infos=?, telephone=?WHERE id=? ');
$nbr=$req->execute(array($contact, $mail, $autres_infos, $telephone, $_GET['id'])) or die(print_r($req->errorInfo()));
?>
<script type="text/javascript">
	alert('Contact modifié');
	window.location="l_contact.php";
</script>
	