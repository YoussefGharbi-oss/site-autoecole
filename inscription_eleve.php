<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inscription d'un(e) élève à une séance</title>
  </head>
  <body>
    <h1>Inscription d'un(e) élève à une séance</h1> <br><br><br>
    <form action="inscrire_eleve.php" method="post">
    <label for="seances">Séances disponibles: </label>
    <select id="seances" name="idseance">
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

      date_default_timezone_set('Europe/Paris');
      $date_actuelle = date("Ymd");
      echo "<br>$date_actuelle<br>";

      include 'connexion.php';


      $requete_seances = "SELECT * FROM seances INNER JOIN themes ON seances.Idtheme = themes.idtheme WHERE themes.supprime = 0 and seances.DateSeance >= $date_actuelle";
      echo "<br>$requete_seances<br>";
      $seances = mysqli_query($connect, $requete_seances);
      if (!$seances){
        echo "Erreur: ".mysqli_error($connect);
        mysqli_close($connect);
        exit;
      }

      while ($row = mysqli_fetch_array($seances)) {
        $requete_inscriptions = "SELECT idseance FROM inscription WHERE idseance = $row[0]";
        echo "<br>$requete_inscriptions<br>";
        $inscriptions = mysqli_query($connect, $requete_inscriptions);
        if (!$inscriptions)
        {
          echo "Erreur: ".mysqli_error($connect);
          mysqli_close($connect);
          exit;
        }
        $nb_inscrits = mysqli_num_rows($inscriptions);
        if ($nb_inscrits < $row[2])
        {
          echo "<option value=$row[0]> Séance de thème $row[5] prévue à la date $row[1] </option>";
        }
    }


      echo "</select> <br>";
      echo "<label for='eleves'>Elèves: </label>";
      echo "<select id='eleves' name='ideleve'>";

      $requete_eleves = "SELECT * FROM eleves";
      echo "<br>$requete_eleves<br>";
      $eleves = mysqli_query($connect, $requete_eleves);
      if (!$eleves){
        echo "Erreur: ".mysqli_error($connect);
        mysqli_close($connect);
        exit;
      }
      while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM))
      {
        echo "<option value=$row[0]> $row[1] $row[2] né(e)  le $row[3] </option>";
      }

      echo "</select> <br> <br> <br>";
      echo "<input type='submit'> </form>";

      mysqli_close($connect);
     ?>
  </body>
</html>
