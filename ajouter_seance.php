<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="themes.css">
    <title>Ajout d'une séance</title>
  </head>
  <body>

    <?php

    function retourner_formulaire ($msg) {
      echo <<< EOT
      $msg
      <br>
      <p> Nous vous proposons de remplir le formulaire d'ajout de séance une nouvelle fois. </p>
      <br> <input type='button' onclick=\"window.location='ajout_seance.php'\" value="Réessayer d'ajouter une séance" />
      EOT; }



    $date_seance = $_POST['DateSeance'];
    $eff_max = $_POST['EffMax'];


    date_default_timezone_set('Europe/Paris');
    $date_a_verifier = New DateTime($date_seance);
    $date_actuelle = New DateTime(date('Y-m-d'));

    //  Sanity checks  (cohérence des données)
    if (!isset($_POST['menuChoixTheme'])) // si l'utilisateur ne choisit aucun thème
    {
      die(retourner_formulaire("Veuillez sélectionner un thème."));
    }

    if (empty($date_seance))
    {
      die(retourner_formulaire("Veuillez renseigner une date pour la séance."));
    }


    if (empty($eff_max))
    {
      die(retourner_formulaire("Veuillez renseigner l'effectif maximal de la séance."));
    }

    if (!is_numeric($eff_max))
    {
      die(retourner_formulaire("L'effectif maximal de la séance doit être un nombre."));
    }
    if ($eff_max < 1)
    {
      die(retourner_formulaire("L'effectif maximal de la séance doit être un nombre supérieur ou égal à 1."));
    }

    if ($date_a_verifier < $date_actuelle)
    {
      die(retourner_formulaire("Vous avez sélectionné une date dans la passé !"));
    }

    $idtheme = $_POST['menuChoixTheme'];

    include ('connexion.php');


    $requete_verif_seances = "SELECT * FROM seances WHERE DateSeance = '$date_seance' AND Idtheme = $idtheme";
    // echo "<br>$requete_verif_seances<br>";
    $verif_seance = mysqli_query($connect, $requete_verif_seances);
    if (!$verif_seance)
    {
      echo "La requête a échoué. Voici le code de l'erreur : <br>".mysqli_error($connect);
      exit;
    }
    $nb_seances_prob = mysqli_num_rows($verif_seance);
    echo "<br>$nb_seances_prob<br>";
    if ($nb_seances_prob > 0)
    {
      retourner_formulaire("Il est impossible d'ajouter la séance souhaitée, car une séance du même thème prévue le même jour a déjà été ajoutée.");
      mysqli_close($connect);
      exit;
    }

    $liste_seances = mysqli_query($connect, "SELECT * FROM seances");
    if (!$liste_seances)
    {
      echo "La requête a échoué. Voici le code de l'erreur : <br>".mysqli_error($connect);
      exit;
    }

    $requete_insertion = "insert into seances values(null, '".$date_seance."', '".$eff_max."', '".$idtheme."');";
    echo "<br>".$requete_insertion."<br>";
    $ajout_seance = mysqli_query($connect,$requete_insertion);
    if (!$ajout_seance) {
      echo "Insertion impossible ; votre requête est invalide. Voici le code de l'erreur : ".mysqli_error($result);
    }
    else {
      echo "L'ajout de la séance a été réalisé avec succès ! <br>";
    }


    mysqli_close($connect);
?>
  </body>
</html>
