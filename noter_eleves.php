<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Noter les élèves</titres></br></br>
	<subtitle>Confirmation de votre ajout :</subtitle></br></br>
	<?php
		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$seance = $_POST['seance'];

		include ('connexion.php');

		$infos_inscription_seance = mysqli_query($connect,"SELECT * FROM inscription WHERE idseance = $seance");

		foreach ($infos_inscription_seance as $eleve_inscrit)
		{
			$note_eleve_inscrit = $eleve_inscrit['note'];
			$erreur = $_POST[$note_eleve_inscrit];
			$note = 40 - $erreur;

			if ($erreur <= 40 && $erreur >= 0)
			{
				$ideleve = $eleve_inscrit['ideleve'];

				// Using prepared statement to prevent SQL injection
				$changer_note = mysqli_prepare($connect, "UPDATE `inscription` SET note_eleve = ? WHERE ideleve = ? AND idseance = ?");
				mysqli_stmt_bind_param($changer_note, "iii", $note, $ideleve, $seance);

				// Execute the prepared statement
				if(mysqli_stmt_execute($changer_note))
				{
					echo "<br>La note a été mise à jour avec succès.";
				}
				else
				{
					echo "<br>Impossible de changer la note. La requête a échoué : <br>" . mysqli_error($connect);
				}

				mysqli_stmt_close($changer_note);
			}
			else {
				echo "Vous avez spécifié un nombre d'erreurs supérieur à 40 ou inférieur à 0. Les notes de ces élèves ne seront pas changées.";
			}
		}

		echo "<table>";

		$confirmation = mysqli_query($connect,"SELECT * FROM inscription WHERE idseance = $seance");

		while ($confirmer = mysqli_fetch_array($confirmation, MYSQLI_NUM))
		{
			$id_dun_etu = $confirmer[1];
			$nom_etudiant_query = mysqli_query($connect, "SELECT * FROM eleves WHERE idetu = $id_dun_etu");
			$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQLI_NUM);

			if ($confirmer[2] == 50)
			{
				echo "<br><tr><td>".$nom_etudiant[1]." ".$nom_etudiant[2]." : </td><td>Non noté</td></tr>";
			}
			else
			{
				echo "<br><tr><td>".$nom_etudiant[1]." ".$nom_etudiant[2]." : </td><td>".$confirmer[2]." points sur 40</td></tr>";
			}
		}

		echo "</table>";
		mysqli_close($connect);
	?>
</body>
</html>
