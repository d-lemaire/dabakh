<?php
include 'connexion.php';
$req=$db->prepare("DELETE FROM soins_domicile_patient WHERE id_consultation=? AND id_soins=?");
$req->execute(array($_GET['id_cons'], $_GET['id_soins']));

//header("location:m_consultation.php?id=".$id) ;
$nbr=$req->rowCount();
if ($nbr>0) 
{
	?>
	<script type="text/javascript">
		//alert("supprimer");
		window.history.go(-1);
	</script>
	<?php
};
?>