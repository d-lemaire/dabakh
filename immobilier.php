<?php
session_start();
$_SESSION['service']="immobilier";
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Index</title>
		<?php include 'entete.php'; ?>
	</head>
	<body>
		<?php include 'verification_menu_immo.php'; ?>
		<style type="text/css">
			body {
			background-image: url(<?=$image ?>immobilier.jpg) ;
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		
		}
		</style>
		
	</body>
	<?php
	if (isset($_GET['a'])) 
	{
		?>
		<script type="text/javascript">
			M.toast({html: 'Bonjour <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?>!', classes: 'rounded'});
		</script>
		<?php
	}
	?>
</html>