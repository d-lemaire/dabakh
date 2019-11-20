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
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Soins externes</title>
		<?php
		include 'entete.php';
		?>
		
	</head>
	<body class="blue-grey lighten-5">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="container white">
			<div class="row">
				<div class="col s12 m8	  ">
					<p class="center-align">Soins externes</p>
					<table class="bordered highlight centered ">
						<thead>
							<tr>
								<th  data-field="id"></th>
								<th data-field="">Soins</th>
								<th data-field="">Prix Unitaire</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'connexion.php';
							$reponse=$db->query('SELECT * FROM soins_externes order by soins');
							while ($donnees= $reponse->fetch()) {
								$id=$donnees['0'];
									$soins=$donnees['1'];
									$pu=$donnees['2'];
									echo "<tr onmouseover='afficher_bt_modifier(this)' onmouseout='cacher_bt_modifier(this)'>";
										echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_soins_externes.php?id=$id'><i class='material-icons left'>edit</i>Modifier</a> </td>";
										echo "<td>".$soins."</td>";
										echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
										echo "<tr>";}
									?>
								</tbody>
							</table>
							<?php
								if (!isset($id)) 
								{
									echo "<h3 class='center'>Aucun soins externe enregistré</h3>";
								}
								?>
						</div>
						
						<div class="col s12 m4 ">
							<div class="container center-align ">
								<form method="POST" action="soins_externes_trmnt.php" name="ajout_nature"   >
									<p class="center-align" >Ajout Soins</p>
									<div class="input-field  " >
										<input id="soins" type="text" class="validate " name="soins" >
										<label for="soins">Soins</label>
									</div>
									<div class="input-field  " >
										<input id="pu" type="text" class="validate " name="pu" >
										<label for="pu">Prix Unitaire</label>
									</div>
									<div class="input-field center-align">
										<button class="btn  waves-light blue darken-4" type="submit" name="envoyer">Ajouter
										<i class="material-icons right">send</i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</body>
			<script type="text/javascript">
				//fonction permettant d'afficher le boutton supprimer au survol d'une ligne
				/*function afficher_bt_modifier(ligne) {
					var bt= ligne.lastChild;
					bt.classList.remove('hide');
				}
				function cacher_bt_modifier(ligne) {
					var bt= ligne.lastChild;
					bt.classList.add('hide');
				}*/
				$('.tooltipped').tooltip();
			</script>
			<style type="text/css">
				.centrer{  margin:  auto;
			width: 800px;
			height: 25px;
			position: relative;
			right: 15%;
			
			}
			.ajout{
					position: fixed;
					right: 50px;
					top: 20%;
			}
			p {
			color: red;
			font-size: 28px;
			font-family: Cambria, Georgia, serif;
			}
			</style>
		</html>