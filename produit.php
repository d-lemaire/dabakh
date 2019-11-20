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
		<title>Produit de l'établissement</title>
		<?php
		include 'entete.php';
		?>
		
	</head>
	<body class="blue-grey lighten-5">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class=" white">
			<div class="row">
				<h3 class="center-align col s12 m12"><u>Liste des produits de l'établissement </u></h3>
				<div class="col s4 offset-s1 input-field white" style="border-radius: 45px; border: 2px black solid">
					<i class="material-icons prefix">search</i>
					<input type="text" name="search" id="search">
					<label for="search">Produit</label>
				</div>
				<div class="col s12 m8	  ">
					<table class="bordered highlight centered ">
						<thead>
							<tr style="color: #0d47a1">
								<th  data-field="id"></th>
								<th data-field="">Produit</th>
								<th data-field="">Prix Unitaire</th>
								<th data-field="">Quantité</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						</table>
						</div>
						 <?php
					      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='secretaire'))
					      {
					        ?>
					      <li>
							<div class="col s12 m3   teal lighten-5" style="border-radius: 45px; border: 2px black solid">
								<div class=" center-align ">
									<form method="POST" action="produit_trmnt.php" name="ajout_nature"   >
										<p class="center-align" >Ajout produit</p>
										<div class="input-field  " >
											<input id="produit" type="text" class="validate " name="produit" >
											<label for="produit">Produit</label>
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

					      </li>
					      <?php
					      
					        }
					     
					        ?>
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
				function produit_ajax()
				{
					var search = $('input:first').val();
					$.ajax({
					type:'POST',
					url:'produit_ajax.php',
					data:'search='+search,
					success:function (html) {
						$('tbody').html(html);
					}
					});
				}
				produit_ajax();
				$('input:first').keyup(function(){
				produit_ajax();
				});
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