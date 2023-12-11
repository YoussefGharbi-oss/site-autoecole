<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<h1>Inscription d'un(e) élève à une séance</h1></br></br></br>

	<?php

		$eleve = $_POST['ideleve'];
		$seance = $_POST['idseance'];

    include ("connexion.php");

		$liste_eleves_de_seance = mysqli_query($connect,"SELECT * FROM inscription WHERE idseance = $seance");// requête pour avoir les lignes de la table inscription avec l'id de la séance choisie
		if(!$liste_eleves_de_seance)
		{
			echo "<br> Erreur: <br>".mysqli_error($connect);
			exit;
		}

		$verif_max_seance_query = mysqli_query($connect,"SELECT * FROM seances WHERE idseance = $seance"); //requête pour obtenir les infos de la séance choisie
		if(!$verif_max_seance_query)
		{
			echo "<br> Erreur: <br>".mysqli_error($connect);
			exit;
		}
		$verif_max_seance = mysqli_fetch_array($verif_max_seance_query, MYSQLI_NUM);
		$effectif_seance = mysqli_num_rows($liste_eleves_de_seance);

		if(!$seance)
		{
			echo "Erreur : aucune séance n'a été sélectionnée / n'est disponible.</br>";
		}
		else
		{
			if ($verif_max_seance[2] <= $effectif_seance) // On compare le nombre d'élèves déjà inscrits à l'effectif max
			{
				echo "Impossible d'inscrire l'élève ; la séance est complète, l'effectif maximal est atteint.</br>";
			}
			else
			{
				if (!$eleve)
				{
					echo "Erreur : aucun élève n'a été sélectionné / n'est disponible.</br>";
				}
				else
				{
					$deja_inscrit_query = mysqli_query($connect,"SELECT * FROM inscription WHERE idseance = $seance and ideleve = $eleve"); // On sélectionne la ligne de la table inscription qui lie l'élève à la séance pour voir si il est déjà inscrit
					if(!$deja_inscrit_query)
					{
						echo "<br> Erreur: <br>".mysqli_error($connect);
						exit;
					}
					$deja_inscrit = mysqli_fetch_row($deja_inscrit_query);

					if (!$deja_inscrit)
					{
						$requete_inscription = "INSERT INTO inscription values ('$seance', '$eleve', null);"; // Si il n'y est pas encore inscrit, on l'y inscrit via cette requête

						$inscription = mysqli_query($connect, $requete_inscription);

						if(!$inscription)
						{
							echo "<br> Inscription impossible. La requête a échoué : <br>".mysqli_error($connect);
              exit;
						}
						echo "Inscription réussie !";

					}
					else
					{
						die("Erreur : cet élève est déjà inscrit à cette séance. </br>");
					}
				}
			}
		}

	?>


</body>
</html>
