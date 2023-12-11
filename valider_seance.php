<!--<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<h1>Noter les élèves</h1></br></br></br>
-->
	<?php
	/*
		$seance_a_noter = $_POST['seance'];

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		include ('connexion.php');
		$infos_inscription_seance = mysqli_query($connect,"SELECT * FROM inscription WHERE inscription.idseance = $seance_a_noter"); // On sélectionne les lignes de la table inscription comportant la séance selectionnée
		if (!$infos_inscription_seance) {
			echo "Erreur: ".mysqli_error($connect);
			exit;
		}

		if (empty($infos_inscription_seance)) {
			echo "La notation est impossible car aucun élève n'a été inscrit à la séance sélectionnée !";
			exit;
		}
		// Formulaire pour noter les élèves inscrits à la séance

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='noter_eleves.php' >";
		echo "<tr><td><subtitles>Notez le nombre d'erreurs faites par chaque élève (champ vide = 0 fautes) :</td></tr><br>";

		foreach ($infos_inscription_seance as $seance)
		{
			$id_eleve_a_noter = $seance['ideleve'];
			// On selectionne les infos de l'élève en question
			$nom_etudiant_query = mysqli_query($connect,"SELECT * FROM eleves WHERE ideleve = $id_eleve_a_noter");
			if (!$nom_etudiant_query) {
				echo "Erreur: ".mysqli_error($connect);
				exit;
			}

			$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQLI_ASSOC);

			echo "<br><tr><td>L'élève ayant pour nom $nom_etudiant[1] et pour prénom $nom_etudiant[2] né(e) le $nom_etudiant[3] a pour note :</td><td><input type='number' name=$nom_etudiant[0]></td></tr>";
		}
		echo "<input type='hidden' name='seance' value=".$seance_a_noter.">";

		echo "<tr><td><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>


</body>
</html>
*/
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="themes.css">
</head>

<body>
    <h1>Noter les élèves</h1><br><br><br>

    <?php
        $seance_a_noter = $_POST['seance'];

        date_default_timezone_set('Europe/Paris');
        $date_actuelle = date("Ymd");

        include('connexion.php');

        $infos_inscription_seance = mysqli_query($connect, "SELECT * FROM inscription WHERE inscription.idseance = $seance_a_noter");

        if (!$infos_inscription_seance) {
            echo "Erreur: " . mysqli_error($connect);
            exit;
        }

        if (mysqli_num_rows($infos_inscription_seance) === 0) {
            echo "La notation est impossible car aucun élève n'a été inscrit à la séance sélectionnée !";
            exit;
        }

        // Formulaire pour noter les élèves inscrits à la séance
        echo "<table>";

        echo "<form method='POST' action='noter_eleves.php'>";
        echo "<tr><td><subtitles>Notez le nombre d'erreurs faites par chaque élève (champ vide = 0 fautes) :</subtitles></td></tr><br>";

        while ($seance = mysqli_fetch_assoc($infos_inscription_seance)) {
            $id_eleve_a_noter = $seance['ideleve'];

            // On sélectionne les infos de l'élève en question
            $nom_etudiant_query = mysqli_query($connect, "SELECT * FROM eleves WHERE ideleve = $id_eleve_a_noter");

            if (!$nom_etudiant_query) {
                echo "Erreur: " . mysqli_error($connect);
                exit;
            }

            $nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQLI_ASSOC);

            echo "<tr><td>L'élève ayant pour nom $nom_etudiant[nom] et pour prénom $nom_etudiant[prenom] né(e) le $nom_etudiant[dateNaiss] a pour note :</td><td><input type='number' min ='0' max ='40' name='notes[$id_eleve_a_noter]' required></td></tr>";
        }

        echo "<input type='hidden' name='seance' value='$seance_a_noter'>";
        echo "<tr><td><input type='submit' value='Valider'></td></tr>";
        echo "</form>";

        echo "</table>";

        mysqli_close($connect);
    ?>
</body>
</html>
