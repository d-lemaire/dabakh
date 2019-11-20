<?php session_start();
if ($_SESSION['id']=='') {
	header("location:index.php");
} ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Analyse</title>
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
					<p class="center-align">Analyses</p>
					<table class="bordered highlight centered ">
						<thead>
							<tr>
								<th  data-field="id"></th>
								<th data-field="">Analyse</th>
								<th data-field="">Coût</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'connexion.php';
							$reponse=$db->query('SELECT * FROM analyse order by analyse');
							while ($donnees= $reponse->fetch()) {
								$id=$donnees['0'];
									$analyse=$donnees['1'];
									$cout=$donnees['2'];
									echo "<tr onmouseover='afficher_bt_modifier(this)' onmouseout='cacher_bt_modifier(this)'>";
										echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_analyse.php?id=$id'><i class='material-icons left'>edit</i>Modifier</a> </td>";
										echo "<td>".$analyse."</td>";
										echo "<td>".number_format($cout,0,'.',' ')." Fcfa</td>";
										echo "<tr>";}
									?>
								</tbody>
							</table>
							<?php
								if (!isset($id)) 
								{
									echo "<h3 class='center'>Aucune analyse enregistrée</h3>";
								}
								?>
						</div>
						
						<div class="col s12 m4 ">
							<div class="container center-align ">
								<form method="POST" action="analyse_trmnt.php" >
									<p class="center-align" >Ajout analyse</p>
									<div class="input-field  " >
										<input id="analyse" type="text" class="validate " name="analyse" >
										<label for="analyse">Analyse</label>
									</div>
									<div class="input-field  " >
										<input id="cout" type="text" class="validate " name="cout" >
										<label for="cout">Coût </label>
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