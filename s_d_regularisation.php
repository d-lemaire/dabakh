<?php
include 'connexion.php';
$req=$db->prepare("DELETE FROM d_regularisation WHERE id_reg=?");
$req->execute(array($_GET['id_reg'])) or die($req->errorInfo());
$nbr=$req->rowCount();
if ($nbr>0) 
{
	?>
	<script type="text/javascript">
		alert("Suppression effectuée");
		window.history.go(-1);
	</script>
	<?php
};
?>
