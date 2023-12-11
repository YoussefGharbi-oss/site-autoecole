<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <link href="style.css" rel="stylesheet">
  <meta charset="utf-8">
</head>
<?php
  include 'connexion.php';

  $ideleve = $_POST['eleve'];

  $infos_eleve = mysqli_query($connect, "select * from eleves where ideleve ='$ideleve'");
  if (!$infos_eleve) {
      echo "Impossible d'afficher les infomations de l'élève. Requête invalide. </n>". mysqli_error($connect);
      exit();
  }
  echo <<< EOT
  <h2>Elève </h2>
  <table>
  <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Date de naissance</th>
      <th>Date inscription</th>
  </tr>
  <tr>
  EOT;

  foreach ($infos_eleve as $col => $eleve) {
      echo "<td>".$col."</td>";
    }
    echo"</tr>";

  echo"</table>";
  echo <<< html
  <br>
  <table>
  <tr>
  <td><a href="consultation_eleve.php">
    <button type="button" class='button effacer'><span>Retour</span></button>
  </a></td>

  </tr>
  </table>
  html;

  mysqli_close($connect);
?>
