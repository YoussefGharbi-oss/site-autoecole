<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link href="style.css" rel="stylesheet">
  <title></title>
</head>
<?php
  include ('connexion.php');
  $id_theme_a_supprimer = mysqli_real_escape_string($_POST['idtheme']);

  $requete_suppression_theme = "UPDATE themes SET supprime = 1 WHERE idtheme = $id_theme_a_supprimer";
  $suppression_theme = mysqli_query($connect, $requete_suppression_theme);
  if (!$suppression_theme) {
    echo "<br>Erreur: ".mysqli_error($connect);
    mysqli_close($connect);
    exit;
  }

  else {
    echo <<< EOT
    <br>
    <p> Le thème a été supprimé auparavant ! </p>
    <table>
    <tr>
    <td>
    <a href="acceuil.html" >
    <button type="button"><span>Accueil</span></button>
    </a>
    </td>
    <td>
    <a href="suppression_theme.php" >
    <button type="button" ><span>Recommencer</span></button>
    </a>
    </td>
    </tr>
    <table>
    EOT;
  }
  mysqli_close($connect);

?>
