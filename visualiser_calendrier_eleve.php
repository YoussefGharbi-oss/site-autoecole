
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Visualisation calendrier</title>
    <link rel="stylesheet" href="style.css">
  </head>
<body>
  <h1> Visualiser le calendrier d'un élève : </h1>
  <h2> Calendrier de l'élève </h2>
  <?php
  //connexion à la base de données
  include("connexion.php");

  //transmission des données du formulaire
  $ideleve = $_POST["ideleve"];

  //transmission de la date
  date_default_timezone_set('Europe/Paris');
  $datea = date("Y-m-d");

  //vérification des données
  if (empty($ideleve)){
    echo "<p>Il faut sélectionner un élève !</p>";
    echo "<input type='button' onclick=\"window.location='accueil.html'\" value='Accueil' />";
    echo "<input type='button' onclick=\"window.location='visualisation_calendrier_eleve.php'\" value='Visualiser un calendrier' />";
    exit;
  }

  //sélection des inscriptions de l'élève dans le futur
  $requete_inscriptions_eleve = "SELECT * FROM inscription INNER JOIN seances ON seances.idseance=inscription.idseance INNER JOIN themes ON seances.idtheme=themes.idthemes WHERE DATEDIFF( `Dateseance` , '$datea' )>=0 AND ideleve=$ideleve";
  //idseance ideleve note idseance Dateseance Effmax idtheme idtheme nom supprime descriptif
  $inscriptions_eleve = mysqli_query($connect, $query);

  if (!$inscriptions_eleve){
   echo "<p>La requête n'a pas pu aboutir</p>".mysqli_error($connect);
   echo "<input type='button' onclick=\"window.location='accueil.html'\" value='Accueil' />";
   echo "<input type='button' onclick=\"window.location='visualisation_calendrier_eleve.php'\" value='Visualiser un calendrier' />";
   exit;
  }

  if (mysqli_num_rows$$inscriptions_eleve)==0){ // il n'y a pas d'inscription dans le futur
    echo"<p>L'élève n'est inscrit à aucune séance dans le futur</p>";
  }
  else{ // il y a des séances dans le futur
    //renvoie une table qui récapitule les informations des séances
    echo "<table class='table'>";
    echo "<tr><th>Thème de la séance</th> <th>Date de la séance</th></tr>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      echo "<tr>";
      echo "<td>$row['nom']</td>";
      echo "<td>$row['DateSeance']</td>";
      echo "</tr>";
      }
    echo "</table>";
    echo "<br>";
  }

  // boutons pour naviguer entre les tables
  echo "<input type='button' onclick=\"window.location='accueil.html'\" value='Accueil' />";
  echo "<input type='button' onclick=\"window.location='visualisation_calendrier_eleve.php'\" value='Visualiser un calendrier' />";

  mysqli_close($connect);

  ?>
</body>
</html>
