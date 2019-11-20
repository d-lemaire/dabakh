<?php
session_start();
include 'connexion.php';
if (isset($_POST['login']))
{

	$req=$db->prepare('SELECT *  FROM personnel WHERE login=? AND pwd=? AND service="sante" OR login=? AND pwd=? AND service="service general" AND etat="activer"');
	$req->execute(array($_POST['login'], sha1($_POST['pwd']), $_POST['login'], sha1($_POST['pwd']))) or die(print_r($req->errorInfo()));
	$num_of_rows = $req->rowCount() ;
	
	if ($num_of_rows<1)
	{
		?>
		<script type="text/javascript">
		alert("Login et/ou mot de passe Incorrect");
		window.location="authentification_sante.php";
		</script>
		<?php
	}
	elseif ($num_of_rows>0)
	{
		$donnees= $req->fetch();
		$_SESSION['id']=$donnees['0'];
		$_SESSION['nom']=$donnees['2'];
		$_SESSION['prenom']=$donnees['1'];
		$_SESSION['fonction']=$donnees['3'];
		$_SESSION['service']="sante";
		//service en tant que tel
		$_SESSION['service1']=$donnees['8'];
		if (!isset($_COOKIE['login']) OR $_COOKIE['login']!=$_POST['login'])
		{
			setcookie('login',htmlspecialchars($_POST['login']),time() + 10*24*3600,null, null, false, true); //création du cookie
		}
		?>
	<script type="text/javascript">
	//window.location="sante.php";
	</script>
	<?php
		header("location:sante.php?a=a");
	}
}
else
{
	?>
	<script type="text/javascript">
	alert("Login et/ou mot de passe Incorrect");
	window.location="authentification_sante.php";
	</script>
	<?php
}
?>