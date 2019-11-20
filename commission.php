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
$annee= date('Y');
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
if(date("n")==12){
        $datefr=1;
        $annee=$annee+1;
 }
else{
$datefr = $mois[date("n")];
  }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Etat de la caisse commission</title>
   <?php include 'entete.php'; ?>
</head>
<body style=" background-image: url(<?=$image ?>m_consultation.jpg) ;">
    <?php
     include 'verification_menu_immo.php';
    ?>
    <div class="row">
        <br>
        <div class="col s12   ">
            <div class="row">
                <select class="browser-default col s2 m2 " name="annee">
                    <option value="" disabled>--Choisir Annee--</option>
                    <?php
                echo '<option value="'. $annee .'" selected>'. $annee .'</option>';
                echo '<option value="'. ($annee + 1) .'" >'. ($annee + 1) .'</option>';
               ?>
                </select>
                <a onclick="window.print()" href="" class="btn col s3 m2 offset-m7 offset-s3">Imprimer</a>
            </div>
            <table class="bordered highlight centered">
                <thead>
                    <tr>
                        <th colspan="5">
                            <h4 class="center" style="color: #0d47a1">Journal de la caisse commsission du mois de</h4>
                            <h5 class="row">
                                <select class="browser-default col s4 m2 offset-m5 offset-s4" name="mois" class="mois" style="background-color: transparent;">
                                    <?php
									for ($i=1; $i <= 12; $i++) {
										echo "<option value='$mois[$i]'";
													if ($mois[$i]==$datefr) {
														echo "selected";
													}
										echo">$mois[$i]</option>";
									}
									?>
                                </select>
                            </h5>
                        </th>
                    </tr>
                    <tr style="color: #0d47a1">
                        <th data-field="">Date versement</th>
                        <th data-field="">Bailleur</th>
                        <th data-field="">Montant</th>
                        <th data-field="">Commission</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</body>
<style type="text/css">
    select {
        font-family: georgia;
    }

    th {
        font: 16pt georgia;
        font-weight: bold;
    }

    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }

    table {
        background: white;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        function etat_caisse(mois, annee) {
            $.ajax({
                type: 'POST',
                url: 'commission_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        var mois = $('select:eq(1)').val();
        var annee = $('select:eq(0)').val();
        etat_caisse(mois, annee);

        $('select').change(function() {
            var mois = $('select:eq(1)').val();
            var annee = $('select:eq(0)').val();
         etat_caisse(mois, annee);
           
        });
        $('.tooltipped').tooltip();
    });

</script>
<style type="text/css">
    /*import du css de materialize*/
    @import "../css/materialize.min.css"print;

    /*CSS pour la page à imprimer */
    /*Dimension de la page*/
    @page {
        size: portrait;
        margin: 15px;
        margin-top: 25px;
    }

    @media print {
        .btn {
            display: none;
        }

        nav {
            display: none;
        }

        div {
            font: 12pt "times new roman";
        }

        select {
            border-color: transparent
        }
    }

</style>

</html>