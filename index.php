<!DOCTYPE html>
<html>
	<head>
		<title>Dabakh</title>
		<?php include 'entete.php'; ?>
	</head>
		<style type="text/css">
			body {
			background-image: url(<?=$image ?>background-3045402_1280.jpg) ;
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		
		}
		</style>
	<body>
		<div class="container">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div class="row">
				<a href="authentification_immo.php" class="col s12 m12 l6 btn  immobilier" ><i class="material-icons left" style="font-size: 100px">store_mall_directory</i>Dabakh Immobilier	
				</a>
				<a href="authentification_sante.php" class="col s12 m12 l6 btn  sante"><i class="material-icons left" style="font-size: 100px">local_hospital</i>Dabakh Santé	
				</a>
			</div>
		</div>
		
	</body>
	<style type="text/css">
		.btn{
			height: 200px;
			font: 35pt "times new roman";
		}
		.sante{
			background-color: #01579b ;
		}
		.immobilier{
			background-color: #795548 ;
		}
		.btn:hover{
			background-color: white;
		}
		.sante:hover{
			color: #01579b ;
		}
		.immobilier:hover{
			color: #795548  ;
		}
		
	</style>
</html>