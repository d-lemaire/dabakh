<?php
session_start();
$_SESSION['service']="sante";
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
		<?php
		include 'entete.php';
		?>
	</head>
	<body style="background-image: url(<?=$image?>sante.jpg);">
		<?php include 'verification_menu_sante.php'; ?>
		
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