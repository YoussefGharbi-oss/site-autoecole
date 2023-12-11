<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="themes.css">
  </head>
  <body>
    <?php
    $choix = $_POST['choix'];
  if (!isset($choix) || $choix == 1) {
    include('connexion.php');

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $dateNaiss = $_POST["naissance"];

    $nom_echap = mysqli_real_escape_string($connect, $nom);
    $prenom_echap = mysqli_real_escape_string($connect, $prenom);

    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d');

    $requete_ajout_eleve = "insert into eleves values (null,'$nom_echap','$prenom_echap','$dateNaiss', '$date')";


    $ajout_eleve = mysqli_query($connect, $requete_ajout_eleve);

    if (!$ajout_eleve)
    {
      echo "<br>Impossible d'ajouter l'élève. La requête a échoué. <br>  ".mysqli_error($connect);
      exit;
    }
    else
    {
       echo "<p>L'élève $nom $prenom né(e) le $dateNaiss a bien été ajouté.</p>";
    }
    mysqli_close($connect);
  }
    else {
      echo "<br><br><subtitle>Redirection vers l'accueil ...</subtitle><br><br><br>";
      echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
      exit;
    }
  ?>
  </body>
</html>
