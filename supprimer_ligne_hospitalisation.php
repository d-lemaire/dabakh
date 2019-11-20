<?php
include 'connexion.php';

if(isset($_GET['id_cons']))
{
	$req=$db->prepare("DELETE FROM consultation_hospitalisation WHERE id_consultation=? AND id_hospitalisation=?");
	$req->execute(array($_GET['id_cons'], $_GET['id_hos']));
}

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