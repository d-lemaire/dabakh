<?php
session_start();
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index';
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Enregistrement d'une opération</title>
        <?php include 'entete.php'; ?>
    </head>
    <body style="background-image: url(<?= $image?>p_qualite_sante.jpg);">
        <?php
        include 'verification_menu_sante.php';
        ?>
        <div class="container white">
            <div class="row z-depth-5" style="padding: 10px;">
                <h3 class="center">Politique de qualité</h3>
                <p style="border: 1px solid; padding: 10px">Sur une echelle de 1 à 10 noter s'il vous plaît votre de degré de satisfaction par rapport au service(s) dispensé(s) et à l'infirmier qui à pratiquer le(s) soins</p>
                <form action="p_qualite_sante_trmnt.php?id=<?= $_GET['id'] ?>" method="POST">
                    <div class="row">
                        <div class="col s12 m6">
                            <fieldset>
                                <legend>Qualité du service fournie</legend>
                                <p>
                                    <label>
                                        <input class="with-gap" value="1" name="service" type="radio"  />
                                        <span>1</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="2" name="service" type="radio"  />
                                        <span>2</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="3" name="service" type="radio"  />
                                        <span>3</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="4" name="service" type="radio"  />
                                        <span>4</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="5" name="service" type="radio"  />
                                        <span>5</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="6" name="service" type="radio"  />
                                        <span>6</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="7" name="service" type="radio"  />
                                        <span>7</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="8" name="service" type="radio"  />
                                        <span>8</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="9" name="service" type="radio"  />
                                        <span>9</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="10" name="service" type="radio"  />
                                        <span>10</span>
                                    </label>
                                </p>
                            </fieldset>
                        </div>
                        <div class="col s12 m6">
                            <fieldset>
                                <legend>Notation de l'infirmier(e)</legend>
                                <p>
                                    <label>
                                        <input class="with-gap" value="1" name="infirmier" type="radio"  />
                                        <span>1</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="2" name="infirmier" type="radio"  />
                                        <span>2</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="3" name="infirmier" type="radio"  />
                                        <span>3</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="4" name="infirmier" type="radio"  />
                                        <span>4</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="5" name="infirmier" type="radio"  />
                                        <span>5</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="6" name="infirmier" type="radio"  />
                                        <span>6</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="7" name="infirmier" type="radio"  />
                                        <span>7</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="8" name="infirmier" type="radio"  />
                                        <span>8</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="9" name="infirmier" type="radio"  />
                                        <span>9</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="with-gap" value="10" name="infirmier" type="radio"  />
                                        <span>10</span>
                                    </label>
                                </p>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10">
                          <textarea id="remarque_suggestion" name="remarque_suggestion" class="materialize-textarea"></textarea>
                          <label for="remarque_suggestion">Remarque(s) / Suggestion(s)</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s2">
                            <a href="sante.php"  onclick='return(confirm("Voulez-vous ignoré ce questionnaire ?"))'class="btn red lighteen-3">Ignorer</a>
                        </div>
                        <div class="col s2 offset-s6 input-field">
                            <input class="btn" type="submit" name="enregistrer" value="Enregistrer" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script type="text/javascript">
    $(document).ready(function() {
    $('#form').submit(function() {
    if (!confirm('Voulez-vous confirmer l\'enregistrement de cette opération ?')) {
    return false;
    }
    });
    $('select').formSelect();
    $('.datepicker').datepicker({
    autoClose: true,
    yearRange: [2017, 2020],
    showClearBtn: true,
    i18n: {
    nextMonth: 'Mois suivant',
    previousMonth: 'Mois précédent',
    labelMonthSelect: 'Selectionner le mois',
    labelYearSelect: 'Selectionner une année',
    months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
    weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    today: 'Aujourd\'hui',
    clear: 'Réinitialiser',
    cancel: 'Annuler',
    done: 'OK'
    },
    format: 'yyyy-mm-dd'
    });
    });
    </script>
</html>