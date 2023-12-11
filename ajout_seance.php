<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="themes.css">
    <title>Ajout d'une séance</title>
  </head>
  <body>
    <h1>Ajout d'une séance</h1>
    <?php

      include ('connexion.php');

      $requete_liste_themes = "SELECT * FROM themes";
      // echo "<br>".$requete_liste_themes."<br>";
      $liste_themes = mysqli_query($connect, $requete_liste_themes);
      if (!$liste_themes)
      {
        echo "La requête a échoué. Voici le code de l'erreur : ". mysqli_error($connect);
        exit;
      }

      echo "<FORM METHOD='POST' ACTION='ajouter_seance.php' >";

      echo "<label for='DateSeance'>Veuillez choisir la date de la séance : </label>";
      echo "<input type='date' id='DateSeance' name='DateSeance' required> <br>";


      echo "<label for='EffMax'>Veuillez choisir l'effectif maximal de la séance : </label>";
      echo "<input type='number' id='EffMax' name='EffMax' min='0' required> <br>";

      // Tableau récapitulatif des thèmes actifs
          echo "<p class='texte'>Voici les thèmes actifs avec leurs descriptions respectives: </p>";
          echo "<table border='1'>";
          echo "<tr>";
          echo "<th> Thème </th>";
          echo "<th> Description </th>";
          echo "</tr>";
          while ($theme = mysqli_fetch_array($liste_themes, MYSQLI_ASSOC)){   // Tant que $theme contient une ligne de la table
            if (!$theme['supprime']) { // Si la colonne "supprime" vaut 0 (False)
              echo "<tr>";
              echo "<td>".$theme['nom']."</td><td>".$theme['descriptif']."</td>";
              echo "</tr>";
            }
          }
          echo "</table>";

      echo "<label for='menuChoixTheme'>Veuillez sélectionner le thème de la séance : </label>";
      echo "<SELECT id='menuChoixTheme' name='menuChoixTheme' size = '4' >";
      foreach ($liste_themes as $theme) {
        if (!$theme['supprime']) // si la colonne "supprime" vaut False
        {
          echo "<OPTION value='". $theme['idtheme'] . "'>". $theme['nom']. "</OPTION>";
        }
      }
      echo "</SELECT> <br>";

      echo "<INPUT type='submit' value='Enregistrer séance'>";
      echo "<INPUT type='reset' value='Réinitialiser'>";
      echo "</FORM>";
      mysqli_close($connect);
?>

  </body>
</html>
