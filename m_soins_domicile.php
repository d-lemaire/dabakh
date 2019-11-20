<?php
session_start();
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
    alert("Veillez d'abord vous connectez !");
    window.location = 'index.php';

</script>
<?php
}
$req=$db->prepare('SELECT * FROM soins_domicile WHERE id=?');
$req->execute(array($_GET['id']));
$donnees=$req->fetch();
$id=$donnees['0'];
$soins=$donnees['1'];
$pu=$donnees['2'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modificarion soins à domicile</title>
		<?php include 'entete.php';?>
	</head>
	<body>
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="col s4 m4 l4 ax white">
			<div class="container center-align ax ">
				<form method="POST" action="m_soins_domicile_trmnt.php?id=<?php echo $_GET['id'] ?>"   >
					
					<h3 class="center-align" >Modificarion d'un soins à domicile </h3>
					<div class="row">
						<div class="input-field col s5 " >
							<input required id="soins" type="text" class="validate " name="soins" value="<?= $soins ?>"  >
							<label for="soins">Soins</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s5 " >
							<input required id="pu" type="number" class="validate " name="pu" value="<?= $pu ?>"  >
							<label for="pu">Prix unitaire</label>
						</div>
					</div>
					
					<div class="input-field center-align col s5">
						<button class="btn  waves-light blue darken-4" type="submit" name="envoyer">Modifier
						<i class="material-icons right">send</i>
						</button>
					</div>
				</form>
				
			</div>
		</div>
	</body>
</html>