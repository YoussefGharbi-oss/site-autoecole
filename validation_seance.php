<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="themes.css">
</head>
<body>
  <h1>Noter les élèves</h1><br><br><br>

  <?php
  date_default_timezone_set('Europe/Paris');
  $date_actuelle = date("Ymd");

  include('connexion.php');

  // Requête SQL qui sélectionne toutes les séances du passé
  $requete_seances_dispos = "SELECT * FROM seances WHERE DateSeance < CURDATE()";
  // echo "<br> $requete_seances_dispos <br>";

  $seances_result = mysqli_query($connect, $requete_seances_dispos);
  if (!$seances_result)
  {
    echo "La requête a échoué. Voici le code de l'erreur : <br>".mysqli_error($connect);
    exit;
  }

  // Formulaire pour choisir une séance à valider
  echo "<table>";
  echo "<form method='POST' action='valider_seance.php' >";
  echo "<tr><td><label for='choix_seance'>Sélectionnez une séance</label></td>";
  echo "<td><select id='choix_seance' name='seance' border='1'>";

  while ($seance = mysqli_fetch_assoc($seances_result)) {
    $Idtheme = $seance['Idtheme'];
    $theme_seance_query = mysqli_query($connect, "SELECT * FROM themes WHERE idtheme = $Idtheme"); // requête pour obtenir les infos du thème de la séance

    if (!$theme_seance_query) {
      echo "La requête a échoué. Voici le code de l'erreur : <br>" . mysqli_error($connect);
      exit;
    }

    $theme_seance = mysqli_fetch_array($theme_seance_query, MYSQLI_ASSOC);

    echo "<option value='" . $seance['idseance'] . "'>Séance de " . $theme_seance['nom'] . " du " . $seance['DateSeance'] . "</option>";
  }

  echo "</select></td>";
  echo "</tr><tr><td><br><input type='submit' value='Valider'></td></tr>";
  echo "</form>";
  echo "</table>";

  mysqli_close($connect);
  ?>
</body>
</html>
